<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $test->title }} - Result
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">

                    <h3 class="text-2xl font-bold mb-4">Test Submitted Successfully!</h3>

                    <div class="my-8">
                        <div class="text-gray-600 mb-2">Your Score</div>
                        <div
                            class="text-6xl font-bold {{ $result->score > ($test->questions->count() / 2) ? 'text-green-600' : 'text-red-600' }}">
                            {{ $result->score }} / {{ $test->questions->count() }}
                        </div>
                    </div>

                    <div class="text-gray-500 mb-6">
                        Submitted at: {{ $result->submitted_at->format('M d, Y H:i:s') }}
                    </div>

                    <a href="{{ route('student.tests.index') }}"
                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Return to Exams List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>