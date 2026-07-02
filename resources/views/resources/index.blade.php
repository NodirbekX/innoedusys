@extends('layouts.layout')
@section('content')


{{-- resources/views/home.blade.php ichidagi KITOBLAR BO'LIMI --}}

<div class="mt-10 mb-6 flex justify-between items-center fade-in">
    <h3 class="text-2xl font-bold tracking-wide
               text-cyan-600 dark:text-cyan-300">{{ __('📚 Foydali Resurslar') }}</h3>
    @if(auth()->check() && auth()->user()->isTeacher())
        <a href="{{ route('resources.create') }}"
           class="font-semibold px-4 py-2 rounded-lg transition
                  bg-cyan-500 text-white hover:bg-cyan-600
                  dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
            {{ __('+ Kitob Qo\'shish') }}
        </a>
    @endif
</div>

<div class="space-y-4 mb-10">
    @if($resources->isEmpty())
        <div class="p-4 rounded-xl
                    bg-slate-50 border border-slate-200 text-slate-500
                    dark:bg-slate-800 dark:border-cyan-500/20 dark:text-slate-400">
            {{ __('Hozircha foydali resurslar (kitoblar) qo\'shilmagan.') }}
        </div>
    @else
        @foreach($resources as $resource)
            {{-- Har bir kitob uchun alohida kartochka --}}
            <div class="scan relative rounded-xl p-5 overflow-hidden transition-all duration-300 fade-in
                        bg-slate-50 border border-slate-200 hover:border-cyan-400 hover:shadow-lg
                        dark:bg-slate-800 dark:border-cyan-500/20 dark:hover:border-cyan-400 dark:hover:shadow-[0_0_25px_rgba(34,211,238,0.25)]">

                <div class="flex justify-between items-start">

                    {{-- Kitob Nomi va Fayl Turi --}}
                    <div class="flex items-center gap-4 flex-1">
                        <div class="text-3xl text-cyan-600 dark:text-cyan-400">📘</div>
                        <div>
                            <h4 class="text-lg font-semibold text-cyan-700 dark:text-cyan-200">{{ $resource->title }}</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Fayl turi:') }} {{ strtoupper(pathinfo($resource->file_path, PATHINFO_EXTENSION)) }}</p>
                        </div>
                    </div>

                    {{-- Amallar Tugmalari --}}
                    <div class="flex gap-3 ml-4 items-center shrink-0">

                        {{-- Yuklab olish tugmasi (Hamma uchun) --}}
                        <a href="{{ asset('storage/' . $resource->file_path) }}"
                           target="_blank" download
                           class="font-semibold px-4 py-2 rounded-lg transition text-sm
                                  bg-cyan-500 text-white hover:bg-cyan-600
                                  dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400">
                            {{ __('Yuklab Olish') }}
                        </a>

                        {{-- O'chirish tugmasi (Faqat Admin uchun) --}}
                        @if(auth()->check() && auth()->user()->isTeacher())
                            <form action="{{ route('resources.destroy', $resource->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('{{ __('Kitobni o\'chirishni xohlaysizmi?') }}');"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="font-semibold px-4 py-2 rounded-lg transition text-sm border shadow-sm
                                               bg-red-50 text-red-600 border-red-200 hover:bg-red-100
                                               dark:bg-red-900/40 dark:text-red-300 dark:border-red-700/50 dark:hover:bg-red-900/60">
                                    {{ __('❌ O\'chirish') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection
