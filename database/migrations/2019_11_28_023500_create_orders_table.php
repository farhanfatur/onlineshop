<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->date('dateorder');

            $table->unsignedBigInteger('buyer_id');
            $table->enum('is_receive', ['1', '0']);
            $table->enum('is_paymentreceive', ['1', '0']);
            $table->enum('is_paymentfrombuyer', ['1', '0']);
            $table->enum('is_shipped', ['1', '0']);
            $table->enum('is_cancel', ['1', '0']);
            $table->enum('cancelfrombuyer', ['1', '0'])->nullable();
            
            $table->string('address');
            $table->string('imagepayment');
            $table->date('dateshipped');

            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
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
