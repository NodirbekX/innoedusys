@extends('layouts.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <a href="{{ route('oraliq.index') }}"
                    class="text-cyan-600 dark:text-cyan-400 hover:underline flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" />
                    </svg>
                    Ro'yxatga qaytish
                </a>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $oraliq->title }}</h1>
            </div>

            @if(auth()->user()->email === 'ccnodirbekcc@gmail.com')
                <form action="{{ route('oraliq.destroy', $oraliq) }}" method="POST"
                    onsubmit="return confirm('Haqiqatdan ham o\'chirmoqchimisiz?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-semibold rounded-lg hover:bg-red-200 transition-colors">
                        O'chirish
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div
                class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-r-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- LEFT COLUMN: Assignment Details --}}
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-8">
                    <h2 class="text-xl font-bold mb-4 text-slate-900 dark:text-white">Topshiriq tafsilotlari</h2>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 mb-8">
                        {!! nl2br(e($oraliq->description)) !!}
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 py-6 border-t border-slate-100 dark:border-slate-700">
                        <div>
                            <span class="block text-sm text-slate-500 dark:text-slate-500 mb-1">Maksimal ball</span>
                            <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $oraliq->max_score }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-slate-500 dark:text-slate-500 mb-1">Muddat (Deadline)</span>
                            <span
                                class="text-lg font-bold {{ now()->isAfter($oraliq->deadline) ? 'text-red-500' : 'text-slate-900 dark:text-white' }}">
                                {{ $oraliq->deadline->format('d.m.Y H:i') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-sm text-slate-500 dark:text-slate-500 mb-1">Fayl</span>
                            <a href="{{ asset('storage/' . $oraliq->assignment_file) }}" target="_blank"
                                class="inline-flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-bold hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Topshiriqni ko'rish
                            </a>
                        </div>
                    </div>
                </div>

                {{-- SUBMISSIONS LIST (FOR TEACHER) --}}
                @if(auth()->user()->email === 'ccnodirbekcc@gmail.com')
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Talaba topshiriqlari</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 dark:bg-slate-900/50">
                                    <tr>
                                        <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Talaba
                                        </th>
                                        <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Fayl
                                        </th>
                                        <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Vaqti
                                        </th>
                                        <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ball
                                        </th>
                                        <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Amal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                    @forelse($submissions as $sub)
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                                            <td class="px-8 py-4">
                                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $sub->user->name }}
                                                </div>
                                                <div class="text-xs text-slate-500">{{ $sub->user->email }}</div>
                                            </td>
                                            <td class="px-8 py-4">
                                                <a href="{{ asset('storage/' . $sub->solution_file) }}" target="_blank"
                                                    class="text-xs font-semibold text-cyan-600 hover:underline flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                    Yechimni yuklash
                                                </a>
                                            </td>
                                            <td class="px-8 py-4 text-sm text-slate-500">
                                                {{ $sub->submitted_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td class="px-8 py-4">
                                                @if($sub->score !== null)
                                                    <span
                                                        class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-md font-bold">
                                                        {{ $sub->score }} / {{ $oraliq->max_score }}
                                                    </span>
                                                @else
                                                    <span class="text-slate-400 text-xs italic">Baholanmagan</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-4">
                                                <button
                                                    @click="$dispatch('open-grading-modal', { submission_id: {{ $sub->id }}, student_name: '{{ $sub->user->name }}', current_score: {{ $sub->score ?? 'null' }} })"
                                                    class="text-cyan-600 hover:text-cyan-500 font-bold text-sm">
                                                    Baholash
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-10 text-center text-slate-500">Hech kim topshiriq
                                                yubormadi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            {{-- RIGHT COLUMN: Submission Status (FOR PUPIL) --}}
            @if(auth()->user()->email !== 'ccnodirbekcc@gmail.com')
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-8">
                        <h2 class="text-xl font-bold mb-6 text-slate-900 dark:text-white">Sizning holatingiz</h2>

                        @if($userSubmission)
                            <div class="space-y-6">
                                <div
                                    class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-100 dark:border-slate-700">
                                    <div class="flex items-center gap-3 mb-4 text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="font-bold">Yuborilgan</span>
                                    </div>
                                    <div class="text-sm text-slate-500 mb-2">
                                        <strong>Vaqti:</strong> {{ $userSubmission->submitted_at->format('d.m.Y H:i') }}
                                    </div>
                                    <a href="{{ asset('storage/' . $userSubmission->solution_file) }}" target="_blank"
                                        class="text-xs text-cyan-600 hover:underline">
                                        Yuborilgan faylni ko'rish
                                    </a>
                                </div>

                                <div class="mt-4">
                                    <span class="block text-sm text-slate-500 mb-1">Natija:</span>
                                    @if($userSubmission->score !== null)
                                        <div class="text-3xl font-black text-cyan-600">
                                            {{ $userSubmission->score }} <span class="text-lg text-slate-400">/
                                                {{ $oraliq->max_score }}</span>
                                        </div>
                                        <div
                                            class="mt-2 inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                            BAHOLANDI
                                        </div>
                                    @else
                                        <div class="text-lg font-bold text-slate-400 italic">Baholanmoqda...</div>
                                        <div
                                            class="mt-2 inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">
                                            KUTILMOQDA
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            @if(now()->isBefore($oraliq->deadline))
                                <form action="{{ route('oraliq.submit', $oraliq) }}" method="POST" enctype="multipart/form-data"
                                    class="space-y-4">
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Yechimni
                                            yuklash</label>
                                        <input type="file" name="solution_file" required
                                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 transition-all cursor-pointer">
                                        <p class="text-xs text-slate-400 italic">Maksimal fayl hajmi 10MB</p>
                                    </div>
                                    <button type="submit"
                                        class="w-full py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl shadow-lg transition-transform active:scale-95">
                                        Topshiriqni yuborish
                                    </button>
                                </form>
                            @else
                                <div
                                    class="p-6 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-center rounded-xl border border-red-100 dark:border-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 opacity-50" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="font-bold">Muddat tugadi</p>
                                    <p class="text-xs mt-1">Siz topshiriq yubora olmaysiz.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- GRADING MODAL (FOR TEACHER) --}}
    @if(auth()->user()->email === 'ccnodirbekcc@gmail.com')
        <div x-data="{ open: false, submission_id: null, student_name: '', current_score: null }"
            x-on:open-grading-modal.window="open = true; submission_id = $event.detail.submission_id; student_name = $event.detail.student_name; current_score = $event.detail.current_score"
            x-show="open" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;">

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
                @click.away="open = false">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="font-bold text-slate-900 dark:text-white">Baholash: <span x-text="student_name"></span></h3>
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form :action="'{{ url('oraliq-nazorat/submission') }}/' + submission_id + '/score'" method="POST" class="p-6">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Ball (Maks: {{ $oraliq->max_score }})
                        </label>
                        <input type="number" name="score" :value="current_score" required min="0" max="{{ $oraliq->max_score }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="open = false"
                            class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold rounded-xl">Bekor
                            qilish</button>
                        <button type="submit"
                            class="flex-1 py-3 bg-cyan-600 text-white font-bold rounded-xl shadow-lg hover:bg-cyan-500">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endsection