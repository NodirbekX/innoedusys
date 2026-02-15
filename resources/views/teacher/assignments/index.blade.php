@extends('layouts.layout')

@section('content')

    {{-- ===== GLOBAL STYLES & ANIMATIONS ===== --}}
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 5px rgba(34,211,238,0.3); }
            50% { box-shadow: 0 0 20px rgba(34,211,238,0.6); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .pulse-glow {
            animation: pulseGlow 2s infinite;
        }

        .topic-item {
            cursor: pointer;
            transition: all 0.3s;
        }

        /* Dark mode styles handled by Tailwind classes below */

        .manage-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <div class="flex min-h-screen
                bg-white text-slate-900
                dark:bg-gradient-to-br dark:from-slate-900 dark:via-zinc-900 dark:to-slate-900 dark:text-slate-100">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-72 p-5 hidden md:block
                      bg-slate-50 border-r border-slate-200
                      dark:bg-slate-900 dark:border-cyan-500/20">
            <h2 class="text-xl font-bold mb-6 tracking-wide
                       text-cyan-600 dark:text-cyan-400">🌐 Tarmoq Mavzulari</h2>

            @if($materials->count() > 0)
                <ul class="space-y-2" id="topicsList">
                    @foreach($materials as $material)
                        <li>
                            <div data-material-id="{{ $material->id }}"
                                 class="topic-item group relative flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-300
                                 {{ ($selectedMaterialId && $selectedMaterialId == $material->id) || (!$selectedMaterialId && $loop->first)
                                 ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-300 pulse-glow selected'
                                 : 'text-slate-600 hover:bg-cyan-50 hover:text-cyan-600 dark:text-slate-300 dark:hover:bg-cyan-500/10 dark:hover:text-cyan-300' }}">
                                <span class="w-2 h-2 rounded-full
                                {{ ($selectedMaterialId && $selectedMaterialId == $material->id) || (!$selectedMaterialId && $loop->first)
                                ? 'bg-cyan-500 dark:bg-cyan-400'
                                : 'bg-slate-400 group-hover:bg-cyan-500 dark:bg-slate-500 dark:group-hover:bg-cyan-400' }}">
                                </span>
                                <span>{{ $material->title }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-8">
                    <p class="text-slate-500 dark:text-slate-400">Mavzular mavjud emas</p>
                    <a href="{{ route('home.create') }}"
                       class="mt-4 inline-block font-semibold px-4 py-2 rounded-lg transition
                              bg-cyan-500 text-white hover:bg-cyan-600
                              dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
                        + Mavzu Qo'shish
                    </a>
                </div>
            @endif

            <div class="mt-6 space-y-2">
                <a href="{{ route('home.index') }}"
                   class="block text-center font-semibold px-4 py-2 rounded-lg transition
                          bg-slate-200 text-slate-700 hover:bg-slate-300
                          dark:bg-slate-700 dark:text-slate-100 dark:hover:bg-slate-600">
                    ← Bosh Sahifaga
                </a>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold tracking-wide fade-in
                           text-cyan-600 dark:text-cyan-300">📝 Topshiriqlarni Boshqarish</h2>
                <button id="createAssignmentBtn"
                        onclick="createAssignment()"
                        class="font-semibold px-6 py-2 rounded-lg transition shadow-lg
                               bg-cyan-500 text-white hover:bg-cyan-600
                               dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400 dark:shadow-[0_0_20px_rgba(34,211,238,0.4)]
                               {{ !$selectedMaterialId && $materials->count() > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ !$selectedMaterialId && $materials->count() > 0 ? 'disabled' : '' }}>
                    + Topshiriq Yaratish
                </button>
            </div>

            @if($materials->count() == 0)
                <div class="text-center py-12 rounded-xl fade-in
                            bg-slate-50 border border-slate-200
                            dark:bg-slate-800 dark:border-cyan-500/20">
                    <p class="text-lg mb-4 text-slate-600 dark:text-slate-400">Mavzular mavjud emas.</p>
                    <a href="{{ route('home.create') }}"
                       class="inline-block font-semibold px-6 py-2 rounded-lg transition
                              bg-cyan-500 text-white hover:bg-cyan-600
                              dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
                        + Birinchi Mavzuni Yaratish
                    </a>
                </div>
            @else
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg fade-in
                                bg-green-100 border border-green-300 text-green-800
                                dark:bg-green-500/20 dark:border-green-500/50 dark:text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @php
                    $selectedMaterial = $materials->firstWhere('id', $selectedMaterialId);
                    $assignments = $selectedMaterial ? $selectedMaterial->assignments()->latest()->get() : collect();
                @endphp

                @if($assignments->count() > 0)
                    <div class="mb-4 p-3 rounded-lg fade-in
                                bg-slate-100 border border-slate-200
                                dark:bg-slate-800 dark:border-cyan-500/20">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Topshiriqlar boshqarilmoqda:</p>
                        <p class="text-lg font-semibold text-cyan-600 dark:text-cyan-300">{{ $selectedMaterial->title }}</p>
                    </div>

                    <div class="space-y-4">
                        @foreach($assignments as $assignment)
                            <div class="scan relative rounded-xl p-6 overflow-hidden transition-all duration-300 fade-in
                                        bg-slate-50 border border-slate-200 hover:border-cyan-400 hover:shadow-lg
                                        dark:bg-slate-800 dark:border-cyan-500/20 dark:hover:shadow-[0_0_25px_rgba(34,211,238,0.25)]">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold mb-2 text-cyan-700 dark:text-cyan-200">{{ $assignment->title }}</h3>
                                        <p class="mb-3 text-slate-600 dark:text-slate-400">{{ $assignment->description }}</p>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                            <p class="text-slate-500 dark:text-slate-500">
                                                📚 Mavzu: <span class="text-slate-700 dark:text-slate-300">{{ $assignment->material->title }}</span>
                                            </p>
                                            <p class="text-slate-500 dark:text-slate-500">
                                                ⏰ Muddati: <span class="text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}</span>
                                            </p>
                                            <p class="text-slate-500 dark:text-slate-500">
                                                🎯 Maksimal Ball: <span class="text-slate-700 dark:text-slate-300">{{ $assignment->max_score }}</span>
                                            </p>
                                            <p class="text-slate-500 dark:text-slate-500">
                                                📊 Topshirilganlar: <span class="text-slate-700 dark:text-slate-300">{{ $assignment->submissions()->count() }}</span>
                                            </p>
                                        </div>

                                        @if($assignment->file_path)
                                            <a href="{{ asset('storage/' . $assignment->file_path) }}"
                                               target="_blank"
                                               class="inline-block mt-3 transition
                                                      text-cyan-600 hover:text-cyan-500
                                                      dark:text-cyan-400 dark:hover:text-cyan-300">
                                                📄 Topshiriq Faylini Yuklab Olish
                                            </a>
                                        @endif
                                    </div>

                                    <div class="flex flex-col gap-2 ml-4">
                                        <a href="{{ route('teacher.assignments.submissions', $assignment->id) }}"
                                           class="font-semibold px-4 py-2 rounded-lg transition text-center
                                                  bg-yellow-500 text-white hover:bg-yellow-600
                                                  dark:bg-yellow-500 dark:text-slate-900 dark:hover:bg-yellow-400">
                                            Topshirilganlarni Ko'rish ({{ $assignment->submissions()->count() }})
                                        </a>
                                        <a href="{{ route('teacher.assignments.edit', $assignment->id) }}"
                                           class="font-semibold px-4 py-2 rounded-lg transition text-center
                                                  bg-blue-500 text-white hover:bg-blue-600
                                                  dark:bg-blue-500 dark:text-white dark:hover:bg-blue-400">
                                            Tahrirlash
                                        </a>
                                        <form action="{{ route('teacher.assignments.destroy', $assignment->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Bu topshiriqni o\'chirishni xohlaysizmi?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full font-semibold px-4 py-2 rounded-lg transition
                                                           bg-red-500 text-white hover:bg-red-600
                                                           dark:bg-red-500 dark:text-white dark:hover:bg-red-400">
                                                O'chirish
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mb-4 p-3 rounded-lg fade-in
                                bg-slate-100 border border-slate-200
                                dark:bg-slate-800 dark:border-cyan-500/20">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Topshiriqlar boshqarilmoqda:</p>
                        <p class="text-lg font-semibold text-cyan-600 dark:text-cyan-300">{{ $selectedMaterial->title }}</p>
                    </div>

                    <div class="text-center py-12 rounded-xl fade-in
                                bg-slate-50 border border-slate-200
                                dark:bg-slate-800 dark:border-cyan-500/20">
                        <p class="text-lg mb-4 text-slate-600 dark:text-slate-400">Bu mavzu uchun topshiriqlar topilmadi.</p>
                        <button onclick="createAssignment()"
                                class="font-semibold px-6 py-2 rounded-lg transition
                                       bg-cyan-500 text-white hover:bg-cyan-600
                                       dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
                            Birinchi Topshiriqni Yaratish
                        </button>
                    </div>
                @endif
            @endif
        </main>
    </div>

    <script>
        // Get the selected material ID from PHP
        let selectedMaterialId = {{ $selectedMaterialId ?? 'null' }};
        const materials = @json($materials->pluck('id')->toArray());

        // Handle topic selection
        document.querySelectorAll('.topic-item').forEach(item => {
            item.addEventListener('click', function() {
                const materialId = parseInt(this.getAttribute('data-material-id'));

                // Only reload if selecting a different material
                if (materialId !== selectedMaterialId) {
                    selectedMaterialId = materialId;
                    loadAssignments(materialId);
                }
            });
        });

        function updateSelection() {
            // Update visual selection
            document.querySelectorAll('.topic-item').forEach(item => {
                const itemId = parseInt(item.getAttribute('data-material-id'));
                const spanElement = item.querySelector('span span');

                if (itemId === selectedMaterialId) {
                    item.classList.add('selected', 'pulse-glow');
                    // Light mode active
                    item.classList.remove('text-slate-600', 'hover:bg-cyan-50');
                    item.classList.add('bg-cyan-100', 'text-cyan-700');

                    // Dark mode active
                    item.classList.remove('dark:text-slate-300', 'dark:hover:bg-cyan-500/10');
                    item.classList.add('dark:bg-cyan-500/20', 'dark:text-cyan-300');

                    if (spanElement) {
                        spanElement.classList.remove('bg-slate-400', 'dark:bg-slate-500');
                        spanElement.classList.add('bg-cyan-500', 'dark:bg-cyan-400');
                    }
                } else {
                    item.classList.remove('selected', 'pulse-glow');
                    // Light mode inactive
                    item.classList.remove('bg-cyan-100', 'text-cyan-700');
                    item.classList.add('text-slate-600', 'hover:bg-cyan-50');

                    // Dark mode inactive
                    item.classList.remove('dark:bg-cyan-500/20', 'dark:text-cyan-300');
                    item.classList.add('dark:text-slate-300', 'dark:hover:bg-cyan-500/10');

                    if (spanElement) {
                        spanElement.classList.remove('bg-cyan-500', 'dark:bg-cyan-400');
                        spanElement.classList.add('bg-slate-400', 'dark:bg-slate-500');
                    }
                }
            });

            // Enable/disable create button
            const createBtn = document.getElementById('createAssignmentBtn');
            if (selectedMaterialId && materials.length > 0) {
                createBtn.disabled = false;
                createBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                createBtn.disabled = true;
                createBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        function loadAssignments(materialId) {
            // Reload page with selected material_id
            window.location.href = '{{ route("teacher.assignments.index") }}?material_id=' + materialId;
        }

        function createAssignment() {
            if (selectedMaterialId) {
                window.location.href = '{{ route("teacher.assignments.create") }}?material_id=' + selectedMaterialId;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSelection();
        });
    </script>

@endsection
