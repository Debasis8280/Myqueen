<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('sponsors_id');
            $table->string('member_id');
            $table->string('member_name');
            $table->integer('rank_id');
            $table->decimal('point', 20, 2);
            $table->integer('order_id')->nullable();
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
        Schema::dropIfExists('direct_sponsors');
    }
}