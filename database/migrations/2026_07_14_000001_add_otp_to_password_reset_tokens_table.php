<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (! Schema::hasColumn('password_reset_tokens', 'otp')) {
                $table->string('otp', 6)->nullable()->after('token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('password_reset_tokens', 'otp')) {
                $table->dropColumn('otp');
            }
        });
    }
};
