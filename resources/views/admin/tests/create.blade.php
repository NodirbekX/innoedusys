<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Test') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.tests.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="title" name="title" type="text" placeholder="e.g. Midterm Exam 2026" required>
                        </div>

                        <!-- Type -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Type</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="type" name="type" required>
                                <option value="midterm">Midterm</option>
                                <option value="final">Final</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Time Limit -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="time_limit">Time Limit
                                    (minutes)</label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="time_limit" name="time_limit" type="number" min="1" value="60" required>
                            </div>

                            <!-- Total Attempts -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="total_attempts">Total
                                    Attempts</label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="total_attempts" name="total_attempts" type="number" min="1" value="1" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Start At -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="start_at">Start Date &
                                    Time</label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="start_at" name="start_at" type="datetime-local" required>
                            </div>

                            <!-- End At -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="end_at">End Date &
                                    Time</label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="end_at" name="end_at" type="datetime-local" required>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                                role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-6">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Next: Add Questions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>