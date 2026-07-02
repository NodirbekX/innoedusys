<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Models\Material;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    private function authorizeTeacher()
{
    if (!auth()->user() || !auth()->user()->isTeacher()) {
        abort(403, 'User is not teacher');
    }
}

    public function store(Request $request, Material $material)
    {
$this->authorizeTeacher();
        $validated = $request->validate([
            'term' => 'required|string|max:255',
            'definition' => 'required|string',
        ]);

        $material->glossaries()->create($validated);
        return back()->with('success', 'Glossary term added.');
    }

    public function update(Request $request, Glossary $glossary)
    {
$this->authorizeTeacher();
        $validated = $request->validate([
            'term' => 'required|string|max:255',
            'definition' => 'required|string',
        ]);

        $glossary->update($validated);
        return back()->with('success', 'Glossary term updated.');
    }

    public function destroy(Glossary $glossary)
    {
$this->authorizeTeacher();
        $glossary->delete();
        return back()->with('success', 'Glossary term deleted.');
    }
}
