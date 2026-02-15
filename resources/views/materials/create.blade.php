@extends('layouts.layout')

@section('content')

    <style>
        .page-enter {
            animation: fadeIn 0.7s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes glowPulse {
            0% { box-shadow: 0 0 0 rgba(34,211,238,0); }
            50% { box-shadow: 0 0 25px rgba(34,211,238,0.5); }
            100% { box-shadow: 0 0 0 rgba(34,211,238,0); }
        }

        .test-card {
            animation: fadeIn 0.4s ease;
        }
    </style>

    <div class="max-w-4xl mx-auto page-enter">

        <div class="rounded-2xl p-8
                    bg-white border border-slate-200
                    dark:bg-slate-900/80 dark:backdrop-blur dark:border-cyan-500/20 dark:shadow-[0_0_40px_rgba(34,211,238,0.15)]">

            <h2 class="text-3xl font-extrabold mb-6 tracking-wide
                       text-cyan-600 dark:text-cyan-300">
                Yangi Mavzusini Qoʻshish
            </h2>

            <form action="{{ route('home.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf

                {{-- Sarlavha (Title) --}}
                <div class="mb-5">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Mavzu Sarlavhasi</label>
                    <input type="text" name="title" required
                           class="w-full p-3 rounded-lg border outline-none transition
                                  bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                                  dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-100 dark:focus:border-cyan-400">
                </div>

                {{-- Video --}}
                <div class="mb-5">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Video (ixtiyoriy)</label>
                    <input type="file" name="video" id="video-input"
                           class="w-full p-3 rounded-lg border transition
                                  bg-slate-50 border-slate-300 text-slate-500
                                  file:bg-cyan-500 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-lg hover:file:bg-cyan-600
                                  dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-300
                                  dark:file:bg-cyan-500 dark:file:text-slate-900 dark:hover:file:bg-cyan-400">
                    <div id="progress-container" class="mt-3 hidden">
                        <div class="w-full rounded-full h-2.5
                                    bg-slate-200 dark:bg-slate-700">
                            <div id="progress-bar" class="h-2.5 rounded-full transition-all duration-300
                                                        bg-cyan-500 dark:bg-cyan-500" style="width: 0%"></div>
                        </div>
                        <p id="progress-text" class="text-sm mt-1
                                                    text-cyan-600 dark:text-cyan-300">0%</p>
                    </div>
                </div>

                {{-- Taqdimot (Presentation) --}}
                <div class="mb-5">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Taqdimot (ixtiyoriy)</label>
                    <input type="file" name="presentation"
                           class="w-full p-3 rounded-lg border transition
                                  bg-slate-50 border-slate-300 text-slate-500
                                  file:bg-cyan-500 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-lg hover:file:bg-cyan-600
                                  dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-300
                                  dark:file:bg-cyan-500 dark:file:text-slate-900 dark:hover:file:bg-cyan-400">
                </div>

                {{-- Tavsif (Description) --}}
                <div class="mb-6">
                    <label class="block mb-2 text-slate-700 dark:text-slate-300">Tavsif (ixtiyoriy)</label>
                    <textarea name="description" rows="3"
                              class="w-full p-3 rounded-lg border outline-none transition
                                     bg-slate-50 border-slate-300 text-slate-900 focus:border-cyan-500
                                     dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-100 dark:focus:border-cyan-400"></textarea>
                </div>

                {{-- TESTLAR --}}
                <div id="tests-container" class="mb-6">
                    <h3 class="text-xl font-semibold mb-3
                               text-cyan-600 dark:text-cyan-300">
                        Video Sinov Savollari
                    </h3>
                </div>

                <button type="button" id="add-test"
                        class="mb-6 font-semibold px-5 py-2 rounded-lg transition shadow
                               bg-green-500 text-white hover:bg-green-600
                               dark:bg-green-500 dark:text-slate-900 dark:hover:bg-green-400">
                    + Savol Qoʻshish
                </button>

                {{-- TUGMALAR --}}
                <div class="flex justify-between">
                    <a href="{{ route('home.index') }}"
                       class="font-semibold px-6 py-3 rounded-lg transition shadow
                              bg-slate-200 text-slate-700 hover:bg-slate-300
                              dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                        Orqaga
                    </a>

                    <button type="submit" id="submit-btn"
                            class="font-bold px-6 py-3 rounded-lg transition
                                   bg-cyan-500 text-white shadow-lg hover:bg-cyan-600
                                   dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400
                                   dark:shadow-[0_0_20px_rgba(34,211,238,0.4)] animate-[glowPulse_3s_infinite]">
                        Mavzuni Saqlash
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- TEST SCRIPT --}}
    <script>
        let testIndex = 0;
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

            <label class="block mb-2 text-slate-700 dark:text-slate-300">Variantlar (har bir qatorga bittadan)</label>
            <textarea name="tests[${testIndex}][options]" rows="3" required
                      class="w-full p-2 rounded-lg border mb-3
                             bg-white border-slate-300 text-slate-900
                             dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100"></textarea>

            <label class="block mb-2 text-slate-700 dark:text-slate-300">Toʻgʻri Javob</label>
            <input type="text"
                   name="tests[${testIndex}][correct]"
                   required
                   class="w-full p-2 rounded-lg border mb-3
                          bg-white border-slate-300 text-slate-900
                          dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

            <label class="block mb-2 text-slate-700 dark:text-slate-300">Koʻrsatish Vaqti (sekundda)</label>
            <input type="number"
                   name="tests[${testIndex}][time]"
                   min="1" required
                   placeholder="masalan, 120"
                   class="w-full p-2 rounded-lg border mb-3
                          bg-white border-slate-300 text-slate-900
                          dark:bg-slate-900 dark:border-cyan-500/20 dark:text-slate-100">

            <label class="block mb-2 text-slate-700 dark:text-slate-300">Ball (Points)</label>
            <input type="number"
                   name="tests[${testIndex}][points]"
                   min="1" required
                   value="1"
                   placeholder="masalan, 5"
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

            container.querySelectorAll('.remove-test').forEach(btn => {
                btn.onclick = () => btn.parentElement.remove();
            });
        });
    </script>

    {{-- UPLOAD PROGRESS SCRIPT --}}
    <script>
        document.getElementById('upload-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = document.getElementById('submit-btn');
            const progressContainer = document.getElementById('progress-container');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const videoInput = document.getElementById('video-input');

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Yuklanmo...';
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            // Show progress bar
            progressContainer.classList.remove('hidden');

            // Create FormData
            const formData = new FormData(form);

            // Create XMLHttpRequest
            const xhr = new XMLHttpRequest();

            // Track upload progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressText.textContent = Math.round(percentComplete) + '%';
                }
            });

            // Handle response
            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response.redirect;
                        } else {
                            alert('Xatolik: ' + (response.message || 'Noma\'lum xatolik'));
                            resetForm();
                        }
                    } catch (e) {
                        // If not JSON, assume redirect HTML
                        window.location.href = '{{ route("home.index") }}';
                    }
                } else {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            let errorMsg = 'Validatsiya xatoliklari:\n';
                            for (let field in response.errors) {
                                errorMsg += response.errors[field].join('\n') + '\n';
                            }
                            alert(errorMsg);
                        } else {
                            alert('Xatolik: ' + (response.message || 'Server xatoligi'));
                        }
                    } catch (e) {
                        alert('Xatolik yuz berdi. Status: ' + xhr.status);
                    }
                    resetForm();
                }
            });

            // Handle network errors
            xhr.addEventListener('error', function() {
                alert('Tarmoq xatoligi. Iltimos, qayta urinib ko\'ring.');
                resetForm();
            });

            function resetForm() {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Mavzuni Saqlash';
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                progressContainer.classList.add('hidden');
                progressBar.style.width = '0%';
                progressText.textContent = '0%';
            }

            // Send request
            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);
        });
    </script>

@endsection
