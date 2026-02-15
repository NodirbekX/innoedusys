<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $test->title }} management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Test Details & Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div
                    class="p-6 bg-white border-b border-gray-200 flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-sm text-gray-600">Type: <span
                                class="font-bold uppercase">{{ $test->type }}</span></p>
                        <p class="text-sm text-gray-600">Time Limit: <span class="font-bold">{{ $test->time_limit }}
                                mins</span></p>
                        <p class="text-sm text-gray-600">Schedule: {{ $test->start_at->format('M d H:i') }} -
                            {{ $test->end_at->format('M d H:i') }}</p>
                    </div>
                    <div>
                        <form action="{{ route('admin.tests.publish', $test) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="{{ $test->published ? 'bg-red-500 hover:bg-red-700' : 'bg-green-500 hover:bg-green-700' }} text-white font-bold py-2 px-4 rounded">
                                {{ $test->published ? 'Unpublish' : 'Publish Test' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.tests.results', $test) }}"
                            class="ml-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            View Results
                        </a>
                        <form action="{{ route('admin.tests.destroy', $test) }}" method="POST" class="inline ml-2"
                            onsubmit="return confirm('Are you sure? This will delete all results associated with this test!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Question Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-bold text-lg mb-4">Add New Question</h3>
                    <form action="{{ route('admin.tests.questions.store', $test) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                            <textarea name="question_text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                rows="3" required></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1">Option A</label>
                                <input type="text" name="option_a"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1">Option B</label>
                                <input type="text" name="option_b"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1">Option C</label>
                                <input type="text" name="option_c"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1">Option D</label>
                                <input type="text" name="option_d"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>
                        </div>

                        <div class="mb-4 mt-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Correct Option</label>
                            <select name="correct_option"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="a">Option A</option>
                                <option value="b">Option B</option>
                                <option value="c">Option C</option>
                                <option value="d">Option D</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Add Question
                        </button>
                    </form>
                </div>
            </div>

            <!-- Existing Questions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-bold text-lg mb-4">Questions ({{ $test->questions->count() }})</h3>
                    @forelse($test->questions as $index => $question)
                        <div class="mb-6 p-4 border rounded bg-gray-50">
                            <div class="flex justify-between">
                                <p class="font-bold text-lg mb-2">{{ $index + 1 }}. {{ $question->question_text }}</p>
                                <form action="{{ route('admin.tests.questions.destroy', $question) }}" method="POST"
                                    onsubmit="return confirm('Delete question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-bold">Delete</button>
                                </form>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                                <div
                                    class="p-2 border rounded {{ $question->correct_option == 'a' ? 'bg-green-100 border-green-500 font-bold' : 'bg-white' }}">
                                    A) {{ $question->option_a }}</div>
                                <div
                                    class="p-2 border rounded {{ $question->correct_option == 'b' ? 'bg-green-100 border-green-500 font-bold' : 'bg-white' }}">
                                    B) {{ $question->option_b }}</div>
                                <div
                                    class="p-2 border rounded {{ $question->correct_option == 'c' ? 'bg-green-100 border-green-500 font-bold' : 'bg-white' }}">
                                    C) {{ $question->option_c }}</div>
                                <div
                                    class="p-2 border rounded {{ $question->correct_option == 'd' ? 'bg-green-100 border-green-500 font-bold' : 'bg-white' }}">
                                    D) {{ $question->option_d }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">No questions added yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>