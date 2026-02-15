@extends('layouts.layout')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <div class="mb-6">
            <a href="{{ route('teacher.assignments.index', ['material_id' => $assignment->material_id]) }}"
               class="inline-block mb-4 transition
                      text-cyan-600 hover:text-cyan-500
                      dark:text-cyan-400 dark:hover:text-cyan-300">
                ← Topshiriqlarga Qaytish
            </a>
            <h2 class="text-3xl font-extrabold tracking-wide mb-2
                       text-cyan-600 dark:text-cyan-300">
                📥 Topshirilganlar – {{ $assignment->title }}
            </h2>
            <div class="text-sm text-slate-600 dark:text-slate-400">
                <p>📚 Mavzu: <span class="text-slate-700 dark:text-slate-300">{{ $assignment->material->title }}</span></p>
                <p>⏰ Muddati: <span class="text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}</span></p>
                <p>🎯 Maksimal Ball: <span class="text-slate-700 dark:text-slate-300">{{ $assignment->max_score }}</span></p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg
                        bg-green-100 border border-green-300 text-green-800
                        dark:bg-green-500/20 dark:border-green-500/50 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($submissions->count() > 0)
            <div class="space-y-4">
                @foreach($submissions as $submission)
                    <div class="scan relative rounded-xl p-6 overflow-hidden transition-all duration-300
                                bg-white border border-slate-200
                                dark:bg-slate-800 dark:border-cyan-500/20 dark:hover:border-cyan-400 dark:hover:shadow-[0_0_25px_rgba(34,211,238,0.25)]">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold
                                                bg-cyan-100 text-cyan-600
                                                dark:bg-cyan-500/20 dark:text-cyan-300">
                                        {{ strtoupper(substr($submission->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-cyan-700 dark:text-cyan-200">{{ $submission->user->name }}</p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $submission->user->email }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p class="text-sm mb-1 text-slate-500 dark:text-slate-500">Topshirilgan vaqti:</p>
                                    <p class="text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y, H:i') }}</p>
                                </div>

                                <a href="{{ asset('storage/' . $submission->file_path) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 transition mb-4
                                          text-cyan-600 hover:text-cyan-500
                                          dark:text-cyan-400 dark:hover:text-cyan-300">
                                    <span>📄</span>
                                    <span>Topshirilganni Yuklab Olish</span>
                                    <span class="text-xs">({{ pathinfo($submission->file_path, PATHINFO_BASENAME) }})</span>
                                </a>

                                @if($submission->isGraded())
                                    <div class="mt-3 p-3 rounded-lg
                                                bg-green-100 border border-green-200
                                                dark:bg-green-500/10 dark:border-green-500/30">
                                        <p class="text-sm text-green-700 dark:text-green-300">
                                            ✅ Baholandi: <span class="font-bold">{{ $submission->score }} / {{ $assignment->max_score }}</span>
                                        </p>
                                        <p class="text-xs mt-1 text-slate-500 dark:text-slate-400">
                                            Baholangan vaqti: {{ \Carbon\Carbon::parse($submission->updated_at)->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                @else
                                    <div class="mt-3 p-3 rounded-lg
                                                bg-yellow-50 border border-yellow-200
                                                dark:bg-yellow-500/10 dark:border-yellow-500/30">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">⏳ Baholash Kutilmoqda</p>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-6">
                                <form action="{{ route('teacher.assignments.score', $submission->id) }}"
                                      method="POST"
                                      class="p-4 rounded-lg border
                                             bg-slate-50 border-slate-200
                                             dark:bg-slate-900 dark:border-cyan-500/20">
                                    @csrf
                                    <label class="block text-sm font-medium mb-2
                                                  text-slate-700 dark:text-cyan-300">Ball</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="number"
                                               name="score"
                                               value="{{ $submission->score ?? '' }}"
                                               min="0"
                                               max="{{ $assignment->max_score }}"
                                               placeholder="0"
                                               class="w-24 p-2 rounded-lg border focus:outline-none
                                                      bg-white border-slate-300 text-slate-900 focus:border-cyan-500
                                                      dark:bg-slate-800 dark:text-slate-100 dark:border-cyan-500/20 dark:focus:border-cyan-400">
                                        <span class="text-slate-500 dark:text-slate-400">/ {{ $assignment->max_score }}</span>
                                    </div>
                                    <button type="submit"
                                            class="mt-3 w-full font-semibold px-4 py-2 rounded-lg transition
                                                   bg-yellow-500 text-white hover:bg-yellow-600
                                                   dark:bg-yellow-500 dark:text-slate-900 dark:hover:bg-yellow-400">
                                        {{ $submission->isGraded() ? 'Ballni Yangilash' : 'Baholash' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 rounded-xl
                        bg-slate-50 border border-slate-200
                        dark:bg-slate-800 dark:border-cyan-500/20">
                <p class="text-lg text-slate-600 dark:text-slate-400">Hali hech kim topshirmagan.</p>
            </div>
        @endif
    </div>
@endsection
