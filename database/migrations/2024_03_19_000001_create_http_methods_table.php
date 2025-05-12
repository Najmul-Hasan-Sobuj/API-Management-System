<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('http_methods', function (Blueprint $table) {
            $table->id();
            $table->enum('method', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('http_methods');
    }
}; 