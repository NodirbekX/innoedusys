<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\TeacherAssignment;

class HomeController extends Controller
{
    /**
     * Display home page with materials list.
     */
    public function index()
    {
        $materials = Material::with('assignments')->get();
        $selectedMaterial = $materials->first();

        return view('home', compact('materials', 'selectedMaterial'));
    }

    /**
     * Show create material form.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created material.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400', // 100MB
            'presentation' => 'nullable|file|max:51200', // 50MB
            'description' => 'nullable|string',
            'tests' => 'nullable|array',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // Upload video
        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('videos', 'public');
        }

        // Upload presentation
        if ($request->hasFile('presentation')) {
            $file = $request->file('presentation');
            $originalName = $file->getClientOriginalName(); // original nom
            $path = $file->storeAs('presentations', $originalName, 'public');

            $data['presentation_path'] = $path;
        }

        // Save tests with time ⏱️ and points
        $tests = [];

        if ($request->tests) {
            foreach ($request->tests as $test) {
                if (
                    !empty($test['question']) &&
                    !empty($test['options']) &&
                    !empty($test['correct']) &&
                    isset($test['time'])
                ) {
                    $tests[] = [
                        'question' => $test['question'],
                        'options' => array_filter(array_map('trim', explode("\n", $test['options']))),
                        'correct' => $test['correct'],
                        'time' => (int) $test['time'], // seconds
                        'points' => isset($test['points']) ? (int) $test['points'] : 1, // Default to 1 point if not specified
                    ];
                }
            }
        }

        $data['tests'] = $tests;
        Material::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mavzu muvaffaqiyatli yaratildi.',
                'redirect' => route('home.index')
            ]);
        }

        return redirect()->route('home.index')
            ->with('success', 'Mavzu muvaffaqiyatli yaratildi.');
    }

    /**
     * Show selected material.
     */
    public function show(Material $home)
    {
        $materials = Material::with('assignments')->get();
        $selectedMaterial = $home->load('assignments');

        return view('home', compact('materials', 'selectedMaterial'));
    }

    /**
     * Show edit form.
     */
    public function edit(Material $home)
    {
        return view('materials.edit', compact('home'));
    }

    /**
     * Update material.
     */
    public function update(Request $request, Material $home)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv',
            'presentation' => 'nullable|file|mimes:pdf,ppt,pptx',
            'description' => 'nullable|string',
            'tests' => 'nullable|array',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // Update video
        if ($request->hasFile('video')) {
            if ($home->video_path && file_exists(storage_path('app/public/' . $home->video_path))) {
                unlink(storage_path('app/public/' . $home->video_path));
            }
            $data['video_path'] = $request->file('video')->store('videos', 'public');
        }

        // Update presentation
        if ($request->hasFile('presentation')) {
            // Delete old file if exists
            if ($home->presentation_path && file_exists(storage_path('app/public/' . $home->presentation_path))) {
                unlink(storage_path('app/public/' . $home->presentation_path));
            }

            $file = $request->file('presentation');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('presentations', $originalName, 'public');

            $data['presentation_path'] = $path;
        }

        // Update tests with time ⏱️ and points
        $tests = [];

        if ($request->tests) {
            foreach ($request->tests as $test) {
                if (
                    !empty($test['question']) &&
                    !empty($test['options']) &&
                    !empty($test['correct']) &&
                    isset($test['time'])
                ) {
                    $tests[] = [
                        'question' => $test['question'],
                        'options' => array_filter(array_map('trim', explode("\n", $test['options']))),
                        'correct' => $test['correct'],
                        'time' => (int) $test['time'],
                        'points' => isset($test['points']) ? (int) $test['points'] : 1, // Default to 1 point if not specified
                    ];
                }
            }
        }

        $data['tests'] = $tests;

        $home->update($data);

        return redirect()->route('home.show', $home->id)
            ->with('success', 'Mavzu muvaffaqiyatli yangilandi.');
    }

    /**
     * Delete material.
     */
    public function destroy(Material $home)
    {
        if ($home->video_path && file_exists(storage_path('app/public/' . $home->video_path))) {
            unlink(storage_path('app/public/' . $home->video_path));
        }

        if ($home->presentation_path && file_exists(storage_path('app/public/' . $home->presentation_path))) {
            unlink(storage_path('app/public/' . $home->presentation_path));
        }

        $home->delete();

        return redirect()->route('home.index')
            ->with('success', 'Mavzu muvaffaqiyatli o‘chirildi.');
    }
}
