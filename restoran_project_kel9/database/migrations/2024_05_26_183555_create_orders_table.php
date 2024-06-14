<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('days');
            $table->time('start_time'); // add start_time
            $table->time('end_time');
            $table->string('name');
            $table->string('phone');
            $table->string('customer_email');
            $table->integer('qty');
            $table->bigInteger('total_price');  
            $table->enum('status', ['Unpaid', 'Paid']);
            $table->timestamps();
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }

// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Database\Migrations\Migration;

// return new class extends Migration
// {
//     public function up(): void
//     {
//         Schema::create('orders', function (Blueprint $table) {
//             $table->id();
//             $table->dateTime('days');
//             $table->dateTime('hours');
//             $table->string('name');
//             $table->string('phone');
//             $table->integer('qty');
//             $table->bigInteger('total_price');
//             $table->enum('status', ['Unpaid', 'Paid']);
//             $table->foreignId('table_id')->constrained()->onDelete('cascade');
//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('orders');
//     }
};
