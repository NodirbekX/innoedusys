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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['midterm', 'final']);
            $table->integer('time_limit'); // in minutes
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->boolean('published')->default(false);
            $table->integer('total_attempts')->default(1);
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->cascadeOnDelete();
            $table->text('question_text');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->enum('correct_option', ['a', 'b', 'c', 'd']);
            $table->timestamps();
        });

        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('test_id')->constrained()->cascadeOnDelete();
            $table->integer('score');
            $table->timestamp('submitted_at');
            $table->timestamps();
            
            // Prevent duplicate submissions if needed, though strictly we manage by attempts logic
            // providing composite unique if strictly 1 attempt allowed per user per test
            // $table->unique(['user_id', 'test_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('tests');
    }
};
