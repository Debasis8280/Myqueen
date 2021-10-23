<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('pv');
            $table->longText('usemethod')->nullable();
            $table->string('size');
            $table->longText('description')->nullable();
            $table->longText('productimagee');
            $table->longText('productimagec')->nullable();
            $table->longText('galleryimagee')->nullable();
            $table->longText('galleryimagec')->nullable();
            $table->longText('shopbannere')->nullable();
            $table->longText('shopbannerc')->nullable();
            $table->integer('status')->default(0);
            $table->integer('category_id');
            $table->string('regularprice');
            $table->string('saleprice');
            $table->string('offerprice')->nullable();
            $table->string('pagetitle')->nullable();
            $table->string('pageurl')->nullable();
            $table->string('metadescription')->nullable();
            $table->string('metakeyword')->nullable();
            $table->string('stock');
            $table->longText('features')->nullable();
            $table->string('videotitle')->nullable();
            $table->string('videosource')->nullable();
            $table->longText('main_components_image_eng')->nullable();
            $table->longText('main_components_image_chn')->nullable();
            $table->longText('effects_image_eng')->nullable();
            $table->longText('effects_image_chn')->nullable();
            $table->longText('method_image_eng')->nullable();
            $table->longText('method_image_chn')->nullable();
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
        Schema::dropIfExists('products');
    }
}