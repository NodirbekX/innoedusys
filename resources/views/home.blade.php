@extends('layouts.layout')

@section('content')

    {{-- ===== GLOBAL STYLES & ANIMATIONS ===== --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 5px rgba(34, 211, 238, 0.3);
            }

            50% {
                box-shadow: 0 0 20px rgba(34, 211, 238, 0.6);
            }
        }

        @keyframes scan {
            0% {
                background-position: 0% 0%;
            }

            100% {
                background-position: 100% 100%;
            }
        }

        .page-enter {
            animation: fadeIn 0.5s ease-out;
        }

        .scan {
            position: relative;
            overflow: hidden;
        }

        .scan::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(34, 211, 238, 0.1), transparent);
            transition: left 0.5s;
        }

        .scan:hover::before {
            left: 100%;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .pulse-glow {
            animation: pulseGlow 2s infinite;
        }

        /* ===== FULLSCREEN MODAL STYLES ===== */
        /* CRITICAL: Modals must be positioned correctly for fullscreen visibility */
        #questionModal,
        #scoreModal {
            z-index: 2147483647 !important;
            /* Maximum z-index value */
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Ensure modal content is properly styled */
        #questionModal>div,
        #scoreModal>div {
            position: relative !important;
            z-index: 2147483647 !important;
            max-width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* When modal is hidden, don't display */
        #questionModal.hidden,
        #scoreModal.hidden {
            display: none !important;
        }
    </style>

    <div class="flex min-h-screen page-enter
                    bg-white text-slate-900
                    dark:bg-gradient-to-br dark:from-slate-900 dark:via-zinc-900 dark:to-slate-900 dark:text-slate-100">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-96 p-5 hidden md:block
                          bg-slate-50 border-r border-slate-200
                          dark:bg-slate-900 dark:border-cyan-500/20">
            <h2 class="text-xl font-bold mb-6 tracking-wide
                           text-cyan-600 dark:text-cyan-400">
                🌐 Mavzular
            </h2>

            <ul class="space-y-2">
                @foreach($materials as $material)
                        <li>
                            <a href="{{ route('home.show', $material->id) }}"
                                class="group relative flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-300
                                       {{ isset($selectedMaterial) && $selectedMaterial->id == $material->id
                    ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-300 pulse-glow'
                    : 'text-slate-600 hover:bg-cyan-50 hover:text-cyan-600 dark:text-slate-300 dark:hover:bg-cyan-500/10 dark:hover:text-cyan-300' }}">
                                <span
                                    class="w-2 h-2 rounded-full
                                        {{ isset($selectedMaterial) && $selectedMaterial->id == $material->id
                    ? 'bg-cyan-500 dark:bg-cyan-400'
                    : 'bg-slate-400 group-hover:bg-cyan-500 dark:bg-slate-500 dark:group-hover:bg-cyan-400' }}">
                                </span>
                                <span>{{ $material->title }}</span>
                            </a>
                        </li>
                @endforeach
            </ul>

            @php
                $isTeacher = auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
            @endphp

            @if($isTeacher)
                <div class="mt-6 space-y-2">
                    <a href="{{ route('home.create') }}" class="block text-center font-semibold px-4 py-2 rounded-lg transition
                                      bg-cyan-500 text-white hover:bg-cyan-600
                                      dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
                        + Mavzu Qo'shish
                    </a>

            @endif
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="flex-1 p-8 w-96">

            @if(isset($selectedMaterial))

                <h2 class="text-3xl font-extrabold mb-6 tracking-wide fade-in
                                   text-cyan-700 dark:text-cyan-300">
                    {{ $selectedMaterial->title }}
                </h2>

                {{-- ===== VIDEO ===== --}}
                @if($selectedMaterial->video_path)
                    {{-- Video container wrapper for fullscreen support --}}
                    <div id="videoContainer" class="relative bg-black rounded-2xl h-96 overflow-hidden shadow-lg mb-6 fade-in
                                                                dark:shadow-[0_0_40px_rgba(34,211,238,0.15)]">
                        <video id="lessonVideo" controls class="w-full h-full">
                            <source src="{{ asset('storage/' . $selectedMaterial->video_path) }}" type="video/mp4">
                        </video>
                    </div>

                    {{-- ===== QUESTION MODAL ===== --}}
                    {{-- Modal will be moved to fullscreen container when needed --}}
                    <div id="questionModal"
                        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center"
                        style="z-index: 2147483647; position: fixed;">
                        <div class="rounded-2xl p-8 max-w-2xl w-full mx-4 shadow-2xl
                                                bg-white border border-slate-200
                                                dark:bg-slate-800 dark:border-cyan-500/30 dark:shadow-[0_0_40px_rgba(34,211,238,0.3)]"
                            style="position: relative; z-index: 2147483647;">
                            <h3 class="text-2xl font-bold mb-4
                                                   text-cyan-700 dark:text-cyan-300" id="modalQuestionText"></h3>
                            <div id="modalOptions" class="space-y-3 mb-6"></div>
                            <div class="flex justify-end gap-3">
                                <button id="submitAnswer"
                                    class="font-semibold px-6 py-2 rounded-lg transition
                                                                             bg-cyan-500 text-white hover:bg-cyan-600
                                                                             dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
                                    Javobni Yuborish
                                </button>
                            </div>
                            <div id="answerFeedback" class="mt-4 hidden"></div>
                        </div>
                    </div>

                    {{-- ===== FINAL SCORE MODAL ===== --}}
                    <div id="scoreModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center"
                        style="z-index: 2147483647; position: fixed;">
                        <div class="rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl text-center
                                                bg-white border border-slate-200
                                                dark:bg-slate-800 dark:border-cyan-500/30 dark:shadow-[0_0_40px_rgba(34,211,238,0.3)]"
                            style="position: relative; z-index: 2147483647;">
                            <h3 class="text-3xl font-bold mb-4
                                                   text-cyan-700 dark:text-cyan-300">🎉 Video Tugadi!</h3>
                            <div class="mb-6">
                                <div class="text-5xl font-bold mb-2
                                                        text-cyan-600 dark:text-cyan-400" id="scorePercentage"></div>
                                <div class="text-slate-600 dark:text-slate-300" id="scoreDetails"></div>
                            </div>
                            <button id="closeScoreModal"
                                class="font-semibold px-6 py-2 rounded-lg transition
                                                                            bg-cyan-500 text-white hover:bg-cyan-600
                                                                            dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
                                Yopish
                            </button>
                        </div>
                    </div>
                @endif

                {{-- ===== DESCRIPTION ===== --}}
                @if($selectedMaterial->description)
                    <p class="mb-6 leading-relaxed fade-in
                                          text-slate-700 dark:text-slate-300">
                        {{ $selectedMaterial->description }}
                    </p>
                @endif

                {{-- ===== PRESENTATION ===== --}}
                @if($selectedMaterial->presentation_path)
                    @php
                        $fileName = pathinfo($selectedMaterial->presentation_path, PATHINFO_BASENAME);
                        $displayName = strlen($fileName) > 30 ? substr($fileName, 0, 30) . '...' : $fileName;
                    @endphp
                    <a href="{{ asset('storage/' . $selectedMaterial->presentation_path) }}" target="_blank"
                        class="scan relative flex items-center gap-4 rounded-xl p-4 mb-10 transition-all duration-300 overflow-hidden fade-in
                                          bg-slate-50 border border-slate-200 hover:border-cyan-400 hover:shadow-lg
                                          dark:bg-slate-800 dark:border-cyan-500/20 dark:hover:shadow-[0_0_25px_rgba(34,211,238,0.3)]">
                        <div class="text-3xl text-cyan-600 dark:text-cyan-400">📑</div>
                        <div>
                            <p class="font-semibold text-cyan-700 dark:text-cyan-200">{{ $displayName }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400"> Prezentatsiyasi</p>
                        </div>
                    </a>
                @endif

                {{-- ===== GLOSSARY ===== --}}
                <div class="mb-10">
                    <h3 class="text-2xl font-bold tracking-wide mb-4 text-cyan-700 dark:text-cyan-300">📖 glossary</h3>
                    
                    <div class="space-y-4">
                        @foreach($selectedMaterial->glossaries as $glossary)
                            <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 dark:bg-slate-800 dark:border-cyan-500/20 shadow-sm relative group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="font-bold text-lg text-slate-800 dark:text-slate-200 block mb-1">{{ $glossary->term }}</span>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">{{ $glossary->definition }}</p>
                                    </div>
                                    @if(auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com')
                                        <div class="flex gap-2 ml-4 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" 
                                                    onclick="openEditGlossaryModal({{ $glossary->id }}, '{{ addslashes($glossary->term) }}', '{{ str_replace(["\r", "\n"], ["", "\\n"], addslashes($glossary->definition)) }}')" 
                                                    class="text-sm font-semibold text-blue-600 hover:text-blue-500 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">
                                                Edit
                                            </button>
                                            <form action="{{ route('glossary.destroy', $glossary->id) }}" method="POST" onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')" class="inline">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-500 bg-red-50 dark:bg-red-900/30 px-2 py-1 rounded">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        @if($selectedMaterial->glossaries->isEmpty())
                            <p class="text-slate-500 italic text-center p-4">Ushbu mavzuga oid lug'at topilmadi.</p>
                        @endif
                    </div>

                    @if(auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com')
                        <div class="mt-8 p-6 rounded-xl border-2 border-dashed border-slate-300 dark:border-cyan-500/30 bg-slate-50 dark:bg-slate-800/50">
                            <h4 class="font-bold mb-4 text-lg text-slate-700 dark:text-cyan-400 flex items-center gap-2">
                                <span>➕</span> Yangi so'z qo'shish
                            </h4>
                            <form action="{{ route('glossary.store', $selectedMaterial->id) }}" method="POST" class="grid gap-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Termin</label>
                                        <input type="text" name="term" required
                                               class="w-full rounded-lg border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Izoh</label>
                                        <input type="text" name="definition" required
                                               class="w-full rounded-lg border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200">
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-cyan-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-cyan-500 transition shadow-lg shadow-cyan-500/30">
                                        Qo'shish
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Edit Modal --}}
                        <div id="editGlossaryModal" class="hidden fixed inset-0 bg-black/80 z-[9999] flex items-center justify-center backdrop-blur-sm">
                             <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl w-full max-w-lg shadow-2xl border border-slate-200 dark:border-cyan-500/20 transform transition-all scale-100">
                                 <h3 class="text-2xl font-bold mb-6 text-slate-800 dark:text-white border-b pb-4 dark:border-slate-700">Tahrirlash</h3>
                                 <form id="editGlossaryForm" method="POST" class="space-y-4">
                                     @csrf @method('PUT')
                                     <div>
                                         <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Termin</label>
                                         <input type="text" id="editTerm" name="term" class="w-full rounded-lg border-slate-300 dark:bg-slate-900 dark:border-slate-600 focus:ring-2 focus:ring-cyan-500" required>
                                     </div>
                                     <div>
                                         <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Izoh</label>
                                         <textarea id="editDef" name="definition" class="w-full rounded-lg border-slate-300 dark:bg-slate-900 dark:border-slate-600 focus:ring-2 focus:ring-cyan-500" rows="4" required></textarea>
                                     </div>
                                     <div class="flex justify-end gap-3 pt-4">
                                         <button type="button" onclick="document.getElementById('editGlossaryModal').classList.add('hidden')" class="px-4 py-2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white font-semibold">Bekor qilish</button>
                                         <button type="submit" class="bg-cyan-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-cyan-500 shadow-lg">Saqlash</button>
                                     </div>
                                 </form>
                             </div>
                        </div>
                        <script>
                            function openEditGlossaryModal(id, term, def) {
                                const form = document.getElementById('editGlossaryForm');
                                form.action = `/glossary/${id}`;
                                document.getElementById('editTerm').value = term;
                                document.getElementById('editDef').value = def;
                                document.getElementById('editGlossaryModal').classList.remove('hidden');
                            }
                            
                            // Close modal on outside click
                            document.getElementById('editGlossaryModal').addEventListener('click', function(e) {
                                if (e.target === this) {
                                    this.classList.add('hidden');
                                }
                            });
                        </script>
                    @endif
                </div>

                {{-- ===== ADMIN ACTIONS ===== --}}
                @if($isTeacher)
                    <div class="mt-6 flex gap-3 fade-in">
                        <a href="{{ route('home.edit', $selectedMaterial->id) }}" class="px-4 py-2 rounded-lg transition
                                              bg-yellow-400 text-slate-900 hover:bg-yellow-300">
                            Mavzuni Tahrirlash
                        </a>
                        <form action="{{ route('home.destroy', $selectedMaterial->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bu mavzuni o\'chirishni xohlaysizmi?')" class="px-4 py-2 rounded-lg transition
                                                       bg-red-500 text-white hover:bg-red-400">
                                Mavzuni O'chirish
                            </button>
                        </form>
                    </div>
                @endif

            @else

            @endif

        </main>
    </div>

    {{-- ===== SUCCESS/ERROR MESSAGES ===== --}}
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in">
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Auto-hide success/error messages after 5 seconds
        setTimeout(function () {
            const messages = document.querySelectorAll('.fixed.bottom-4');
            messages.forEach(msg => {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            });
        }, 5000);
    </script>

    {{-- ===== VIDEO TEST INTERACTION SCRIPT ===== --}}
    @if(isset($selectedMaterial) && $selectedMaterial->video_path && $selectedMaterial->tests)
        <script>
            (function () {
                const video = document.getElementById('lessonVideo');
                if (!video) return;

                const materialId = {{ $selectedMaterial->id }};
                const tests = @json($selectedMaterial->tests);
                const questionModal = document.getElementById('questionModal');
                const scoreModal = document.getElementById('scoreModal');
                const modalQuestionText = document.getElementById('modalQuestionText');
                const modalOptions = document.getElementById('modalOptions');
                const submitAnswerBtn = document.getElementById('submitAnswer');
                const answerFeedback = document.getElementById('answerFeedback');
                const closeScoreModal = document.getElementById('closeScoreModal');

                let currentQuestionIndex = null;
                let selectedAnswer = null;
                let watchedTime = 0;
                let maxWatchedTime = 0;
                let answeredQuestions = new Set();
                let isAnswering = false;

                // Sort tests by time
                const sortedTests = [...tests].sort((a, b) => (a.time || 0) - (b.time || 0));

                // ===== FULLSCREEN API UTILITIES =====
                // Get fullscreen element (cross-browser)
                function getFullscreenElement() {
                    return document.fullscreenElement ||
                        document.webkitFullscreenElement ||
                        document.mozFullScreenElement ||
                        document.msFullscreenElement ||
                        null;
                }

                // Exit fullscreen (cross-browser)
                function exitFullscreen() {
                    if (document.exitFullscreen) {
                        return document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        return document.webkitExitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        return document.mozCancelFullScreen();
                    } else if (document.msExitFullscreen) {
                        return document.msExitFullscreen();
                    }
                    return Promise.resolve();
                }

                // Move modal to fullscreen container or body
                function positionModal(modal) {
                    const fullscreenEl = getFullscreenElement();

                    if (fullscreenEl) {
                        // Video is in fullscreen - move modal into fullscreen container
                        // This is CRITICAL: elements outside fullscreen container are invisible
                        try {
                            // Remove from current parent
                            if (modal.parentElement && modal.parentElement !== fullscreenEl) {
                                modal.parentElement.removeChild(modal);
                            }
                            // Append to fullscreen element
                            if (modal.parentElement !== fullscreenEl) {
                                fullscreenEl.appendChild(modal);
                            }
                            // Ensure modal covers fullscreen area
                            modal.style.position = 'fixed';
                            modal.style.top = '0';
                            modal.style.left = '0';
                            modal.style.width = '100%';
                            modal.style.height = '100%';
                            modal.style.zIndex = '2147483647';
                        } catch (e) {
                            console.error('Error moving modal to fullscreen:', e);
                            // Fallback: exit fullscreen
                            exitFullscreen();
                        }
                    } else {
                        // Not in fullscreen - ensure modal is in body
                        if (modal.parentElement !== document.body) {
                            modal.parentElement?.removeChild(modal);
                            document.body.appendChild(modal);
                        }
                        // Reset styles for normal view
                        modal.style.position = 'fixed';
                        modal.style.top = '0';
                        modal.style.left = '0';
                        modal.style.width = '100%';
                        modal.style.height = '100%';
                        modal.style.zIndex = '2147483647';
                    }
                }

                // Handle fullscreen changes - CRITICAL for modal visibility
                function handleFullscreenChange() {
                    // When fullscreen state changes, reposition open modals
                    if (!questionModal.classList.contains('hidden')) {
                        positionModal(questionModal);
                    }
                    if (!scoreModal.classList.contains('hidden')) {
                        positionModal(scoreModal);
                    }
                }

                // Listen to all fullscreen change events (cross-browser)
                document.addEventListener('fullscreenchange', handleFullscreenChange);
                document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
                document.addEventListener('mozfullscreenchange', handleFullscreenChange);
                document.addEventListener('MSFullscreenChange', handleFullscreenChange);

                // Prevent accidental fullscreen exit when modal is open
                // Note: This is a best-effort prevention, some browsers may still allow ESC
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' || e.keyCode === 27) {
                        const fullscreenEl = getFullscreenElement();
                        // If modal is open, prevent ESC from exiting fullscreen
                        if (fullscreenEl && (!questionModal.classList.contains('hidden') || !scoreModal.classList.contains('hidden'))) {
                            e.preventDefault();
                            e.stopPropagation();
                            // Don't exit fullscreen - user must answer question first
                            return false;
                        }
                    }
                });

                // Track watched time
                video.addEventListener('timeupdate', function () {
                    if (!isAnswering) {
                        watchedTime = video.currentTime;
                        if (watchedTime > maxWatchedTime) {
                            maxWatchedTime = watchedTime;
                        }
                    }
                });

                // Prevent seeking forward beyond watched time
                // Allow seeking backward and within watched portions
                let isSeeking = false;
                video.addEventListener('seeking', function () {
                    isSeeking = true;
                });

                video.addEventListener('seeked', function () {
                    isSeeking = false;
                    // Only prevent if trying to skip ahead beyond what's been watched
                    if (video.currentTime > maxWatchedTime + 2) {
                        // Allow small buffer (2 seconds) but prevent large skips
                        video.currentTime = maxWatchedTime;
                        alert('Oldinga o\'tib bo\'lmaydi. Videoni tartib bilan tomosha qiling.');
                    }
                });

                // Check for questions at current time
                video.addEventListener('timeupdate', function () {
                    if (isAnswering || isSeeking) return;

                    const currentTime = Math.floor(video.currentTime);

                    // Check if we've reached a question timestamp
                    for (let i = 0; i < sortedTests.length; i++) {
                        const test = sortedTests[i];
                        const questionTime = Math.floor(test.time || 0);

                        // Check if question should appear and hasn't been answered yet
                        // Use a small buffer to avoid multiple triggers
                        if (currentTime >= questionTime && currentTime < questionTime + 2 && !answeredQuestions.has(i)) {
                            showQuestion(i);
                            break;
                        }
                    }
                });

                // Check if video is completed
                video.addEventListener('ended', function () {
                    // Check if all questions are answered
                    if (answeredQuestions.size === sortedTests.length) {
                        completeVideo();
                    } else {
                        // Don't allow video to end if questions are unanswered
                        // Find first unanswered question and seek to it
                        let foundUnanswered = false;
                        for (let i = 0; i < sortedTests.length; i++) {
                            if (!answeredQuestions.has(i)) {
                                foundUnanswered = true;
                                video.currentTime = sortedTests[i].time;
                                // Small delay to ensure video seeks properly
                                setTimeout(() => {
                                    showQuestion(i);
                                }, 100);
                                break;
                            }
                        }
                        if (foundUnanswered) {
                            alert('Videoni yakunlash uchun barcha savollarga javob bering.');
                        }
                    }
                });

                function showQuestion(index) {
                    if (isAnswering) return;

                    isAnswering = true;
                    currentQuestionIndex = index;

                    const question = sortedTests[index];

                    video.pause();
                    if (document.fullscreenElement) {
                        document.exitFullscreen();
                    }

                    modalQuestionText.textContent = question.question;
                    modalOptions.innerHTML = '';
                    selectedAnswer = null;

                    question.options.forEach(option => {
                        const btn = document.createElement('button');
                        btn.textContent = option;
                        btn.className =
                            'w-full text-left p-4 rounded-lg transition ' +
                            'bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-800 ' +
                            'dark:bg-slate-700 dark:hover:bg-slate-600 dark:border-cyan-500/20 dark:text-slate-200';

                        btn.onclick = () => {
                            modalOptions.querySelectorAll('button').forEach(b =>
                                b.classList.remove('bg-cyan-500', 'text-white', 'dark:text-slate-900')
                            );
                            btn.classList.add('bg-cyan-500', 'text-white', 'dark:text-slate-900');
                            selectedAnswer = option;
                        };

                        modalOptions.appendChild(btn);
                    });

                    questionModal.classList.remove('hidden');
                }



                // Submit answer
                submitAnswerBtn.addEventListener('click', async function () {
                    if (!selectedAnswer || currentQuestionIndex === null) {
                        alert('Iltimos, javobni tanlang.');
                        return;
                    }

                    const question = sortedTests[currentQuestionIndex];

                    try {
                        const response = await fetch(`/video-test/${materialId}/check-answer`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: JSON.stringify({
                                question_index: currentQuestionIndex,
                                selected_answer: selectedAnswer
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Mark question as answered
                            answeredQuestions.add(currentQuestionIndex);

                            // Show feedback
                            answerFeedback.classList.remove('hidden');
                            if (data.is_correct) {
                                answerFeedback.innerHTML = `
                                        <div class="p-4 rounded-lg
                                                    bg-green-100 border border-green-300 text-green-800
                                                    dark:bg-green-500/20 dark:border-green-500/50 dark:text-green-300">
                                            ✓ To'g'ri! Siz ${data.earned_points} ball oldingiz.
                                        </div>
                                    `;
                            } else {
                                answerFeedback.innerHTML = `
                                        <div class="p-4 rounded-lg
                                                    bg-red-100 border border-red-300 text-red-800
                                                    dark:bg-red-500/20 dark:border-red-500/50 dark:text-red-300">
                                            ✗ Noto'g'ri. To'g'ri javob: ${data.correct_answer}. Siz 0 ball oldingiz.
                                        </div>
                                    `;
                            }

                            // Wait a moment, then close modal and resume video
                            setTimeout(() => {
                                questionModal.classList.add('hidden');
                                isAnswering = false;
                                // Restore modal to body when closed (in case it was in fullscreen container)
                                if (questionModal.parentElement !== document.body) {
                                    questionModal.parentElement?.removeChild(questionModal);
                                    document.body.appendChild(questionModal);
                                }
                                // Resume video playback
                                video.play();
                            }, 2000);
                        } else {
                            alert('Javobni yuborishda xatolik yuz berdi. Iltimos, qayta urinib ko\'ring.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Javobni yuborishda xatolik yuz berdi. Iltimos, qayta urinib ko\'ring.');
                    }
                });

                // Complete video and show score
                async function completeVideo() {
                    try {
                        const response = await fetch(`/video-test/${materialId}/complete`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Position score modal correctly (handles fullscreen)
                            positionModal(scoreModal);

                            // Show score modal
                            document.getElementById('scorePercentage').textContent = data.percentage.toFixed(1) + '%';
                            document.getElementById('scoreDetails').textContent =
                                `${data.earned_points} / ${data.total_points} ball`;
                            scoreModal.classList.remove('hidden');
                            scoreModal.style.display = 'flex';

                            // Double-check positioning after a brief delay
                            setTimeout(() => {
                                positionModal(scoreModal);
                            }, 50);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }

                // Close score modal
                closeScoreModal.addEventListener('click', function () {
                    scoreModal.classList.add('hidden');
                    // Restore modal to body when closed (in case it was in fullscreen container)
                    if (scoreModal.parentElement !== document.body) {
                        scoreModal.parentElement?.removeChild(scoreModal);
                        document.body.appendChild(scoreModal);
                    }
                });

                // Close modal on outside click
                questionModal.addEventListener('click', function (e) {
                    if (e.target === questionModal) {
                        // Don't allow closing without answering
                        alert('Davom etish uchun savolga javob bering.');
                    }
                });
            })();
        </script>
    @endif

@endsection