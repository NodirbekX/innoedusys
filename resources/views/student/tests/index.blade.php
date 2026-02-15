<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Exams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Available -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-bold text-lg mb-4 text-green-600">Available Tests</h3>
                        <ul>
                            @php $hasAvailable = false; @endphp
                            @foreach($tests as $test)
                                @if(!in_array($test->id, $completedTestIds))
                                    @php $hasAvailable = true; @endphp
                                    <li class="border-b py-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <div class="font-bold text-lg">{{ $test->title }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $test->type }} | {{ $test->time_limit }} mins
                                                </div>
                                                <div class="text-xs text-gray-400 mt-1">
                                                    Open until: {{ $test->end_at->format('M d, H:i') }}
                                                </div>
                                            </div>
                                            @if(now() >= $test->start_at && now() <= $test->end_at)
                                                <a href="{{ route('student.tests.show', $test) }}"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    Start
                                                </a>
                                            @elseif(now() < $test->start_at)
                                                <span class="text-yellow-600 font-bold text-sm">Opens Soon <br>
                                                    {{ $test->start_at->diffForHumans() }}</span>
                                            @else
                                                <span class="text-red-500 font-bold text-sm">Expired</span>
                                            @endif
                                        </div>
                                    </li>
                                @endif
                            @endforeach

                            @if(!$hasAvailable)
                                <p class="text-gray-500">No tests available.</p>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Completed -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-bold text-lg mb-4 text-gray-600">Completed Tests</h3>
                        <ul>
                            @php $hasCompleted = false; @endphp
                            @foreach($tests as $test)
                                @if(in_array($test->id, $completedTestIds))
                                    @php $hasCompleted = true; @endphp
                                    <li class="border-b py-4 flex justify-between items-center">
                                        <div>
                                            <div class="font-bold">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">
                                                Completed
                                            </div>
                                        </div>
                                        <a href="{{ route('student.tests.result', $test) }}"
                                            class="text-blue-500 hover:underline">View Result</a>
                                    </li>
                                @endif
                            @endforeach

                            @if(!$hasCompleted)
                                <p class="text-gray-500">No completed tests yet.</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>