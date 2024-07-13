<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('order_ditempats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->json('product');
            $table->biginteger('price');
            $table->time('jam_pesan')->nullable();
            $table->date('tanggal_pesan')->nullable();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->foreign('table_id')->references('id')->on('tables');
            $table->string('status_bayar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

};
