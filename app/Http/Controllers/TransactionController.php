<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Utils\SubscriptionStatus;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create($id){
        try{
            $package = Package::where('id',decrypt($id))->first();
            $params = array(
                'ivp_method' => 'create',
                'ivp_store' => env('IVP_STORE_ID'),
                'ivp_authkey' => 'FmJq#sfCh9-BTRbp',
                'ivp_cart' => uniqid(mt_rand(), true),
                'ivp_test' => '1',
                'ivp_amount' => $package->price,
                'ivp_currency' => 'AED',
                'ivp_desc' => $package->description,
//                'ivp_framed ' => 2,
                'return_auth' => 'http://127.0.0.1:8000/transaction-success',
                'return_can' => 'http://127.0.0.1:8000/transaction-cancel',
                'return_decl' => 'http://127.0.0.1:8000/transaction-decline'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            $results = curl_exec($ch);
            curl_close($ch);
            $results = json_decode($results);
            if(isset( $results->order->url) && isset($results->order->ref)){
                session()->put('package_id',$id);
                session()->put('order_no',$results->order->ref);
                return redirect($results->order->url);
            }else{
                dd('Url not exits',$results);
            }
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return back();
        }catch (DecryptException $decryptException){
            dd($decryptException->getMessage());
            return back();
        }
    }


    public function success(Request $request){
        try {
            $order_no = session()->get('order_no');
            if(isset($order_no)){
                $params = array(
                    'ivp_method' => 'check',
                    'ivp_store' => env('IVP_STORE_ID'),
                    'ivp_authkey' => 'FmJq#sfCh9-BTRbp',
                    'order_ref' => $order_no,
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
                $results = curl_exec($ch);
                curl_close($ch);
                $results = json_decode($results);
                if(($results->order->status->code == 3) && ($results->order->transaction->status == "A" ||  $results->order->transaction->status == "H" )){
                    self::saveTransaction($results);
                    return redirect('/conformation');
                }
            }
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    protected function saveTransaction($transaction){
        try {
            $package = Package::where('id',decrypt(session()->get('package_id')))->first();
            Transaction::create([
                'order_id' => $transaction->order->ref ?? null,
                'cart_id' => $transaction->order->cartid ?? null,
                'test_mode' => $transaction->test ?? null,
                'amount' => $transaction->order->amount ?? null,
                'description' => $transaction->order->description ?? null,
                'billing_fname' => $transaction->order->customer->name->forenames ?? null,
                'billing_sname' => $transaction->order->customer->name->surname ?? null,
                'billing_address_1' => $transaction->order->customer->address->line1 ?? null,
                'billing_address_2' => $transaction->order->customer->address->line2 ?? null,
                'billing_city' => $transaction->order->customer->address->city ?? null,
                'billing_region' => $transaction->test ?? null,
                'billing_zip' => $transaction->order->customer->address->areacode ?? null,
                'billing_country' => $transaction->order->customer->address->country ?? null,
                'billing_email' => $transaction->order->customer->email ?? null,
                'status' => $transaction->order->status->text ?? null,
                'user_id' => Auth::id() ?? null,
                'package_id' => $package->id ?? null,
            ]);

            Subscription::create([
                'package_id' => $package->id,
                'status' => SubscriptionStatus::Approved,
                'user_id' => Auth::id(),
                'sanctions_balance' => $package->sanctions,
            ]);
            dump('Save Transaction');
        }catch (\Exception $exception){
            dd('Exception in save transaction',$exception->getMessage());
        }

    }
    public function cancel(Request $request){
        dump('In cancel');
        dd($request->all());
    }

    public function decline(Request $request){
        dump('In decline');
        dd($request->all());
    }

    protected function createSubscription($package){

    }
}