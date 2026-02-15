<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Models\Material;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'User is not admin');
        }
    }

    public function store(Request $request, Material $material)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'term' => 'required|string|max:255',
            'definition' => 'required|string',
        ]);

        $material->glossaries()->create($validated);
        return back()->with('success', 'Glossary term added.');
    }

    public function update(Request $request, Glossary $glossary)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'term' => 'required|string|max:255',
            'definition' => 'required|string',
        ]);

        $glossary->update($validated);
        return back()->with('success', 'Glossary term updated.');
    }

    public function destroy(Glossary $glossary)
    {
        $this->authorizeAdmin();

        $glossary->delete();
        return back()->with('success', 'Glossary term deleted.');
    }
}
