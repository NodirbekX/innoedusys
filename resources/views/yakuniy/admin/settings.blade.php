@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-10 flex items-center gap-4">
            <a href="{{ route('yakuniy.index') }}"
                class="p-3 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600 dark:text-slate-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Imtihon vaqtini sozlash</h1>
        </div>

        @if(session('success'))
            <div
                class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-r-xl">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <form action="{{ route('yakuniy.settings.store') }}" method="POST" class="p-8 space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label
                            class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest mb-3">Imtihon
                            boshlanishi</label>
                        <input type="datetime-local" name="start_time" required
                            value="{{ $settings ? $settings->start_time->format('Y-m-d\TH:i') : '' }}"
                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold">
                        @error('start_time') <p class="mt-2 text-red-500 text-sm font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label
                            class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest mb-3">Imtihon
                            tugashi</label>
                        <input type="datetime-local" name="end_time" required
                            value="{{ $settings ? $settings->end_time->format('Y-m-d\TH:i') : '' }}"
                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold">
                        @error('end_time') <p class="mt-2 text-red-500 text-sm font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-600 dark:text-cyan-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Eslatma</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                Ushbu vaqt oralig'ida barcha ruxsat etilgan talabalar test topshirishi mumkin bo'ladi.
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-5 bg-slate-900 dark:bg-cyan-600 hover:bg-slate-800 dark:hover:bg-cyan-500 text-white font-black rounded-2xl shadow-xl transition-all active:scale-[0.98]">
                    VAQTNI SAQLASH
                </button>
            </form>
        </div>
    </div>
@endsection