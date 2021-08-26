@extends('common.footer')
@extends('common.footer-script')
@extends('common.header')
@extends('common.navbar')

@section('content')
<section id="subscription-section" class="common-section">
    @include('common.side-bar')

    <div class="tab-content main-admin-content">
      <div id="subscription" class="home container-fluid tab-pane fade">
         <div class="content-div">
            <button class="open-sidebar"><i class="fa fa-bars" aria-hidden="true"></i></button>
            <h3>My Subscription</h3>
            <div class="table-div table-responsive">
            <table id="subscription_table" class="display">
                  <thead>
                     <tr>
                           <th>ID</th>
                           <th>Date</th>
                           <th>Package Name</th>
                           <th>Amount</th>
                           <th>Status</th>
                           <th>Expire Date</th>
                           <th>Balance Available</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                           <td>001</td>
                           <td>1 - July - 2021</td>
                           <td>Gold</td>
                           <td>AED 10</td>
                           <td><span class="approved">Approved</span></td>
                           <td>30 - August - 2022</td>
                           <td>1235689</td>
                     </tr>
                     <tr>
                           <td>002</td>
                           <td>1 - July - 2021</td>
                           <td>Silver</td>
                           <td>AED 20</td>
                           <td><span class="pending">Pending</span></td>
                           <td>30 - August - 2022</td>
                           <td>1235689</td>
                     </tr>
                     <tr>
                           <td>002</td>
                           <td>1 - July - 2021</td>
                           <td>Silver</td>
                           <td>AED 30</td>
                           <td><span class="expired">Expired</span></td>
                           <td>30 - August - 2022</td>
                           <td>1235689</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div id="account" class="home container-fluid tab-pane fade">
         <div class="content-div">
            <button class="open-sidebar"><i class="fa fa-bars" aria-hidden="true"></i></button>
            <h3>My Profile</h3>
            <div class="form-div">
               <form action="">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Company Name">
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Full Name">
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Eamil">
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Address">
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Country">
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Mobile Number">
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Password">
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="inputDiv">
                              <input type="text" class="form-control" placeholder="Confrim Password">
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <button>Update Profile</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div id="history" class="home container-fluid tab-pane active">
         <div class="content-div">
            <button class="open-sidebar"><i class="fa fa-bars" aria-hidden="true"></i></button>
               <h3>My Billing History</h3>
               <div class="table-div table-responsive">
                  <table id="history_table" class="display">
                      <thead>
                      <tr>
                          <th>Invoice #</th>
                          <th>Date</th>
                          <th>Package Name</th>
                          <th>Package Price</th>
                          <th>VAT</th>
                          <th>Total Amount</th>
                          <th>Status</th>
                          <th>Sanctions</th>
                          <th>Card #</th>
                          <th>Card Type</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($transactions as $item)
                          <tr>
                              <td>{{$item->invoice_id  ?: '-'}}</td>
                              <td>{{$item->created_at  ?: '-'}}</td>
                              <td>{{$item->package_name ?: '-'}}</td>
                              <td>{{$item->package_amount .' AED' ?: '-'}}</td>
                              <td>{{$item->vat_amount .' AED' ?: '-'}}</td>
                              <td>{{$item->total_amount .' AED' ?: '-'}}</td>
                              @if($item->status == 'Paid')
                                  <td><span class="approved">{{$item->status}}</span></td>
                              @else
                                  <td><span class="cancel">{{$item->status}}</span></td>
                              @endif
                              <td>{{$item->package_sanctions ?: '-'}}</td>
                              <td>{{$item->card_first6 ? $item->card_first6 .'******'. $item->card_last4 : '-'}}</td>
                              <td>{{$item->card_type ?: '-'}}</td>
                                @isset($item->pdf)
                                  <td>
                                      <a href="{{$item->pdf}}" download="">
                                          <i class="fa fa-file-pdf-o fa-3x" aria-hidden="true"></i>
                                      </a>
                                  </td>
                                @else
                                  <td>-</td>
                                @endisset
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
               </div>
            </div>
      </div>
      <div id="addCard" class="home container-fluid tab-pane fade">
         <div class="content-div">
            <button class="open-sidebar"><i class="fa fa-bars" aria-hidden="true"></i></button>
               <h3>Payment Method</h3>
{{--               <button data-toggle="modal" data-target="#addCardModal" class="addCadBtn">Add Card</button>--}}
               <div class="table-div table-responsive">
                    <table id="payment_table" class="display">
                     <thead>
                        <tr>
                              <th>Bank Name</th>
                              <th>Card Number</th>
                              <th>Date</th>
{{--                              <th>Action</th>--}}
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                              <td>Bank Islami</td>
                              <td>**** **** **** 1157</td>
                              <td>1 - July - 2021</td>
{{--                              <td data-toggle="modal" data-target="#deleteCard" class="removeText">Remove</td>--}}
                        </tr>
                        <tr>
                              <td>Alfalah Bank</td>
                              <td>**** **** **** 1157</td>
                              <td>1 - July - 2021</td>
{{--                              <td data-toggle="modal" data-target="#deleteCard" class="removeText">Remove</td>--}}
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
      </div>
    </div>
</section>
@endsection
