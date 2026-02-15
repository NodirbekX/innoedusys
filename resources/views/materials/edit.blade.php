@extends('layouts.layout')

@section('content')

    {{-- ===== STYLES & ANIMATIONS ===== --}}
    <style>
        .page-enter {
            animation: fadeIn 0.7s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .test-card {
            animation: fadeIn 0.4s ease;
        }
    </style>

    <div class="max-w-4xl mx-auto page-enter">

        {{-- ===== FORM CARD ===== --}}
        <div class="rounded-2xl p-8
                    bg-white border border-slate-200
                    dark:bg-slate-900/80 dark:backdrop-blur dark:border-cyan-500/20 dark:shadow-[0_0_40px_rgba(34,211,238,0.15)]">

            <h2 class="text-3xl font-extrabold mb-6 tracking-wide
                       text-cyan-600 dark:text-cyan-300">
                ✏️ Tarmoq Mavzusini Tahrirlash
            </h2>

            <form action="{{ route('home.update', $home->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===== TITLE ===== --}}
                <div class="mb-5">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Mavzu Sarlavhasi</label>
                    <input type="text"
                           name="title"
                           value="{{ $home->title }}"
                           required
                           class="w-full p-3 rounded-lg border outline-none transition
                                  bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                                  dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-100 dark:focus:border-cyan-400">
                </div>

                {{-- ===== VIDEO ===== --}}
                <div class="mb-5">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Video (ixtiyoriy)</label>
                    <input type="file" name="video"
                           class="w-full p-3 rounded-lg border transition
                                  bg-slate-50 border-slate-300 text-slate-500
                                  file:bg-cyan-500 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-lg hover:file:bg-cyan-600
                                  dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-300
                                  dark:file:bg-cyan-500 dark:file:text-slate-900 dark:hover:file:bg-cyan-400">
                    @if($home->video_path)
                        <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
                            Joriy: {{ $home->video_path }}
                        </p>
                    @endif
                </div>

                {{-- ===== PRESENTATION ===== --}}
                <div class="mb-5">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Taqdimot (ixtiyoriy)</label>
                    <input type="file" name="presentation"
                           class="w-full p-3 rounded-lg border transition
                                  bg-slate-50 border-slate-300 text-slate-500
                                  file:bg-cyan-500 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-lg hover:file:bg-cyan-600
                                  dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-300
                                  dark:file:bg-cyan-500 dark:file:text-slate-900 dark:hover:file:bg-cyan-400">
                    @if($home->presentation_path)
                        <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
                            Joriy: {{ $home->presentation_path }}
                        </p>
                    @endif
                </div>

                {{-- ===== DESCRIPTION ===== --}}
                <div class="mb-6">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Tavsif (ixtiyoriy)</label>
                    <textarea name="description" rows="3"
                              class="w-full p-3 rounded-lg border outline-none transition
                                     bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                                     dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-100 dark:focus:border-cyan-400">{{ $home->description }}</textarea>
                </div>

                {{-- ===== TESTS ===== --}}
                <div id="tests-container" class="mb-6">
                    <h3 class="text-xl font-semibold mb-4
                               text-cyan-600 dark:text-cyan-300">
                        🧠 Video Sinov Savollari
                    </h3>

                    @if($home->tests)
                        @foreach($home->tests as $index => $test)
                            <div class="test-card mb-5 rounded-xl p-5
                                        bg-slate-50 border border-slate-200
                                        dark:bg-slate-800 dark:border-cyan-500/20">

                                <label class="block mb-2 text-slate-700 dark:text-slate-300">Savol</label>
                                <input type="text"
                                       name="tests[{{ $index }}][question]"
                                       value="{{ $test['question'] }}"
                                       required
                                       class="w-full p-2 rounded-lg border mb-3
                                              bg-white border-slate-300 text-slate-900
                                              dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

                                <label class="block mb-2 text-slate-700 dark:text-slate-300">
                                    Variantlar (har bir qatorga bittadan)
                                </label>
                                <textarea name="tests[{{ $index }}][options]"
                                          rows="3" required
                                          class="w-full p-2 rounded-lg border mb-3
                                                 bg-white border-slate-300 text-slate-900
                                                 dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">{{ implode("\n", $test['options']) }}</textarea>

                                <label class="block mb-2 text-slate-700 dark:text-slate-300">To'g'ri Javob</label>
                                <input type="text"
                                       name="tests[{{ $index }}][correct]"
                                       value="{{ $test['correct'] }}"
                                       required
                                       class="w-full p-2 rounded-lg border mb-3
                                              bg-white border-slate-300 text-slate-900
                                              dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

                                <label class="block mb-2 text-slate-700 dark:text-slate-300">
                                    Ko'rsatish Vaqti (sekundda)
                                </label>
                                <input type="number"
                                       name="tests[{{ $index }}][time]"
                                       value="{{ $test['time'] ?? '' }}"
                                       min="1" required
                                       class="w-full p-2 rounded-lg border mb-3
                                              bg-white border-slate-300 text-slate-900
                                              dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

                                <label class="block mb-2 text-slate-700 dark:text-slate-300">Ball</label>
                                <input type="number"
                                       name="tests[{{ $index }}][points]"
                                       value="{{ $test['points'] ?? 1 }}"
                                       min="1" required
                                       class="w-full p-2 rounded-lg border
                                              bg-white border-slate-300 text-slate-900
                                              dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

                                <button type="button"
                                        class="mt-4 px-4 py-1 rounded-lg remove-test
                                               bg-red-500 text-white hover:bg-red-600
                                               dark:bg-red-500 dark:text-white dark:hover:bg-red-400">
                                    Olib Tashlash
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- ===== ADD TEST ===== --}}
                <button type="button" id="add-test"
                        class="mb-6 font-semibold px-5 py-2 rounded-lg transition shadow
                               bg-green-500 text-white hover:bg-green-600
                               dark:bg-green-500 dark:text-slate-900 dark:hover:bg-green-400">
                    + Savol Qo'shish
                </button>

                {{-- ===== SAVE ===== --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="font-bold px-6 py-3 rounded-lg transition
                                   bg-cyan-500 text-white shadow-lg hover:bg-cyan-600
                                   dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400
                                   dark:shadow-[0_0_20px_rgba(34,211,238,0.4)]">
                        O'zgarishlarni Saqlash
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ===== SCRIPT ===== --}}
    <script>
        let testIndex = {{ $home->tests ? count($home->tests) : 0 }};
        const container = document.getElementById('tests-container');
        const addBtn = document.getElementById('add-test');

        addBtn.addEventListener('click', () => {
            const html = `
        <div class="test-card mb-5 rounded-xl p-5
                    bg-slate-50 border border-slate-200
                    dark:bg-slate-800 dark:border-cyan-500/20">

            <label class="block mb-2 text-slate-700 dark:text-slate-300">Savol</label>
            <input type="text"
                   name="tests[${testIndex}][question]"
                   required
                   class="w-full p-2 rounded-lg border mb-3
                          bg-white border-slate-300 text-slate-900
                          dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

            <label class="block mb-2 text-slate-700 dark:text-slate-300">
                Variantlar (har bir qatorga bittadan)
            </label>
            <textarea name="tests[${testIndex}][options]"
                      rows="3" required
                      class="w-full p-2 rounded-lg border mb-3
                             bg-white border-slate-300 text-slate-900
                             dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100"></textarea>

            <label class="block mb-2 text-slate-700 dark:text-slate-300">To'g'ri Javob</label>
            <input type="text"
                   name="tests[${testIndex}][correct]"
                   required
                   class="w-full p-2 rounded-lg border mb-3
                          bg-white border-slate-300 text-slate-900
                          dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

            <label class="block mb-2 text-slate-700 dark:text-slate-300">
                Ko'rsatish Vaqti (sekundda)
            </label>
            <input type="number"
                   name="tests[${testIndex}][time]"
                   min="1" required
                   class="w-full p-2 rounded-lg border mb-3
                          bg-white border-slate-300 text-slate-900
                          dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

            <label class="block mb-2 text-slate-700 dark:text-slate-300">Ball</label>
            <input type="number"
                   name="tests[${testIndex}][points]"
                   min="1" required
                   value="1"
                   class="w-full p-2 rounded-lg border
                          bg-white border-slate-300 text-slate-900
                          dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

            <button type="button"
                    class="mt-4 px-4 py-1 rounded-lg remove-test
                           bg-red-500 text-white hover:bg-red-600
                           dark:bg-red-500 dark:text-white dark:hover:bg-red-400">
                Olib Tashlash
            </button>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', html);
            testIndex++;
            bindRemove();
        });

        function bindRemove() {
            container.querySelectorAll('.remove-test').forEach(btn => {
                btn.onclick = () => btn.parentElement.remove();
            });
        }
        bindRemove();
    </script>

@endsection
