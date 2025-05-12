<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('uri', 200);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('collection_id')->nullable()->constrained('collections')->nullOnDelete()->comment('Optional collection');
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete()->comment('Optional group');
            $table->foreignId('method_id')->constrained('http_methods')->comment('HTTP verb');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('endpoints');
    }
}; 