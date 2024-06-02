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
            $table->string('status')->nullable();
            $table->unsignedBigInteger('table_id'); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade'); // Menambahkan foreign key constraint
        });
    }
}
