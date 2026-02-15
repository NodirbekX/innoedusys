@extends('layouts.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Oraliq Nazorat</h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400">Barcha oraliq nazorat topshiriqlari ro'yxati</p>
            </div>
            @if(auth()->user()->email === 'ccnodirbekcc@gmail.com')
                <a href="{{ route('oraliq.create') }}"
                    class="px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                    + Yangi yaratish
                </a>
            @endif
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        {{-- Overall Score Indicator --}}
        <div
            class="mb-10 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Umumiy natija</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Barcha topshiriqlar bo'yicha umumiy ball</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-cyan-600 dark:text-cyan-400">
                        {{ $userGradedScore }}
                    </span>
                    <span class="text-xl text-slate-400">/ 50</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-4 overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-full transition-all duration-1000"
                    style="width: {{ min(($userGradedScore / 50) * 100, 100) }}%"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs font-bold text-slate-400 uppercase tracking-tighter">
                <span>0 ball</span>
                <span>Maksimal: 50 ball</span>
            </div>
            @if(auth()->user()->email === 'ccnodirbekcc@gmail.com')
                <div class="mt-4 p-3 bg-cyan-50 dark:bg-cyan-900/20 rounded-lg border border-cyan-100 dark:border-cyan-800">
                    <p class="text-xs text-cyan-700 dark:text-cyan-400">
                        <strong>Admin ma'lumoti:</strong> Topshiriqlar maksimal ballari yig'indisi:
                        <span class="font-bold {{ $totalMaxScore > 50 ? 'text-red-500' : '' }}">{{ $totalMaxScore }} / 50</span>
                    </p>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($assignments as $assignment)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <span
                                class="px-3 py-1 bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 text-xs font-bold rounded-full uppercase tracking-wider">
                                Topshiriq
                            </span>
                            <span
                                class="text-sm font-medium {{ now()->isAfter($assignment->deadline) ? 'text-red-500' : 'text-slate-500 dark:text-slate-400' }}">
                                {{ $assignment->deadline->format('d.m.Y H:i') }} gacha
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ $assignment->title }}</h3>
                        
                        {{-- Task Status for Pupil --}}
                        @if(auth()->user()->email !== 'ccnodirbekcc@gmail.com')
                            @php $sub = $assignment->submissions->first(); @endphp
                            <div class="mb-4">
                                @if($sub)
                                    @if($sub->score !== null)
                                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold rounded-lg border border-green-200 dark:border-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            BAHOLANDI: {{ $sub->score }} / {{ $assignment->max_score }}
                                        </div>
                                    @else
                                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-bold rounded-lg border border-blue-200 dark:border-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            YUBORILDI
                                        </div>
                                    @endif
                                @else
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        YUBORILMAGAN
                                    </div>
                                @endif
                            </div>
                        @endif

                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2">
                            {{ $assignment->description ?? 'Tavsif berilmagan' }}
                        </p>

                        <div class="flex items-center justify-between mt-6">
                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                <strong>Maks. ball:</strong> {{ $assignment->max_score }}
                            </div>
                            <div class="flex items-center gap-4">
                                @if(auth()->user()->email === 'ccnodirbekcc@gmail.com')
                                    <a href="{{ route('oraliq.edit', $assignment) }}"
                                        class="text-amber-600 dark:text-amber-400 font-semibold hover:underline text-sm">
                                        Tahrirlash
                                    </a>
                                @endif
                                <a href="{{ route('oraliq.show', $assignment) }}"
                                    class="text-cyan-600 dark:text-cyan-400 font-semibold hover:underline flex items-center gap-1">
                                    Batafsil
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400">Hozircha oraliq nazoratlar yo'q.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection