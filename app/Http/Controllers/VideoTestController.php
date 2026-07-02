<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\UserQuestionAnswer;
use App\Models\VideoCompletion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoTestController extends Controller
{
    /**
     * Check answer for a question and save the result.
     */
    public function checkAnswer(Request $request, Material $material)
    {
        $request->validate([
            'question_index' => 'required|integer',
            'selected_answer' => 'required|string',
        ]);

        $user = Auth::user();
        $tests = $material->tests ?? [];
        $questionIndex = $request->question_index;

        // Check if question index is valid
        if (!isset($tests[$questionIndex])) {
            return response()->json([
                'success' => false,
                'message' => 'Savol topilmadi.',
            ], 404);
        }

        $question = $tests[$questionIndex];
        $selectedAnswer = $request->selected_answer;
        $correctAnswer = $question['correct'] ?? '';
        $points = $question['points'] ?? 1; // Default to 1 point if not specified

        // Check if answer is correct
        $isCorrect = trim(strtolower($selectedAnswer)) === trim(strtolower($correctAnswer));
        $earnedPoints = $isCorrect ? $points : 0;

        // Save or update the answer
        UserQuestionAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'material_id' => $material->id,
                'question_index' => $questionIndex,
            ],
            [
                'selected_answer' => $selectedAnswer,
                'is_correct' => $isCorrect,
                'earned_points' => $earnedPoints,
            ]
        );

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'earned_points' => $earnedPoints,
            'correct_answer' => $correctAnswer,
        ]);
    }

    /**
     * Save video progress (watched time).
     */
    public function saveProgress(Request $request, Material $material)
    {
        $request->validate([
            'watched_time' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $watchedTime = $request->watched_time;
        
        // Get video duration if available (you might need to calculate this)
        // For now, we'll track progress in a session or cache
        // This can be enhanced later with a video_progress table if needed

        return response()->json([
            'success' => true,
            'watched_time' => $watchedTime,
        ]);
    }

    /**
     * Calculate and save final score when video is completed.
     */
    public function completeVideo(Request $request, Material $material)
    {
        $user = Auth::user();
        $tests = $material->tests ?? [];

        // Get all answers for this user and material
        $answers = UserQuestionAnswer::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->get();

        // Calculate total earned points
        $earnedPoints = $answers->sum('earned_points');

        // Calculate total possible points
        $totalPoints = collect($tests)->sum(function ($test) {
            return $test['points'] ?? 1; // Default to 1 point if not specified
        });

        // Calculate percentage
        $percentage = $totalPoints > 0 ? ($earnedPoints / $totalPoints) * 100 : 0;

        // Save or update completion record
        VideoCompletion::updateOrCreate(
            [
                'user_id' => $user->id,
                'material_id' => $material->id,
            ],
            [
                'earned_points' => $earnedPoints,
                'total_points' => $totalPoints,
                'percentage' => round($percentage, 2),
                'is_completed' => true,
            ]
        );

        return response()->json([
            'success' => true,
            'earned_points' => $earnedPoints,
            'total_points' => $totalPoints,
            'percentage' => round($percentage, 2),
        ]);
    }

    /**
     * Get user's progress for a material.
     */
    public function getProgress(Material $material)
    {
        $user = Auth::user();

        $completion = VideoCompletion::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->first();

        $answers = UserQuestionAnswer::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->get()
            ->keyBy('question_index');

        return response()->json([
            'completion' => $completion,
            'answers' => $answers,
        ]);
    }
}
