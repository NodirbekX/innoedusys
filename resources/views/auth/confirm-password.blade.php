<!DOCTYPE html>
<html lang="uz" x-data="themeSwitcher()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parolni tasdiqlash - InnoEduSys</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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

<!-- Confirm Password Container -->
<div class="relative z-10 flex items-center justify-center min-h-screen w-full p-6">
    <div class="w-full max-w-md rounded-2xl p-8 shadow-2xl animate-[fadeInUp_0.8s_ease-out]
                bg-white/80 backdrop-blur-xl border border-slate-200
                dark:bg-gradient-to-b dark:from-slate-800/90 dark:to-slate-900/90 dark:border-indigo-500/20">

        <div class="text-center mb-8 animate-[float_3s_ease-in-out_infinite]">
            <div class="inline-block relative mb-6">
                <div class="absolute inset-0 bg-indigo-500/30 rounded-full blur-2xl animate-[pulse_2s_ease-in-out_infinite]"></div>
                <div class="relative p-4 bg-gradient-to-r from-orange-500 to-red-500 rounded-full shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold tracking-tight animate-[fadeInUp_0.6s_ease-out_0.2s_both]
                       text-slate-800 dark:text-white">Xavfsizlik tekshiruvi</h1>
            <p class="text-sm animate-[fadeInUp_0.6s_ease-out_0.4s_both]
                      text-slate-600 dark:text-indigo-300/80">Parolingizni tasdiqlang</p>
        </div>

        <div class="mb-6 p-4 rounded-lg text-sm flex items-start gap-3 animate-[fadeInUp_0.6s_ease-out_0.5s_both]
                    bg-orange-50 border border-orange-200 text-orange-800
                    dark:bg-orange-500/10 dark:border-orange-500/30 dark:text-orange-300">
            <span class="text-orange-500 dark:text-orange-400 flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
            </span>
            <span>Bu ilovaning xavfsiz qismi. Davom etishdan oldin parolingizni tasdiqlang.</span>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-6 animate-[fadeInUp_0.6s_ease-out_0.6s_both]">
                <label for="password" class="block text-sm font-medium mb-2
                                             text-slate-700 dark:text-slate-300">Parol</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-orange-500 dark:text-orange-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                    </span>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Parolingizni kiriting"
                           class="w-full pl-10 pr-4 py-3 rounded-lg border transition-all duration-300 outline-none
                                  bg-white/50 border-slate-300 text-slate-900 placeholder-slate-400
                                  hover:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20
                                  dark:bg-slate-900/50 dark:border-orange-500/30 dark:text-white dark:placeholder-slate-500
                                  dark:hover:bg-slate-900 dark:focus:border-orange-500">
                </div>
                @if ($errors->get('password'))
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <span>{{ $errors->first('password') }}</span>
                    </div>
                @endif
            </div>

            <div class="flex justify-end animate-[fadeInUp_0.6s_ease-out_0.7s_both]">
                <button type="submit" class="py-3 px-6 rounded-lg text-white font-bold text-base transition-all duration-300 shadow-lg
                                             bg-gradient-to-r from-orange-500 to-red-600
                                             hover:scale-105 hover:shadow-orange-500/50
                                             active:scale-95">Tasdiqlash</button>
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
