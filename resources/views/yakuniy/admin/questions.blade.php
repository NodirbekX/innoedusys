@extends('layouts.layout')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('yakuniy.index') }}"
                    class="p-3 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600 dark:text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white">Savollar boshqaruvi</h1>
            </div>

            <button onclick="document.getElementById('addQuestionModal').classList.remove('hidden')"
                class="px-6 py-3 bg-cyan-600 text-white font-black rounded-2xl hover:bg-cyan-500 shadow-lg shadow-cyan-500/20 transition-all active:scale-[0.98]">
                + Yangi savol
            </button>
        </div>

        @if(session('success'))
            <div
                class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-r-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @forelse($questions as $index => $q)
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl border border-slate-200 dark:border-slate-700">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-xs">Savol
                                #{{ $index + 1 }}</span>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-1">{{ $q->question_text }}</h3>
                        </div>
                        <div class="flex items-center gap-4">
                            <span
                                class="px-4 py-1 bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 text-xs font-black rounded-full border border-cyan-200 dark:border-cyan-800">
                                {{ $q->score }} ball
                            </span>
                            <form action="{{ route('yakuniy.questions.destroy', $q) }}" method="POST"
                                onsubmit="return confirm('O\'chirmoqchimisiz?')">
                                @csrf
                                @method('DELETE')
                                <button class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($q->options as $option)
                            <div
                                class="p-4 rounded-2xl border-2 {{ $option->is_correct ? 'border-green-500 bg-green-50 dark:bg-green-900/10 dark:border-green-800' : 'border-slate-100 dark:border-slate-700' }} flex items-center justify-between">
                                <span
                                    class="{{ $option->is_correct ? 'text-green-700 dark:text-green-400 font-bold' : 'text-slate-600 dark:text-slate-400 font-semibold' }}">
                                    {{ $option->option_text }}
                                </span>
                                @if($option->is_correct)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div
                    class="py-20 text-center bg-white dark:bg-slate-800 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                    <p class="text-slate-500 font-bold">Hozircha savollar yo'q.</p>
                </div>
            @endforelse
        </div>

        {{-- Add Question Modal --}}
        <div id="addQuestionModal"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
            <div
                class="bg-white dark:bg-slate-800 w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
                <div
                    class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white">Yangi savol qo'shish</h2>
                    <button onclick="document.getElementById('addQuestionModal').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l18 18" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('yakuniy.questions.store') }}" method="POST"
                    class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
                    @csrf
                    <div>
                        <label class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase mb-2">Savol
                            matni</label>
                        <textarea name="question_text" required rows="3"
                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-semibold"></textarea>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase mb-2">Ball</label>
                        <input type="number" name="score" required min="1" value="1"
                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold">
                    </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase mb-2">Javob
                            variantlari</label>

                        @for($i = 0; $i < 4; $i++)
                            <div class="flex gap-4 items-center">
                                <input type="radio" name="correct_option" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }}
                                    class="w-6 h-6 text-cyan-600 focus:ring-cyan-500">
                                <input type="text" name="options[]" required placeholder="Variant {{ $i + 1 }}"
                                    class="flex-1 px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all">
                            </div>
                        @endfor
                        <p class="text-xs text-slate-400 italic font-medium mt-2">Dugmacha (radio) orqali to'g'ri javobni
                            belgilang.</p>
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full py-5 bg-cyan-600 hover:bg-cyan-500 text-white font-black rounded-2xl shadow-xl transition-all active:scale-[0.98]">
                            SAQLASH
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection