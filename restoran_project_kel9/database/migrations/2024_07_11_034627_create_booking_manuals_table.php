<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_manuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_customer');
            $table->integer('jumlah_orang'); 
            $table->datetime('start_book');
            $table->datetime('finish_book');
            $table->string('category');
            $table->string('customer_email');
            $table->string('phone');
            $table->bigInteger('total_price');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->foreign('table_id')->references('id')->on('tables');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
