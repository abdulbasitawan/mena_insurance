<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelrTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->string('cart_id')->unique()->comment = 'The unique cart id to be submit for telr transaction';
            $table->string('order_id')->unique()->comment = 'Order id ';
//            $table->integer('store_id')->comment = 'Map to ivp_store';
            $table->boolean('test_mode')->nullable();
            $table->decimal('amount')->nullable()->comment = 'Map to ivp_amount the total or purchase';
            $table->string('description')->nullable()->comment = 'Description should be limit to 64';
//            $table->string('success_url')->comment = 'The success URL';
//            $table->string('canceled_url')->comment = 'The canceled URL';
//            $table->string('declined_url')->comment = 'The declined URL';
            $table->string('billing_fname')->nullable()->comment = 'Billing first name';
            $table->string('billing_sname')->nullable()->comment = 'Billing sur name';
            $table->string('billing_address_1')->nullable()->comment = 'Billing address 1';
            $table->string('billing_address_2')->nullable()->comment = 'Billing address 2';
            $table->string('billing_city')->nullable()->comment = 'Billing city';
            $table->string('billing_region')->nullable()->comment = 'Billing region';
            $table->string('billing_zip')->nullable()->comment = 'Billing zip';
            $table->string('billing_country')->nullable()->comment = 'Billing country';
            $table->string('billing_email')->nullable()->comment = 'Billing email';
            $table->string('lang_code')->nullable()->comment = 'Transaction Request lang';
            $table->string('trx_reference')->nullable()->comment = 'The transaction reference';
            $table->boolean('approved')->nullable()->comment = 'The transaction status is approved or failed';
            $table->json('response')->nullable()->comment = 'The transaction response';
            $table->string('status',10)->comment = 'The transaction status is updated or not';

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('packages');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
