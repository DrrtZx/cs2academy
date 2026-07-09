<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('judul'); // judul/topik tugas
            $table->text('tugas_teks'); // isi tugas atau link dari user
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->text('balasan_admin')->nullable(); // diisi oleh admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};