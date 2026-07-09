<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->text('body');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->text('pertanyaan');
            $table->json('opsi'); // array 4 pilihan
            $table->integer('jawaban_benar'); // index 0-3
            $table->text('penjelasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('courses');
    }
};