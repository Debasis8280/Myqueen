<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_unique');
            $table->integer('user_id');
            $table->string('payment_method');
            $table->string('shipping_method');
            $table->string('user_ip');
            $table->string('order_currency');
            $table->integer('is_bill_same_ship')->default(0);
            $table->integer('billing_id');
            $table->integer('shipping_id')->nullable();
            $table->integer('status_id');
            $table->integer('quentity');
            $table->decimal('order_sum', 20, 5);
            $table->decimal('total_pv', 20, 2);
            $table->integer('in_house_status')->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('discount_amount', 20, 5)->nullable();
            $table->decimal('how_may_discount', 20, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('after_discount_price', 20, 5)->nullable();
            $table->decimal('shipping_charge', 20, 5)->nullable();
            $table->decimal('total', 20, 2);
            $table->integer('payment_status')->nullable();
            $table->integer('slef_pick_order_status')->default(0);
            $table->integer('status_for_matching_bonus')->default(0);
            $table->integer('status_for_direct_bonus')->default(0);
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
        Schema::dropIfExists('orders');
    }
}