@extends('layouts.layout')

@section('content')

    {{-- Main content (Sidebar yo‘q sahifa) --}}
    <div class="max-w-7xl mx-auto px-6 py-12">

        {{-- ===== Header ===== --}}
        <header class="text-center mb-12">
            <h1 class="text-4xl font-extrabold tracking-wider mb-2
                       text-cyan-600 dark:text-cyan-300">
                BIZ BILAN BOG'LANISH
            </h1>
            <div class="w-20 h-1 bg-red-500 mx-auto mt-4 mb-6"></div>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                Ushbu o'quv platformasi bo'yicha taklif, shikoyat va savollar bilan murojaat qiling!
            </p>
        </header>

        {{-- ===== Kontakt Kartochkalari ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- 1. Bizning manzil (FULL WIDTH) --}}
            <div class="md:col-span-2 rounded-xl p-6 text-center shadow-2xl transition duration-300
                        bg-white border border-slate-200 hover:shadow-cyan-500/20
                        dark:bg-slate-800 dark:border-cyan-500/30 dark:hover:shadow-cyan-900/50">
                <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4
                            bg-red-100 text-red-500
                            dark:bg-red-600/20 dark:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2
                           text-slate-800 dark:text-slate-100">
                    Bizning manzil
                </h3>
                <p class="text-cyan-600 dark:text-cyan-400">
                    <a href="https://maps.app.goo.gl/Cbb8ppXFeqwdJGsS8">
                        Toshkent axborot texnologiyalari universiteti
                    </a>
                </p>
            </div>

            {{-- 2. Elektron manzil --}}
            <div class="rounded-xl p-6 text-center shadow-2xl transition duration-300
                        bg-white border border-slate-200 hover:shadow-cyan-500/20
                        dark:bg-slate-800 dark:border-cyan-500/30 dark:hover:shadow-cyan-900/50">
                <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4
                            bg-red-100 text-red-500
                            dark:bg-red-600/20 dark:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v11z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2
                           text-slate-800 dark:text-slate-100">
                    Elektron manzil
                </h3>
                <p class="text-cyan-600 dark:text-cyan-400">
                    irnavroza@gmail.com
                </p>
            </div>

            {{-- 3. Bog'lanish --}}
            <div class="rounded-xl p-6 text-center shadow-2xl transition duration-300
                        bg-white border border-slate-200 hover:shadow-cyan-500/20
                        dark:bg-slate-800 dark:border-cyan-500/30 dark:hover:shadow-cyan-900/50">
                <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4
                            bg-red-100 text-red-500
                            dark:bg-red-600/20 dark:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2
                           text-slate-800 dark:text-slate-100">
                    Bog'lanish
                </h3>
                <p class="text-cyan-600 dark:text-cyan-400">
                    +998 90 964 84 02
                </p>
            </div>

        </div>
    </div>

@endsection
