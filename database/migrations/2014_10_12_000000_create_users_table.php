<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('country_code');
            $table->integer('phone');
            $table->integer('is_mlm_member')->default(0);
            $table->integer('rank_id')->default(0);
            $table->string('left_id')->nullable();
            $table->string('right_id')->nullable();
            $table->integer('left_row_count')->default(0);
            $table->integer('right_row_count')->default(0);
            $table->integer('total_pv_point')->default(0);
            $table->decimal('total_direct_dponsor', 20, 2)->default(0);
            $table->decimal('wallet', 20, 2);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}