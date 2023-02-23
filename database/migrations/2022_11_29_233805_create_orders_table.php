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
            $table->unsignedBigInteger('customer_id');
            $table->string('sku')->nullable();
            $table->integer('payment_type')->comment('1:cod, 2:bank');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('ward_id')->nullable();
            $table->text('note')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->integer('total_weight')->nullable();
            $table->integer('shipping_fee')->nullable();
            $table->integer('status')->comment('1:đã thanh toán, 2:chưa thanh toán');
            $table->foreign('customer_id')
                ->references('id')->on('customer')
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
        Schema::dropIfExists('orders');
    }
}
