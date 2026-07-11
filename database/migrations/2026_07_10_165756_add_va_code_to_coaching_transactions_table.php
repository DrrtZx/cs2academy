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
        Schema::table('coaching_transactions', function (Blueprint $table) {
            $table->string('va_code', 20)->nullable()->after('package_price');
        });
    }

    public function down(): void
    {
        Schema::table('coaching_transactions', function (Blueprint $table) {
            $table->dropColumn('va_code');
        });
    }
};
