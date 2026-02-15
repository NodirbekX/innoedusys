@extends('layouts.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-10 flex items-center gap-4">
            <a href="{{ route('yakuniy.index') }}"
                class="p-3 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600 dark:text-slate-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Imtihon natijalari</h1>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700">
                            <th
                                class="px-8 py-5 text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                                Talaba</th>
                            <th
                                class="px-8 py-5 text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                                Email</th>
                            <th
                                class="px-8 py-5 text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                                To'plangan ball</th>
                            <th
                                class="px-8 py-5 text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                                Topshirgan vaqti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $res)
                            <tr
                                class="border-b border-slate-50 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-8 py-6">
                                    <span class="text-slate-900 dark:text-white font-bold">{{ $res->user->name }}</span>
                                </td>
                                <td class="px-8 py-6 text-slate-500 dark:text-slate-400 font-medium">
                                    {{ $res->user->email }}
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-4 py-2 bg-cyan-50 dark:bg-cyan-900/20 text-cyan-600 dark:text-cyan-400 font-black rounded-xl border border-cyan-100 dark:border-cyan-800">
                                        {{ $res->total_score }} ball
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-slate-500 dark:text-slate-400 font-medium whitespace-nowrap">
                                    {{ $res->submitted_at->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-500 font-bold">
                                    Hozircha natijalar yo'q.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection