@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-3xl font-extrabold mb-6 tracking-wide
                   text-cyan-600 dark:text-cyan-300">✏️ Topshiriqni Tahrirlash</h2>

        @if($errors->any())
            <div class="mb-4 p-4 rounded-lg
                        bg-red-100 border border-red-300 text-red-800
                        dark:bg-red-500/20 dark:border-red-500/50 dark:text-red-300">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('teacher.assignments.update', $assignment->id) }}" enctype="multipart/form-data"
              class="rounded-xl p-6 space-y-4
                     bg-white border border-slate-200
                     dark:bg-slate-800 dark:border-cyan-500/20">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-2
                              text-slate-700 dark:text-cyan-300">Mavzu *</label>
                <select name="material_id" required
                        class="w-full p-3 rounded-lg border focus:outline-none
                               bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                               dark:bg-slate-900 dark:text-slate-100 dark:border-cyan-500/20 dark:focus:border-cyan-400">
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}" {{ $assignment->material_id == $material->id ? 'selected' : '' }}>
                            {{ $material->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2
                              text-slate-700 dark:text-cyan-300">Sarlavha *</label>
                <input type="text" name="title" value="{{ old('title', $assignment->title) }}" required
                       placeholder="Topshiriq sarlavhasi"
                       class="w-full p-3 rounded-lg border focus:outline-none
                              bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                              dark:bg-slate-900 dark:text-slate-100 dark:border-cyan-500/20 dark:focus:border-cyan-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2
                              text-slate-700 dark:text-cyan-300">Tavsif</label>
                <textarea name="description" rows="4"
                          placeholder="Topshiriq tavsifi"
                          class="w-full p-3 rounded-lg border focus:outline-none
                                 bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                                 dark:bg-slate-900 dark:text-slate-100 dark:border-cyan-500/20 dark:focus:border-cyan-400">{{ old('description', $assignment->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2
                                  text-slate-700 dark:text-cyan-300">Muddati *</label>
                    <input type="datetime-local" name="deadline"
                           value="{{ old('deadline', \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d\TH:i')) }}" required
                           class="w-full p-3 rounded-lg border focus:outline-none
                                  bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                                  dark:bg-slate-900 dark:text-slate-100 dark:border-cyan-500/20 dark:focus:border-cyan-400">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2
                                  text-slate-700 dark:text-cyan-300">Maksimal Ball *</label>
                    <input type="number" name="max_score" value="{{ old('max_score', $assignment->max_score) }}" required min="1"
                           placeholder="100"
                           class="w-full p-3 rounded-lg border focus:outline-none
                                  bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                                  dark:bg-slate-900 dark:text-slate-100 dark:border-cyan-500/20 dark:focus:border-cyan-400">
                </div>
            </div>

            @if($assignment->file_path)
                <div class="p-3 rounded-lg
                            bg-slate-100 border border-slate-200
                            dark:bg-slate-900 dark:border-cyan-500/20">
                    <p class="text-sm mb-2 text-slate-500 dark:text-slate-400">Joriy fayl:</p>
                    <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank"
                       class="text-cyan-600 hover:text-cyan-500 dark:text-cyan-400 dark:hover:text-cyan-300">
                        📄 {{ pathinfo($assignment->file_path, PATHINFO_BASENAME) }}
                    </a>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium mb-2
                              text-slate-700 dark:text-cyan-300">
                    {{ $assignment->file_path ? 'Topshiriq Faylini Almashtirish' : 'Topshiriq Fayli (Ixtiyoriy)' }}
                </label>
                <input type="file" name="file"
                       accept=".pdf,.doc,.docx,.txt"
                       class="w-full p-3 rounded-lg border focus:outline-none
                              bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                              dark:bg-slate-900 dark:text-slate-300 dark:border-cyan-500/20 dark:focus:border-cyan-400">
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Qabul qilinadigan formatlar: PDF, DOC, DOCX, TXT (Maks: 10MB)</p>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="font-semibold px-6 py-3 rounded-lg transition shadow-lg
                               bg-cyan-500 text-white hover:bg-cyan-600
                               dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400 dark:shadow-[0_0_20px_rgba(34,211,238,0.4)]">
                    Topshiriqni Yangilash
                </button>
                <a href="{{ route('teacher.assignments.index', ['material_id' => $assignment->material_id]) }}"
                   class="font-semibold px-6 py-3 rounded-lg transition
                          bg-slate-200 text-slate-700 hover:bg-slate-300
                          dark:bg-slate-700 dark:text-slate-100 dark:hover:bg-slate-600">
                    Bekor Qilish
                </a>
            </div>
        </form>
    </div>
@endsection
