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
        Schema::create('video_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->integer('earned_points')->default(0); // Total points earned
            $table->integer('total_points')->default(0); // Total possible points
            $table->decimal('percentage', 5, 2)->default(0); // Percentage score (0-100)
            $table->boolean('is_completed')->default(false); // Whether video was fully watched
            $table->timestamps();

            // Ensure one completion record per user per material
            $table->unique(['user_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_completions');
    }
};
