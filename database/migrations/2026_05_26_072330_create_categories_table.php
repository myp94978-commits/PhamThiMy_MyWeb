<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('cateid'); 
            $table->string('catename', 100)->unique(); 
            $table->string('slug', 150)->unique(); 
            $table->string('image')->nullable(); 
            $table->tinyInteger('status')->default(1); 
            $table->integer('sort_order')->default(0); 
            $table->text('description')->nullable(); 
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
