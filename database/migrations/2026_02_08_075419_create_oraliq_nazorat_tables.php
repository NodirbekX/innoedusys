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
        Schema::create('oraliq_nazorat', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('deadline');
            $table->integer('max_score');
            $table->string('assignment_file');
            $table->timestamps();
        });

        Schema::create('oraliq_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oraliq_id')->constrained('oraliq_nazorat')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('solution_file');
            $table->integer('score')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            // One submission per user per assignment
            $table->unique(['oraliq_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oraliq_submissions');
        Schema::dropIfExists('oraliq_nazorat');
    }
};
