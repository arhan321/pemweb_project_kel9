<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('days');
            $table->time('hours');
            $table->string('name');
            $table->string('phone');
            $table->integer('qty');
            $table->bigInteger('total_price');
            $table->enum('status', ['Unpaid', 'Paid']);
            $table->timestamps();
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
