<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMLMRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_l_m_registers', function (Blueprint $table) {
            $table->id();
            $table->integer('ranking');
            $table->integer('branch_id');
            $table->string('member_id');
            $table->string('member_name');
            $table->string('postcode')->nullable();
            $table->string('nationality');
            $table->string('sponser_id');
            $table->integer('placement_id');
            $table->integer('placement');
            $table->string('street_address')->nullable();
            $table->string('office_contact_no')->nullable();
            $table->string('home_contact_no')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('birthday')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('payment_information')->nullable();
            $table->string('branch')->nullable();
            $table->string('account_no')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('m_l_m_registers');
    }
}