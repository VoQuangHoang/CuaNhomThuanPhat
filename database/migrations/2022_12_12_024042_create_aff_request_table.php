<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aff_request', function (Blueprint $table) {
            $table->id();
            $table->string('aff_id');
            $table->integer('amount');
            $table->string('bank_name', '255');
            $table->string('bank_number', '50');
            $table->string('holder_name', '50');
            $table->integer('status')->comment('0: pending, 1: đã xử lý xong');
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
        Schema::dropIfExists('aff_request');
    }
}
