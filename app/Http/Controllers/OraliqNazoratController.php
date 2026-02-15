<?php

namespace App\Http\Controllers;

use App\Models\OraliqNazorat;
use App\Models\OraliqSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OraliqNazoratController extends Controller
{
    private function isAdmin()
    {
        return auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
    }

    public function index()
    {
        $assignments = OraliqNazorat::withCount('submissions')
            ->with([
                'submissions' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->orderBy('deadline', 'desc')
            ->get();

        $totalMaxScore = OraliqNazorat::sum('max_score');
        $userGradedScore = \App\Models\OraliqSubmission::where('user_id', auth()->id())->sum('score');

        return view('oraliq.index', compact('assignments', 'totalMaxScore', 'userGradedScore'));
    }

    public function create()
    {
        if (!$this->isAdmin())
            abort(403);

        $currentTotal = OraliqNazorat::sum('max_score');
        return view('oraliq.create', compact('currentTotal'));
    }

    public function store(Request $request)
    {
        if (!$this->isAdmin())
            abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'max_score' => 'required|integer|min:1',
            'assignment_file' => 'required|file|mimes:pdf,docx,pptx|max:10240',
        ]);

        $currentTotal = OraliqNazorat::sum('max_score');
        if ($currentTotal + $request->max_score > 50) {
            return back()->withInput()->with('error', 'Umumiy ball 50 dan oshmasligi kerak (Hozirgi: ' . $currentTotal . ')');
        }

        $filePath = $request->file('assignment_file')->store('oraliq_assignments', 'public');

        OraliqNazorat::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'max_score' => $request->max_score,
            'assignment_file' => $filePath,
        ]);

        return redirect()->route('oraliq.index')->with('success', 'Oraliq nazorat muvaffaqiyatli yaratildi.');
    }

    public function edit(OraliqNazorat $oraliq)
    {
        if (!$this->isAdmin())
            abort(403);
        $currentTotal = OraliqNazorat::sum('max_score');
        return view('oraliq.edit', compact('oraliq', 'currentTotal'));
    }

    public function update(Request $request, OraliqNazorat $oraliq)
    {
        if (!$this->isAdmin())
            abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'max_score' => 'required|integer|min:1',
            'assignment_file' => 'nullable|file|mimes:pdf,docx,pptx|max:10240',
        ]);

        $currentTotalExceptThis = OraliqNazorat::where('id', '!=', $oraliq->id)->sum('max_score');
        if ($currentTotalExceptThis + $request->max_score > 50) {
            return back()->withInput()->with('error', 'Umumiy ball 50 dan oshmasligi kerak (Boshqalar: ' . $currentTotalExceptThis . ')');
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'max_score' => $request->max_score,
        ];

        if ($request->hasFile('assignment_file')) {
            Storage::disk('public')->delete($oraliq->assignment_file);
            $data['assignment_file'] = $request->file('assignment_file')->store('oraliq_assignments', 'public');
        }

        $oraliq->update($data);

        return redirect()->route('oraliq.index')->with('success', 'Oraliq nazorat muvaffaqiyatli yangilandi.');
    }

    public function show(OraliqNazorat $oraliq)
    {
        $userSubmission = OraliqSubmission::where('oraliq_id', $oraliq->id)
            ->where('user_id', auth()->id())
            ->first();

        $submissions = [];
        if ($this->isAdmin()) {
            $submissions = OraliqSubmission::with('user')
                ->where('oraliq_id', $oraliq->id)
                ->orderBy('submitted_at', 'desc')
                ->get();
        }

        return view('oraliq.show', compact('oraliq', 'userSubmission', 'submissions'));
    }

    public function submit(Request $request, OraliqNazorat $oraliq)
    {
        if ($this->isAdmin())
            return back()->with('error', 'Adminlar topshiriq yubora olmaydi.');

        // Check if already submitted
        $exists = OraliqSubmission::where('oraliq_id', $oraliq->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists)
            return back()->with('error', 'Siz allaqachon topshiriq yuborgansiz.');

        // Check deadline
        if (now()->isAfter($oraliq->deadline)) {
            return back()->with('error', 'Muddat tugagan. Topshiriq qabul qilinmaydi.');
        }

        $request->validate([
            'solution_file' => 'required|file|max:10240',
        ]);

        $filePath = $request->file('solution_file')->store('oraliq_submissions', 'public');

        OraliqSubmission::create([
            'oraliq_id' => $oraliq->id,
            'user_id' => auth()->id(),
            'solution_file' => $filePath,
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Topshiriq muvaffaqiyatli yuborildi.');
    }

    public function score(Request $request, OraliqSubmission $submission)
    {
        if (!$this->isAdmin())
            abort(403);

        $request->validate([
            'score' => 'required|integer|min:0|max:' . $submission->oraliqNazorat->max_score,
        ]);

        // Check if total score for this user would exceed 50 (actually it shouldn't if max scores are limited to 50, but let's be safe)
        // But the constraint is on max scores.

        $submission->update(['score' => $request->score]);

        return back()->with('success', 'Ball muvaffaqiyatli qo\'yildi.');
    }

    public function destroy(OraliqNazorat $oraliq)
    {
        if (!$this->isAdmin())
            abort(403);

        // Delete files
        Storage::disk('public')->delete($oraliq->assignment_file);
        foreach ($oraliq->submissions as $submission) {
            Storage::disk('public')->delete($submission->solution_file);
        }

        $oraliq->delete();
        return redirect()->route('oraliq.index')->with('success', 'Oraliq nazorat o\'chirildi.');
    }
}