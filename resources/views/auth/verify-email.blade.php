<!DOCTYPE html>
<html lang="uz" x-data="themeSwitcher()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email tasdiqlash - InnoEduSys</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes networkPulse { 0%, 100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.8; transform: scale(1.2); } }
        @keyframes lineGlow { 0%, 100% { opacity: 0.2; } 50% { opacity: 0.6; } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.1); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
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

<!-- Verify Email Container -->
<div class="relative z-10 flex items-center justify-center min-h-screen w-full p-6">
    <div class="w-full max-w-lg rounded-2xl p-8 shadow-2xl animate-[fadeInUp_0.8s_ease-out]
                bg-white/80 backdrop-blur-xl border border-slate-200
                dark:bg-gradient-to-b dark:from-slate-800/90 dark:to-slate-900/90 dark:border-indigo-500/20">

        <div class="text-center mb-8 animate-[float_3s_ease-in-out_infinite]">
            <div class="inline-block relative mb-6">
                <div class="absolute inset-0 bg-sky-500/30 rounded-full blur-2xl animate-[pulse_2s_ease-in-out_infinite]"></div>
                <div class="relative p-4 bg-gradient-to-r from-sky-500 to-blue-500 rounded-full shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold tracking-tight animate-[fadeInUp_0.6s_ease-out_0.2s_both]
                       text-slate-800 dark:text-white">Email tasdiqlash</h1>
            <p class="text-sm animate-[fadeInUp_0.6s_ease-out_0.4s_both]
                      text-slate-600 dark:text-indigo-300/80">Emailingizni tekshiring</p>
        </div>

        <div class="text-center my-8 animate-[fadeInUp_0.6s_ease-out_0.3s_both]">
            <div class="inline-block relative">
                <svg class="w-20 h-20 animate-[bounce_2s_ease-in-out_infinite]
                            text-sky-500 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
            </div>
        </div>

        <div class="mb-6 p-4 rounded-lg text-sm flex items-start gap-3 animate-[fadeInUp_0.6s_ease-out_0.5s_both]
                    bg-sky-50 border border-sky-200 text-sky-800
                    dark:bg-sky-500/10 dark:border-sky-500/30 dark:text-sky-300">
            <span class="text-sky-500 dark:text-sky-400 flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
            </span>
            <span>Ro'yxatdan o'tganingiz uchun rahmat! Boshlashdan oldin, sizga yuborgan havoladagi emailingizni tasdiqlashingiz mumkinmi? Agar email kelmagan bo'lsa, biz sizga boshqasini yuboramiz.</span>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 rounded-lg text-sm flex items-center gap-3 animate-[fadeInUp_0.6s_ease-out_0.6s_both]
                        bg-green-100 border border-green-300 text-green-800
                        dark:bg-green-500/10 dark:border-green-500/30 dark:text-green-300">
                <span class="text-green-600 dark:text-green-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </span>
                <span>Ro'yxatdan o'tish paytida ko'rsatgan email manzilingizga yangi tasdiqlash havolasi yuborildi.</span>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6 animate-[fadeInUp_0.6s_ease-out_0.7s_both]">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full sm:w-auto py-3 px-6 rounded-lg text-white font-bold text-base transition-all duration-300 shadow-lg flex items-center justify-center gap-2
                                             bg-gradient-to-r from-sky-500 to-blue-600
                                             hover:scale-105 hover:shadow-sky-500/50
                                             active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                    Emailni qayta yuborish
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-medium underline transition
                                             text-slate-500 hover:text-slate-700
                                             dark:text-slate-400 dark:hover:text-slate-200">Chiqish</button>
            </form>
        </div>

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
