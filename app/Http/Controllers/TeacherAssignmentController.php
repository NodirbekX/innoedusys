<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherAssignmentController extends Controller
{
    /**
     * Display a listing of assignments for a material.
     */
    public function index(Request $request)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        // Load all materials for the sidebar
        $materials = Material::with('assignments')->get();
        
        // Get selected material ID from request
        $selectedMaterialId = $request->get('material_id');
        
        // If no material selected but materials exist, select first one by default
        // (This will be handled by JavaScript to avoid redirect loops, but we set it for initial display)
        if (!$selectedMaterialId && $materials->count() > 0) {
            $selectedMaterialId = $materials->first()->id;
        }

        return view('teacher.assignments.index', compact('materials', 'selectedMaterialId'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create(Request $request)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        $materialId = $request->get('material_id');
        
        if (!$materialId) {
            return redirect()->route('home.index')
                ->with('error', 'Iltimos, avval mavzuni tanlang.');
        }

        $material = Material::findOrFail($materialId);

        return view('teacher.assignments.create', compact('material'));
    }

    /**
     * Store a newly created assignment.
     */
    public function store(Request $request)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after:now',
            'max_score' => 'required|integer|min:1',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $data = [
            'material_id' => $request->material_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'max_score' => $request->max_score,
        ];

        // Upload assignment file if provided
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        TeacherAssignment::create($data);

        return redirect()->route('home.show', $request->material_id)
            ->with('success', 'Topshiriq muvaffaqiyatli yaratildi.');
    }

    /**
     * Show the form for editing an assignment.
     */
    public function edit(TeacherAssignment $assignment)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        $materials = Material::all();

        return view('teacher.assignments.edit', compact('assignment', 'materials'));
    }

    /**
     * Update the specified assignment.
     */
    public function update(Request $request, TeacherAssignment $assignment)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after:now',
            'max_score' => 'required|integer|min:1',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $data = [
            'material_id' => $request->material_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'max_score' => $request->max_score,
        ];

        // Update assignment file if provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update($data);

        return redirect()->route('teacher.assignments.index', ['material_id' => $assignment->material_id])
            ->with('success', 'Topshiriq muvaffaqiyatli yangilandi.');
    }

    /**
     * Remove the specified assignment.
     */
    public function destroy(TeacherAssignment $assignment)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        // Delete file if exists
        if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $materialId = $assignment->material_id;
        $assignment->delete();

        return redirect()->route('teacher.assignments.index', ['material_id' => $materialId])
            ->with('success', 'Topshiriq muvaffaqiyatli o\'chirildi.');
    }

    /**
     * Show all submissions for an assignment.
     */
    public function showSubmissions(TeacherAssignment $assignment)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        $submissions = $assignment->submissions()->with('user')->latest()->get();

        return view('teacher.assignments.submissions', compact('assignment', 'submissions'));
    }

    /**
     * Score a submission.
     */
    public function score(Request $request, $submissionId)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if (!$isTeacher) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        $submission = \App\Models\Submission::findOrFail($submissionId);
        $assignment = $submission->assignment;

        // Ensure score doesn't exceed max_score
        $score = min($request->score, $assignment->max_score);
        
        $submission->update(['score' => $score]);

        return redirect()->route('teacher.assignments.submissions', $assignment->id)
            ->with('success', 'Ball muvaffaqiyatli yangilandi.');
    }
}

