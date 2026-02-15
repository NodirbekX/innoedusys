@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white">Yakuniy Test</h1>
                <p class="text-slate-500 font-medium">Iltimos, barcha savollarga diqqat bilan javob bering.</p>
            </div>
            <div class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black shadow-lg">
                <span id="countdown" class="font-mono text-xl">
                    @if($settings)
                        {{ $settings->end_time->format('H:i') }} gacha
                    @endif
                </span>
            </div>
        </div>

        <form action="{{ route('yakuniy.submit') }}" method="POST" id="testForm">
            @csrf
            <div class="space-y-8">
                @foreach($questions as $index => $q)
                    <div
                        class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl border border-slate-200 dark:border-slate-700">
                        <div class="flex justify-between items-start mb-6">
                            <span
                                class="px-4 py-1 bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 text-xs font-black rounded-full border border-cyan-200 dark:border-cyan-800">
                                {{ $q->score }} ball
                            </span>
                            <span class="text-slate-400 font-bold">#{{ $index + 1 }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-8 leading-relaxed">
                            {{ $q->question_text }}
                        </h3>

                        <div class="space-y-4">
                            @foreach($q->options as $option)
                                <label
                                    class="relative flex items-center p-4 rounded-2xl border-2 border-slate-100 dark:border-slate-700 cursor-pointer transition-all hover:bg-slate-50 dark:hover:bg-slate-700/50 group">
                                    <input type="radio" name="q_{{ $q->id }}" value="{{ $option->id }}" class="sr-only peer"
                                        required>
                                    <div
                                        class="w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-500 peer-checked:border-cyan-500 peer-checked:bg-cyan-500 flex items-center justify-center transition-all">
                                        <div
                                            class="w-2.5 h-2.5 bg-white rounded-full scale-0 peer-checked:scale-100 transition-transform">
                                        </div>
                                    </div>
                                    <span
                                        class="ml-4 text-slate-700 dark:text-slate-300 font-semibold peer-checked:text-cyan-600 dark:peer-checked:text-cyan-400 transition-colors">
                                        {{ $option->option_text }}
                                    </span>
                                    <div
                                        class="absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-cyan-500/30 dark:peer-checked:border-cyan-400/20 pointer-events-none">
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                <button type="submit"
                    class="w-full py-6 bg-gradient-to-r from-cyan-600 to-indigo-600 hover:from-cyan-500 hover:to-indigo-500 text-white text-xl font-black rounded-3xl shadow-2xl transition transform hover:scale-[1.01] active:scale-[0.99]"
                    onclick="return confirm('Testni yakunlamoqchimisiz? Javoblarni keyin o\'zgartirib bo\'lmaydi.')">
                    TESTNI YAKUNLASH
                </button>
            </div>
        </form>
    </div>

    <script>
        // Simple auto-submit if time reaches end_time (optional, can be added later)
    </script>
@endsection