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
        Schema::create('cakes', function (Blueprint $table) {
            $table->id();
            $table->string('cake_name');
            $table->string('cake_image');
            $table->integer('cake_price');
            $table->text('description')->nullable();
            $table->integer('cake_width')->nullable();
            $table->integer('cake_height')->nullable();
            $table->foreignId('cake_id');
            $table->timestamps();

            $table->foreign('cake_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cakes');
    }
};
