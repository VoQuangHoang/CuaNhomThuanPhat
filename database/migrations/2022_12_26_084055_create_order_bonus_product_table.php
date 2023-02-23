<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBonusProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_bonus_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_detail_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('product_bonus_id')->nullable();
            $table->integer('qty')->nullable();
            $table->foreign('order_detail_id')->references('id')
                ->on('order_detail')->onDelete('cascade');
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
        Schema::dropIfExists('order_bonus_product');
    }
}
