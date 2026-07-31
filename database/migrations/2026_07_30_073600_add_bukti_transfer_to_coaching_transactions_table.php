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
            $table->string('bukti_transfer')->nullable()->after('status');
            $table->timestamp('bukti_uploaded_at')->nullable()->after('bukti_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coaching_transactions', function (Blueprint $table) {
            $table->dropColumn(['bukti_transfer', 'bukti_uploaded_at']);
        });
    }
};
