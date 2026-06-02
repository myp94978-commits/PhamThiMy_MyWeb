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
        Schema::create('posts', function (Blueprint $table) {
           $table->id(); // Khóa chính tự tăng
            $table->string('title', 200);
            $table->string('slug', 255)->unique(); 
            $table->text('content'); 
            $table->string('image', 200)->nullable(); 
            $table->tinyInteger('status')->default(1); 

            // Khóa ngoại tham chiếu bảng users
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('restrict'); 

            $table->timestamps(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
