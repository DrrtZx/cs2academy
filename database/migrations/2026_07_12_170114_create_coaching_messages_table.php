<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel pesan chat coaching
        Schema::create('coaching_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Kolom completed_at di assignments (jika belum ada)
        Schema::table('assignments', function (Blueprint $table) {
            if (!Schema::hasColumn('assignments', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coaching_messages');
        Schema::table('assignments', function (Blueprint $table) {
            if (Schema::hasColumn('assignments', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
        });
    }
};
