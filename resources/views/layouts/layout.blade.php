<!DOCTYPE html>
<html lang="en" x-data="themeSwitcher()" :class="{ 'dark': isDark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InnoEduSys</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ===== GLOBAL ANIMATIONS (UNCHANGED) ===== --}}
    <style>
        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 0 rgba(34, 211, 238, 0);
            }

            50% {
                box-shadow: 0 0 25px rgba(34, 211, 238, 0.6);
            }

            100% {
                box-shadow: 0 0 0 rgba(34, 211, 238, 0);
            }
        }

        .header-animate {
            animation: fadeDown 0.6s ease-out;
        }

        .logo-glow {
            animation: glow 3s infinite;
        }
    </style>
</head>

<body class="min-h-screen font-sans transition-colors duration-300
             bg-white text-slate-900
             dark:bg-gradient-to-br dark:from-slate-900 dark:via-zinc-900 dark:to-slate-900
             dark:text-slate-100">

    {{-- ===== HEADER / NAVBAR ===== --}}
    <header x-data="{ openMenu:false }" class="sticky top-0 z-50 backdrop-blur header-animate
               bg-white/80 border-b border-slate-200
               dark:bg-slate-900/80 dark:border-cyan-500/20">

        <div class="flex justify-between items-center px-6 py-4">

            {{-- LEFT SIDE: MENU ICON + EXPANDING HORIZONTAL MENU --}}
            <div class="flex items-center">

                <!-- MENU ICON -->
                <button @click="openMenu = !openMenu" class="p-2 rounded-lg transition
                           hover:bg-slate-200 dark:hover:bg-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-cyan-600 dark:text-cyan-300 transition-transform duration-300"
                        :class="{ 'rotate-90': openMenu }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>


                <!-- HORIZONTAL EXPANDING MENU -->
                <div class="flex items-center overflow-hidden transition-all duration-500 ease-in-out"
                    :class="openMenu ? 'max-w-3xl opacity-100 ml-6' : 'max-w-0 opacity-0'">

                    <nav class="flex items-center gap-8 whitespace-nowrap">

                        <a href="{{ route('home') }}"
                            class="font-semibold text-cyan-600 dark:text-cyan-300 hover:underline">
                            🏠 Bosh sahifa
                        </a>

                        <a href="{{ route('resources.index') }}" class="font-medium text-slate-600 hover:text-cyan-600
                              dark:text-slate-300 dark:hover:text-cyan-400">
                            📚 Foydali Resurslar
                        </a>


                        <a href="{{ route('oraliq.index') }}"
                            class="font-medium text-slate-600 hover:text-cyan-600
                              dark:text-slate-300 dark:hover:text-cyan-400 {{ request()->routeIs('oraliq.*') ? 'text-cyan-600 dark:text-cyan-400 font-bold' : '' }}">
                            📝 Oraliq Nazorat
                        </a>

                        <a href="{{ route('yakuniy.index') }}"
                            class="font-medium text-slate-600 hover:text-cyan-600
                              dark:text-slate-300 dark:hover:text-cyan-400 {{ request()->routeIs('yakuniy.*') ? 'text-cyan-600 dark:text-cyan-400 font-bold' : '' }}">
                            🎓 Yakuniy Nazorat
                        </a>

                        
                        <a href="{{ route('contact') }}" class="font-medium text-slate-600 hover:text-cyan-600
                              dark:text-slate-300 dark:hover:text-cyan-400">
                            📞 Bog'lanish
                        </a>
                    </nav>
                </div>

            </div>

            {{-- RIGHT SIDE: USER + THEME --}}
            <div class="flex items-center gap-4">

                {{-- THEME TOGGLE --}}
                <button @click="toggleTheme" class="px-3 py-2 rounded-lg transition
                       bg-slate-200 hover:bg-slate-300 text-slate-900
                       dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-100">
                    <span x-show="!isDark">🌙</span>
                    <span x-show="isDark">☀️</span>
                </button>

                @auth
                    <span class="hidden sm:block
                                     text-slate-600 dark:text-slate-300">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="font-semibold px-4 py-2 rounded-lg transition
                                       bg-cyan-500 hover:bg-cyan-400 text-slate-900
                                       shadow-[0_0_20px_rgba(34,211,238,0.4)]">
                            chiqish
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="min-h-screen
             bg-white text-slate-900
             dark:bg-transparent dark:text-slate-100
             transition-colors duration-300">
        @yield('content')
    </main>


    {{-- ===== FOOTER ===== --}}
    <footer class="mt-auto text-center py-4 text-sm
               border-t border-slate-200 text-slate-500
               dark:border-cyan-500/20 dark:text-slate-400">
        © {{ date('Y') }} InnoEduSys • Computer Network LMS
    </footer>

    {{-- ===== THEME SCRIPT ===== --}}
    <script>
        function themeSwitcher() {
            return {
                isDark:
                    localStorage.theme === 'dark' ||
                    (!('theme' in localStorage) &&
                        window.matchMedia('(prefers-color-scheme: dark)').matches),

                toggleTheme() {
                    this.isDark = !this.isDark
                    localStorage.theme = this.isDark ? 'dark' : 'light'
                }
            }
        }
    </script>

</body>

</html>