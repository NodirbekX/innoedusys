<!DOCTYPE html>
<html lang="uz" x-data="themeSwitcher()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish - InnoEduSys</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* The animations are kept as they are */
        @keyframes networkPulse { 0%, 100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.8; transform: scale(1.2); } }
        @keyframes lineGlow { 0%, 100% { opacity: 0.2; } 50% { opacity: 0.6; } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.1); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="font-sans antialiased transition-colors duration-300
             bg-slate-100 dark:bg-gradient-to-br dark:from-slate-900 dark:via-indigo-900 dark:to-slate-900">

<!-- Network Animation Background -->
<div class="fixed top-0 left-0 w-full h-full overflow-hidden z-0">
    <div class="absolute w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full shadow-lg animate-[networkPulse_3s_ease-in-out_infinite] top-[10%] left-[15%]"></div>
    <div class="absolute w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full shadow-lg animate-[networkPulse_3s_ease-in-out_infinite_0.5s] top-[20%] left-[80%]"></div>
    <div class="absolute w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full shadow-lg animate-[networkPulse_3s_ease-in-out_infinite_1s] top-[60%] left-[10%]"></div>
    <div class="absolute w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full shadow-lg animate-[networkPulse_3s_ease-in-out_infinite_1.5s] top-[70%] left-[85%]"></div>
    <div class="absolute w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full shadow-lg animate-[networkPulse_3s_ease-in-out_infinite_2s] top-[40%] left-[50%]"></div>
    <div class="absolute h-0.5 bg-gradient-to-r from-transparent via-indigo-500/40 to-transparent animate-[lineGlow_4s_ease-in-out_infinite] top-[10%] left-[15%] w-52 rotate-45"></div>
    <div class="absolute h-0.5 bg-gradient-to-r from-transparent via-indigo-500/40 to-transparent animate-[lineGlow_4s_ease-in-out_infinite] top-[60%] left-[10%] w-40 -rotate-30"></div>
    <div class="absolute h-0.5 bg-gradient-to-r from-transparent via-indigo-500/40 to-transparent animate-[lineGlow_4s_ease-in-out_infinite] top-[20%] left-[60%] w-48 rotate-[120deg]"></div>
</div>

<!-- Login Container -->
<div class="relative z-10 flex items-center justify-center min-h-screen w-full p-6">
    <div class="w-full max-w-md rounded-2xl p-8 shadow-2xl animate-[fadeInUp_0.8s_ease-out]
                bg-white/80 backdrop-blur-xl border border-slate-200
                dark:bg-gradient-to-b dark:from-slate-800/90 dark:to-slate-900/90 dark:border-indigo-500/20">

        <div class="text-center mb-8 animate-[float_3s_ease-in-out_infinite]">
            <div class="inline-block relative mb-6">
                <div class="absolute inset-0 bg-indigo-500/30 rounded-full blur-2xl animate-[pulse_2s_ease-in-out_infinite]"></div>
                <div class="relative p-4 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold tracking-tight animate-[fadeInUp_0.6s_ease-out_0.2s_both]
                       text-slate-800 dark:text-white">InnoEduSys</h1>
            <p class="text-sm animate-[fadeInUp_0.6s_ease-out_0.4s_both]
                      text-slate-600 dark:text-indigo-300/80">Kompyuter tarmogʻi LMS</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6 animate-[fadeInUp_0.6s_ease-out_0.1s_both]">
                <label for="email" class="block text-sm font-medium mb-2
                                          text-slate-700 dark:text-slate-300">Elektron pochta</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-indigo-500 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="your@email.com"
                           class="w-full pl-10 pr-4 py-3 rounded-lg border transition-all duration-300 outline-none
                                  bg-white/50 border-slate-300 text-slate-900 placeholder-slate-400
                                  hover:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20
                                  dark:bg-slate-900/50 dark:border-indigo-500/30 dark:text-white dark:placeholder-slate-500
                                  dark:hover:bg-slate-900 dark:focus:border-indigo-500">
                </div>
            </div>

            <div class="mb-4 animate-[fadeInUp_0.6s_ease-out_0.2s_both]">
                <label for="password" class="block text-sm font-medium mb-2
                                             text-slate-700 dark:text-slate-300">Parol</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-indigo-500 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </span>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-3 rounded-lg border transition-all duration-300 outline-none
                                  bg-white/50 border-slate-300 text-slate-900 placeholder-slate-400
                                  hover:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20
                                  dark:bg-slate-900/50 dark:border-indigo-500/30 dark:text-white dark:placeholder-slate-500
                                  dark:hover:bg-slate-900 dark:focus:border-indigo-500">
                </div>
            </div>

            <div class="flex justify-between items-center mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="remember_me" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-slate-800 dark:border-slate-600">
                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Meni eslab qol</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium transition
                                                                    text-indigo-600 hover:text-indigo-500
                                                                    dark:text-indigo-400 dark:hover:text-indigo-300">Parolni unutdingizmi?</a>
                @endif
            </div>

            <button type="submit" class="w-full py-3 px-6 rounded-lg text-white font-bold text-base transition-all duration-300 shadow-lg
                                         bg-gradient-to-r from-indigo-500 to-purple-600
                                         hover:scale-105 hover:shadow-indigo-500/50
                                         active:scale-95">Kirish</button>

            <div class="text-center mt-6 text-sm text-slate-600 dark:text-slate-400">
                Akkountingiz yoʻqmi?
                <a href="{{ route('register') }}" class="font-medium transition
                                                        text-indigo-600 hover:text-indigo-500
                                                        dark:text-indigo-400 dark:hover:text-indigo-300">Roʻyxatdan oʻtish</a>
            </div>
        </form>

        <div class="text-center mt-8 pt-6 border-t
                    border-slate-200 dark:border-indigo-500/20">
            <div class="flex items-center justify-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span class="text-indigo-500 dark:text-indigo-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </span>
                <span>&copy; {{ date('Y') }} InnoEduSys — Xavfsiz va zamonaviy ta'lim tizimi</span>
            </div>
        </div>
    </div>
</div>

<script>
    function themeSwitcher() {
        return {
            isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
            toggleTheme() {
                this.isDark = !this.isDark
                localStorage.theme = this.isDark ? 'dark' : 'light'
            }
        }
    }
</script>

</body>
</html>
