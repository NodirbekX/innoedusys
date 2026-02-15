<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('yakuniy_settings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();
        });

        Schema::create('yakuniy_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->integer('score')->default(1);
            $table->timestamps();
        });

        Schema::create('yakuniy_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('yakuniy_questions')->onDelete('cascade');
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('yakuniy_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_score')->default(0);
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique('user_id'); // One attempt per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yakuniy_results');
        Schema::dropIfExists('yakuniy_options');
        Schema::dropIfExists('yakuniy_questions');
        Schema::dropIfExists('yakuniy_settings');
    }
};
