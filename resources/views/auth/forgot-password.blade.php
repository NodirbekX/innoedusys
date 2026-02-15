<!DOCTYPE html>
<html lang="uz" x-data="themeSwitcher()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parolni tiklash - InnoEduSys</title>
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

<!-- Forgot Password Container -->
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
                       text-slate-800 dark:text-white">Parolni tiklash</h1>
            <p class="text-sm animate-[fadeInUp_0.6s_ease-out_0.4s_both]
                      text-slate-600 dark:text-indigo-300/80">Elektron pochtangizga havola yuboramiz</p>
        </div>

        <div class="mb-6 p-4 rounded-lg text-sm animate-[fadeInUp_0.6s_ease-out_0.5s_both]
                    bg-blue-50 border border-blue-200 text-blue-800
                    dark:bg-indigo-500/10 dark:border-indigo-500/30 dark:text-indigo-300">
            Parolingizni unutdingizmi? Muammo yo'q. Bizga elektron pochta manzilingizni yuboring va biz sizga yangi parol tanlash imkonini beruvchi parolni tiklash havolasini yuboramiz.
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-lg text-sm flex items-center gap-3 animate-[fadeInUp_0.6s_ease-out_0.5s_both]
                        bg-green-100 border border-green-300 text-green-800
                        dark:bg-green-500/10 dark:border-green-500/30 dark:text-green-300">
                <span class="text-green-600 dark:text-green-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6 animate-[fadeInUp_0.6s_ease-out_0.6s_both]">
                <label for="email" class="block text-sm font-medium mb-2
                                          text-slate-700 dark:text-slate-300">Elektron pochta</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-indigo-500 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com"
                           class="w-full pl-10 pr-4 py-3 rounded-lg border transition-all duration-300 outline-none
                                  bg-white/50 border-slate-300 text-slate-900 placeholder-slate-400
                                  hover:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20
                                  dark:bg-slate-900/50 dark:border-indigo-500/30 dark:text-white dark:placeholder-slate-500
                                  dark:hover:bg-slate-900 dark:focus:border-indigo-500">
                </div>
                @if ($errors->get('email'))
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <button type="submit" class="w-full py-3 px-6 rounded-lg text-white font-bold text-base transition-all duration-300 shadow-lg animate-[fadeInUp_0.6s_ease-out_0.7s_both]
                                         bg-gradient-to-r from-indigo-500 to-purple-600
                                         hover:scale-105 hover:shadow-indigo-500/50
                                         active:scale-95">Parolni tiklash havolasini yuborish</button>
        </form>

        <div class="text-center mt-6 animate-[fadeInUp_0.6s_ease-out_0.8s_both]">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-medium transition
                                                  text-indigo-600 hover:text-indigo-500
                                                  dark:text-indigo-400 dark:hover:text-indigo-300">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kirish sahifasiga qaytish
            </a>
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
