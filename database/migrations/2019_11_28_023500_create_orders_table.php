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
            $table->enum('is_shipped', ['1', '0']);
            $table->enum('is_cancel', ['1', '0']);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('bank_id');
            $table->string('address');
            $table->string('imagepayment');

            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
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
