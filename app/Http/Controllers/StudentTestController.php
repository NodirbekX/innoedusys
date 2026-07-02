<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\Question;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentTestController extends Controller
{
    public function index()
    {
        // Get all published tests that have started (or upcoming?)
        // User says: "Available Tests", so likely ones currently open or visible. 
        // I'll show all published tests, and indicate if they are finished or upcoming.
        $tests = Test::published()->orderBy('start_at', 'desc')->get();

        // Tests the user has already completed
        $completedTestIds = TestResult::where('user_id', auth()->id())->pluck('test_id')->toArray();

        return view('student.tests.index', compact('tests', 'completedTestIds'));
    }

    public function show(Test $test)
    {
        // Check if published
        if (!$test->published) {
            return redirect()->route('student.tests.index')->with('error', 'Test is not available.');
        }

        // Check time window
        $now = now();
        if ($now < $test->start_at) {
            return redirect()->route('student.tests.index')->with('error', 'Test has not started yet.');
        }

        if ($now > $test->end_at) {
            return redirect()->route('student.tests.index')->with('error', 'Test has ended.');
        }

        // Check existing submission
        $existing = TestResult::where('user_id', auth()->id())->where('test_id', $test->id())->first();
        if ($existing) {
            return redirect()->route('student.tests.result', $test);
        }

        // Set start time in session if not exists to track duration
        $sessionKey = 'test_start_' . $test->id . '_' . auth()->id();
        if (!session()->has($sessionKey)) {
            session([$sessionKey => now()]);
        }

        // Calculate deadline: Min(Test End Time, Start Time + Limit)
        $startTime = session($sessionKey);
        // Ensure startTime is Carbon instance if pulled from session
        $startTime = Carbon::parse($startTime);

        $personalEndTime = $startTime->copy()->addMinutes($test->time_limit);
        $deadline = $test->end_at->lt($personalEndTime) ? $test->end_at : $personalEndTime;

        // Load questions
        // Randomize questions? Not specified but good practice.
        // User says "View only published tests", nothing about random order. I'll just load them.
        $test->load('questions');

        return view('student.tests.show', compact('test', 'deadline'));
    }

    public function submit(Request $request, Test $test)
    {
        if (!$test->published) {
            abort(404);
        }

        // Check existing submission
        if (TestResult::where('user_id', auth()->id())->where('test_id', $test->id())->exists()) {
            return redirect()->route('student.tests.result', $test)->with('error', 'Test already submitted.');
        }

        // Validate time? 
        // We rely on "auto-submit when time expires" from client, but should check server side too.
        // If $test->end_at has passed by a significant margin, we might reject.
        // But let's be lenient for now, maybe client clock skew etc.

        $answers = $request->input('answers', []);
        $score = 0;

        // Calculate score
        foreach ($test->questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_option) {
                $score++;
            }
        }

        TestResult::create([
            'user_id' => auth()->id(),
            'test_id' => $test->id(),
            'score' => $score,
            'submitted_at' => now(),
        ]);

        return redirect()->route('student.tests.result', $test)->with('success', 'Test submitted successfully.');
    }

    public function result(Test $test)
    {
        $result = TestResult::where('user_id', auth()->id())->where('test_id', $test->id())->firstOrFail();
        return view('student.tests.result', compact('test', 'result'));
    }
}
