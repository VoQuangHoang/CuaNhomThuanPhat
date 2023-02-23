<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_payment', function (Blueprint $table) {
            $table->id();
            $table->text('ma_website')->nullable();
            $table->text('ma_gd')->nullable();
            $table->string('ma_dh')->nullable();
            $table->text('so_hd')->nullable();
            $table->text('so_tien')->nullable();
            $table->string('ngan_hang')->nullable();
            $table->text('noidung_tt')->nullable();
            $table->string('trang_thai')->nullable();
            $table->string('ngay_tao')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('type_payment')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('log_payment');
    }
}
