<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('collection_endpoint', function (Blueprint $table) {
            $table->foreignId('collection_id')->constrained('collections')->cascadeOnDelete();
            $table->foreignId('endpoint_id')->constrained('endpoints')->cascadeOnDelete();
            $table->primary(['collection_id', 'endpoint_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('collection_endpoint');
    }
}; 