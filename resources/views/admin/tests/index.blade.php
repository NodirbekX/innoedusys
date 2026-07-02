<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Tests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <!-- Create Button -->
                <div class="p-6">
                    <a href="{{ route('admin.tests.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Create New Test') }}
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Midterms -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-bold text-lg mb-4 text-indigo-600">{{ __('Midterm Tests') }}</h3>
                        <ul>
                            @forelse($midterms as $test)
                                <li class="border-b py-2 flex justify-between items-center">
                                    <div>
                                        <div class="font-bold">{{ $test->title }}</div>
                                        <div class="text-sm text-gray-500">
                                            <span class="{{ $test->published ? 'text-green-600' : 'text-gray-400' }}">
                                                {{ $test->published ? __('Published') : __('Draft') }}
                                            </span> |
                                            {{ $test->questions_count ?? 0 }} {{ __('questions') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.tests.show', $test) }}"
                                        class="text-blue-500 hover:underline">{{ __('Manage') }}</a>
                                </li>
                            @empty
                                <p class="text-gray-500">{{ __('No midterm tests found.') }}</p>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Finals -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-bold text-lg mb-4 text-purple-600">{{ __('Final Tests') }}</h3>
                        <ul>
                            @forelse($finals as $test)
                                <li class="border-b py-2 flex justify-between items-center">
                                    <div>
                                        <div class="font-bold">{{ $test->title }}</div>
                                        <div class="text-sm text-gray-500">
                                            <span class="{{ $test->published ? 'text-green-600' : 'text-gray-400' }}">
                                                {{ $test->published ? __('Published') : __('Draft') }}
                                            </span> |
                                            {{ $test->questions_count ?? 0 }} {{ __('questions') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.tests.show', $test) }}"
                                        class="text-blue-500 hover:underline">{{ __('Manage') }}</a>
                                </li>
                            @empty
                                <p class="text-gray-500">{{ __('No final tests found.') }}</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
