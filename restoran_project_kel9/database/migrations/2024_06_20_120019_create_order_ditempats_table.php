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
            $table->json('qty');
            $table->biginteger('price');
            $table->time('jam_pesan')->nullable();
            $table->date('tanggal_pesan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

};
