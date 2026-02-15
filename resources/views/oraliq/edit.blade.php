@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <a href="{{ route('oraliq.index') }}"
                class="text-cyan-600 dark:text-cyan-400 hover:underline flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" />
                </svg>
                Orqaga qaytish
            </a>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Oraliq Nazoratni tahrirlash</h1>
        </div>

        @if(session('error'))
            <div
                class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-r-lg">
                {{ session('error') }}
            </div>
        @endif

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <form action="{{ route('oraliq.update', $oraliq) }}" method="POST" enctype="multipart/form-data"
                class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Sarlavha
                        (Title)</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $oraliq->title) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all"
                        placeholder="Masalan: 1-Oraliq Nazorat - Kompyuter tarmoqlari">
                    @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description"
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tavsif (Description -
                        ixtiyoriy)</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all"
                        placeholder="Topshiriq shartlari va ko'rsatmalar...">{{ old('description', $oraliq->description) }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="deadline"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Muddat
                            (Deadline)</label>
                        <input type="datetime-local" name="deadline" id="deadline" required
                            value="{{ old('deadline', $oraliq->deadline->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all">
                        @error('deadline') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="max_score"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Maksimal ball (Max
                            Score)</label>
                        <input type="number" name="max_score" id="max_score" required min="1"
                            value="{{ old('max_score', $oraliq->max_score) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all"
                            placeholder="Masalan: 20">
                        <p class="mt-1 text-xs text-slate-400 italic">Boshqa topshiriqlar ballari bilan birga 50 dan
                            oshmasligi kerak. (Hozirgi boshqalar: {{ $currentTotal - $oraliq->max_score }})</p>
                        @error('max_score') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="assignment_file"
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Topshiriq fayli (Agar
                        yangilamoqchi bo'lsangiz yuklang)</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 dark:border-slate-600 border-dashed rounded-xl hover:border-cyan-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48" aria-hidden="true">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 dark:text-slate-400">
                                <label for="assignment_file"
                                    class="relative cursor-pointer bg-transparent rounded-md font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-500 focus-within:outline-none">
                                    <span>Faylni yuklash</span>
                                    <input id="assignment_file" name="assignment_file" type="file" class="sr-only"
                                        accept=".pdf,.docx,.pptx">
                                </label>
                                <p class="pl-1">yoki sudrab keling</p>
                            </div>
                            <p class="text-xs text-slate-500">PDF, DOCX, PPTX (Maks 10MB)</p>
                            <p class="text-xs text-cyan-600 font-bold mt-2">Joriy fayl:
                                {{ basename($oraliq->assignment_file) }}</p>
                        </div>
                    </div>
                    @error('assignment_file') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full px-6 py-4 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                        Yangilash va Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection