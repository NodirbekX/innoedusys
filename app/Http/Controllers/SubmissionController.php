<?php

namespace App\Http\Controllers;

use App\Models\TeacherAssignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Store a newly created submission.
     */
    public function store(Request $request, TeacherAssignment $assignment)
    {
        $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
        
        if ($isTeacher) {
            abort(403, 'O\'qituvchilar topshiriqni topshira olmaydi.');
        }

        // Check if deadline has passed
        if (now()->greaterThan($assignment->deadline)) {
            return redirect()->back()
                ->with('error', 'Bu topshiriqning muddati o\'tgan.');
        }

        // Check if user already submitted
        $existingSubmission = Submission::where('assignment_id', $assignment->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingSubmission && $existingSubmission->isGraded()) {
            return redirect()->back()
                ->with('error', 'Siz allaqachon topshirdingiz va bu topshiriq baholandi.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,zip,rar|max:10240',
        ]);

        // Delete old submission if exists (allow resubmission before grading)
        if ($existingSubmission) {
            if ($existingSubmission->file_path && Storage::disk('public')->exists($existingSubmission->file_path)) {
                Storage::disk('public')->delete($existingSubmission->file_path);
            }
            $existingSubmission->delete();
        }

        $filePath = $request->file('file')->store('submissions', 'public');

        Submission::create([
            'assignment_id' => $assignment->id,
            'user_id' => auth()->id(),
            'file_path' => $filePath,
        ]);

        return redirect()->back()
            ->with('success', 'Topshiriq muvaffaqiyatli topshirildi.');
    }
}

