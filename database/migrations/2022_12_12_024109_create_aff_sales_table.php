<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aff_sales', function (Blueprint $table) {
            $table->id();
            $table->string('aff_id');
            $table->integer('order_id');
            $table->integer('total_amount');
            $table->integer('aff_amount');
            $table->tinyInteger('withdraw')->default(0)->comment('0: chưa rút, 1: đã rút');
            $table->tinyInteger('status')->default(0)->comment('0: pending, 1: hoàn thành');

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
        Schema::dropIfExists('aff_sales');
    }
}
