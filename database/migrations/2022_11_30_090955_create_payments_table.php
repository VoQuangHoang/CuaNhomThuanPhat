<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_name', 255)->nullable();
            $table->text('url_pay')->nullable();
            $table->text('vnp_TmnCode')->nullable();
            $table->text('vnp_HashSecret')->nullable();
            $table->text('partnercode')->nullable();
            $table->text('accesskey')->nullable();
            $table->text('secretkey')->nullable();
            $table->integer('status')->nullable();
            $table->integer('production_test')->nullable();
            $table->text('type')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
