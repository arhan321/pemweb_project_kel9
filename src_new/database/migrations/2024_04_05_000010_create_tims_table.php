<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimsTable extends Migration
{
    public function up()
    {
        Schema::create('tims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('position');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
