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
        Schema::create('user_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->integer('question_index'); // Index of question in the tests JSON array
            $table->string('selected_answer'); // The answer selected by the user
            $table->boolean('is_correct')->default(false); // Whether the answer is correct
            $table->integer('earned_points')->default(0); // Points earned for this question
            $table->timestamps();

            // Ensure one answer per user per question
            $table->unique(['user_id', 'material_id', 'question_index']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_question_answers');
    }
};
