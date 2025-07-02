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
        Schema::create('session_exams', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('user_id')
                ->constrained(
                    table: 'users', indexName: 'session_user_exam_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('exam_id')
                ->constrained(
                    table: 'exams', indexName: 'session_exam_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamp('completed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_exams');
    }
};
