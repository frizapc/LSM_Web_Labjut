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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->decimal('score', 5, 2)->default(0.00);
            $table
                ->foreignId('user_id')
                ->constrained(
                    table: 'users', indexName: 'score_user_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('course_id')
                ->constrained(
                    table: 'courses', indexName: 'score_course_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('exam_id')
                ->constrained(
                    table: 'exams', indexName: 'score_exam_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
