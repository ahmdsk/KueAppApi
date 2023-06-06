<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->integer('quantity');
            $table->integer('price');
            $table->foreignId('user_id');
            $table->foreignId('cake_id');
            $table->foreignId('store_id');
            $table->foreignId('voucher_id')->nullable();
            $table->foreignId('payment_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cake_id')->references('id')->on('cakes');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
            $table->foreign('payment_id')->references('id')->on('payments');
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
};
