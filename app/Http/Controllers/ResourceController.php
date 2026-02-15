<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Fayl bilan ishlash uchun

class ResourceController extends Controller
{
    // Eslatma: Bu yerda security tekshiruvi (admin check) yo'q.

    // Ro'yxat (READ)
    public function index()
    {
        $resources = Resource::all();
        // Oddiy tekshiruv (Admin bo'lish shart emas)
        $isAdmin = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';

        return view('resources.index', compact('resources', 'isAdmin'));
    }

    // Yaratish formasi (CREATE view)
    public function create()
    {
        return view('resources.create');
    }

    // Ma'lumotni saqlash (CREATE action)
    public function store(Request $request)
    {
        // 1. Ma'lumotni tekshirish (Validation)
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,epub|max:20480', // 20MB limit
        ]);

        $filePath = null;
        // 2. Faylni yuklash
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('resources', 'public');
        }

        // 3. Ma'lumotlar bazasiga yozish
        Resource::create([
            'title' => $request->input('title'),
            'file_path' => $filePath,
        ]);

        return redirect()->route('resources.index')->with('success', 'Kitob muvaffaqiyatli qo\'shildi.');
    }

    // O'chirish (DELETE)
    public function destroy(Resource $resource)
    {
        // 1. Faylni serverdan o'chirish
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }

        // 2. Ma'lumotlar bazasidan o'chirish
        $resource->delete();

        return redirect()->route('resources.index')->with('success', 'Kitob muvaffaqiyatli o\'chirildi.');
    }
}
