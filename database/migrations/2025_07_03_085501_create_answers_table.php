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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('user_id')
                ->constrained(
                    table: 'users', indexName: 'answer_user_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('exam_id')
                ->constrained(
                    table: 'exams', indexName: 'exam_answer_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('question_id')
                ->constrained(
                    table: 'questions', indexName: 'question_answer_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('option_id')
                ->constrained(
                    table: 'options', indexName: 'option_answer_id'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
