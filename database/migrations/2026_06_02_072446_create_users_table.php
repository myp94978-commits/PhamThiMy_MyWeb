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
        Schema::create('users', function (Blueprint $table) {
           $table->id(); 
            $table->string('fullname', 100); 
            $table->string('username', 30)->unique(); 
            $table->string('email', 50)->unique(); 
            $table->string('password', 200); 
            $table->string('phone', 20)->unique(); 
            $table->string('address', 255)->nullable();
            $table->unsignedTinyInteger('gender'); // Giới tính (1: Nam, 2: Nữ, 0: Không cung cấp)
            $table->date('birthday')->nullable(); // Ngày sinh
            $table->unsignedTinyInteger('role'); 
            $table->tinyInteger('status')->default(1); 

            $table->timestamps(); 
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
