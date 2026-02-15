<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;

class AdminTestController extends Controller
{
    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $midterms = Test::midterm()->orderBy('created_at', 'desc')->get();
        $finals = Test::final()->orderBy('created_at', 'desc')->get();
        return view('admin.tests.index', compact('midterms', 'finals'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.tests.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:midterm,final',
            'time_limit' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'total_attempts' => 'required|integer|min:1',
        ]);

        $test = Test::create($validated);

        return redirect()->route('admin.tests.show', $test)->with('success', 'Test created successfully.');
    }

    public function show(Test $test)
    {
        $this->authorizeAdmin();
        $test->load('questions');
        return view('admin.tests.show', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_limit' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'total_attempts' => 'required|integer|min:1',
        ]);

        $test->update($validated);
        return back()->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $this->authorizeAdmin();
        $test->delete();
        return redirect()->route('admin.tests.index')->with('success', 'Test deleted.');
    }

    public function publish(Test $test)
    {
        $this->authorizeAdmin();
        $test->update(['published' => !$test->published]);
        $status = $test->published ? 'published' : 'unpublished';
        return back()->with('success', "Test $status successfully.");
    }

    public function storeQuestion(Request $request, Test $test)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $test->questions()->create($validated);
        return back()->with('success', 'Question added.');
    }

    public function destroyQuestion(Question $question)
    {
        $this->authorizeAdmin();
        $question->delete();
        return back()->with('success', 'Question deleted.');
    }

    public function results(Test $test)
    {
        $this->authorizeAdmin();
        $results = $test->testResults()->with('user')->orderBy('score', 'desc')->get();
        return view('admin.tests.results', compact('test', 'results'));
    }
}
