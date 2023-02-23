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
            $table->text('name')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->text('slug')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->text('image')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->integer('price_sale')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1:active, 2:pending, 3:trash');
            $table->tinyInteger('sale')->nullable();
            $table->tinyInteger('instock')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('capacity')->nullable();
            $table->text('more_image')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onDelete('cascade');
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
