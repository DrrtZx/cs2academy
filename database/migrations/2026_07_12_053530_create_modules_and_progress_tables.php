<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Tambah kolom ke courses (skip kalau sudah ada) ──
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'level')) {
                $table->string('level')->nullable()->after('body');
            }
            if (!Schema::hasColumn('courses', 'durasi')) {
                $table->string('durasi')->nullable()->after('level');
            }
            if (!Schema::hasColumn('courses', 'type')) {
                $table->string('type')->nullable()->after('durasi');
            }
            if (!Schema::hasColumn('courses', 'is_popular')) {
                $table->boolean('is_popular')->default(false)->after('type');
            }
        });

        // ── Module ──
        if (!Schema::hasTable('modules')) {
            Schema::create('modules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('body')->nullable();
                $table->string('youtube_url')->nullable();
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });
        }

        // ── Progress per modul ──
        if (!Schema::hasTable('module_progress')) {
            Schema::create('module_progress', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('module_id')->constrained()->cascadeOnDelete();
                $table->integer('score')->default(0);
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                $table->unique(['user_id', 'module_id']);
            });
        }

        // ── Tambah module_id ke quizzes ──
        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'module_id')) {
                $table->foreignId('module_id')->nullable()->after('course_id')->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'module_id')) {
                $table->dropForeign(['module_id']);
                $table->dropColumn('module_id');
            }
        });
        Schema::dropIfExists('module_progress');
        Schema::dropIfExists('modules');
        Schema::table('courses', function (Blueprint $table) {
            foreach (['level', 'durasi', 'type', 'is_popular'] as $col) {
                if (Schema::hasColumn('courses', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
