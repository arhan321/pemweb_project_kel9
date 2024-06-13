<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_customer');
            $table->string('jumlah_orang');
            $table->datetime('start_book');
            $table->datetime('finish_book');
            $table->string('category');
            $table->string('customer_email');
            $table->string('phone');
            $table->bigInteger('total_price');
            $table->string('status')->nullable();
            // $table->unsignedBigInteger('table_id')->index(); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('table_id')->constrained()->onDelete('cascade');// Menambahkan foreign key constraint
        });
    }
}
