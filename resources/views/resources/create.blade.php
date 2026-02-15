@extends('layouts.layout')
@section('content')

    {{-- Formani asosiy konteynerga joylashtiramiz --}}
    <div class="rounded-xl p-8 max-w-lg mx-auto shadow-2xl fade-in
                bg-white border border-slate-200
                dark:bg-slate-800 dark:border-cyan-500/20 dark:shadow-[0_0_40px_rgba(34,211,238,0.1)]">

        <h1 class="text-3xl font-extrabold mb-6 tracking-wide
                   text-cyan-600 dark:text-cyan-300">Manba Qo'shish</h1>

        <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- KITOB NOMI MAYDONI --}}
            <div>
                <label for="title" class="block text-sm font-medium mb-2
                                          text-slate-700 dark:text-slate-300">Kitob Nomi:</label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title') }}"
                       required
                       class="w-full px-4 py-2 rounded-lg border outline-none transition duration-300
                              bg-slate-50 border-slate-300 text-slate-900 placeholder-slate-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500
                              dark:bg-slate-900 dark:border-cyan-500/30 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-cyan-400 dark:focus:ring-cyan-400">
                @error('title')
                <span class="text-sm mt-1 block text-red-500 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            {{-- FAYL YUKLASH MAYDONI --}}
            <div>
                <label for="file" class="block text-sm font-medium mb-2
                                         text-slate-700 dark:text-slate-300">Kitob Fayli:</label>
                <input type="file"
                       name="file"
                       id="file"
                       required
                       accept=".pdf,.doc,.docx,.epub"
                       class="w-full text-sm cursor-pointer transition duration-300
                              text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold
                              file:bg-cyan-500 file:text-white hover:file:bg-cyan-600
                              dark:text-slate-300 dark:file:text-slate-900 dark:hover:file:bg-cyan-400">
                @error('file')
                <span class="text-sm mt-1 block text-red-500 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            {{-- SAQLASH TUGMASI --}}
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="font-semibold px-6 py-2 rounded-lg transition duration-300 shadow-lg
                               bg-cyan-500 text-white hover:bg-cyan-600
                               dark:bg-cyan-500 dark:text-slate-900 dark:hover:bg-cyan-400 dark:shadow-[0_4px_15px_rgba(34,211,238,0.3)]">
                    Kitobni Saqlash
                </button>
            </div>
        </form>
    </div>

    {{-- Ro'yxatga Qaytish Linki --}}
    <div class="max-w-lg mx-auto mt-4 text-center">
        <a href="{{ route('resources.index') }}"
           class="transition duration-300 text-sm
                  text-cyan-600 hover:text-cyan-500
                  dark:text-cyan-400 dark:hover:text-cyan-300">
            ← Ro'yxatga Qaytish
        </a>
    </div>
@endsection
