<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $test->title }}
            </h2>
            <div class="text-right">
                <div class="text-sm text-gray-600">Remaining Time</div>
                <div id="timer" class="text-2xl font-bold text-red-600 font-mono">
                    Loading...
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Prevent Copy/Paste/Right Click -->
    <div class="py-12 select-none" oncontextmenu="return false" oncopy="return false" oncut="return false"
        onpaste="return false">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form id="exam-form" action="{{ route('student.tests.submit', $test) }}" method="POST">
                @csrf

                @foreach($test->questions as $index => $question)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="font-bold text-lg mb-4">{{ $index + 1 }}. {{ $question->question_text }}</h3>

                            <div class="space-y-2">
                                <label
                                    class="flex items-center space-x-3 p-3 border rounded hover:bg-gray-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="a"
                                        class="form-radio h-5 w-5 text-blue-600 focus:ring-blue-500">
                                    <span class="text-gray-900 font-medium">A) {{ $question->option_a }}</span>
                                </label>

                                <label
                                    class="flex items-center space-x-3 p-3 border rounded hover:bg-gray-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="b"
                                        class="form-radio h-5 w-5 text-blue-600 focus:ring-blue-500">
                                    <span class="text-gray-900 font-medium">B) {{ $question->option_b }}</span>
                                </label>

                                <label
                                    class="flex items-center space-x-3 p-3 border rounded hover:bg-gray-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="c"
                                        class="form-radio h-5 w-5 text-blue-600 focus:ring-blue-500">
                                    <span class="text-gray-900 font-medium">C) {{ $question->option_c }}</span>
                                </label>

                                <label
                                    class="flex items-center space-x-3 p-3 border rounded hover:bg-gray-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="d"
                                        class="form-radio h-5 w-5 text-blue-600 focus:ring-blue-500">
                                    <span class="text-gray-900 font-medium">D) {{ $question->option_d }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 shadow-lg text-center">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg text-xl w-full max-w-md"
                        onclick="return confirm('Are you sure you want to submit?');">
                        Submit Exam
                    </button>
                </div>
                <div class="h-24"></div> <!-- Spacer for fixed footer -->
            </form>
        </div>
    </div>

    <script>
        // Security: Disable Right Click & text selection via CSS class
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.onkeydown = function (e) {
            if (e.keyCode == 123) { return false; } // F12
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) { return false; } // Ctrl+Shift+I
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) { return false; } // Ctrl+Shift+J
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) { return false; } // Ctrl+U
        }

        // Timer Logic
        const deadline = new Date("{{ $deadline->toIso8601String() }}").getTime();

        const timerInterval = setInterval(function () {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                document.getElementById("timer").innerHTML = "EXPIRED";
                document.getElementById("exam-form").submit();
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML =
                (hours < 10 ? "0" + hours : hours) + ":" +
                (minutes < 10 ? "0" + minutes : minutes) + ":" +
                (seconds < 10 ? "0" + seconds : seconds);

            // Visual warning when low time (e.g. < 5 mins)
            if (distance < 300000) {
                document.getElementById("timer").classList.add("animate-pulse");
            }
        }, 1000);
    </script>
</x-app-layout>