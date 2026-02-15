@extends('layouts.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Yakuniy Nazorat</h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400">Final imtihon topshirish moduli</p>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex gap-3">
                    <a href="{{ route('yakuniy.settings') }}"
                        class="px-5 py-2.5 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-700 transition">vaqtni belgilash</a>
                    <a href="{{ route('yakuniy.questions') }}"
                        class="px-5 py-2.5 bg-cyan-600 text-white rounded-xl font-bold hover:bg-cyan-500 transition">Savollar qo'shish
                        </a>
                    <a href="{{ route('yakuniy.results') }}"
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-500 transition">Natijalar</a>
                </div>
            @endif
        </div>

        @if(session('success'))
            <div
                class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-r-xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div
                class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-r-xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Status Card --}}
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Imtihon holati</h2>

                        @if(!$isEligible && !auth()->user()->isAdmin())
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div
                                    class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600 dark:text-red-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Ruxsat berilmadi</h3>
                                <p class="text-slate-600 dark:text-slate-400 max-w-md mx-auto">
                                    Yakuniy topshirish uchun yetarli ball to‘planmadi. Kamida 30 ball oraliq nazoratlardan
                                    to'plangan bo'lishi kerak.
                                </p>
                                <div
                                    class="mt-6 px-6 py-3 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-bold rounded-2xl border border-red-100 dark:border-red-800">
                                    Sizning ballingiz: {{ $oraliqScore }} / 50
                                </div>
                            </div>
                        @elseif($myResult)
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div
                                    class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 dark:text-green-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Imtihon yakunlangan</h3>
                                <p class="text-slate-600 dark:text-slate-400 mb-6 font-medium">Siz o'z natijangizni qo'lga
                                    kiritdingiz</p>
                                <div class="text-5xl font-black text-cyan-600 dark:text-cyan-400 mb-2">
                                    {{ $myResult->total_score }}
                                </div>
                                <div class="text-sm font-bold text-slate-400 uppercase tracking-widest">Yakuniy Natija</div>
                                <div class="mt-8 text-xs text-slate-500">Topshirilgan vaqt:
                                    {{ $myResult->submitted_at->format('d.m.Y H:i') }}
                                </div>
                            </div>
                        @elseif($status === 'not_set')
                            <div class="py-12 text-center">
                                <div class="text-slate-400 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-xl font-bold text-slate-500 dark:text-slate-400">Yakuniy nazorat hali
                                    belgilanmagan</p>
                            </div>
                        @elseif($status === 'not_started')
                            <div class="py-12 text-center">
                                <div
                                    class="w-20 h-20 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mb-6 mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-600 dark:text-amber-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Hali boshlanmadi</h3>
                                <p class="text-slate-600 dark:text-slate-400">Yakuniy nazorat belgilangan vaqtda ochiladi.</p>
                                <div class="mt-6 font-mono text-xl text-cyan-600 font-bold">
                                    {{ $settings->start_time->format('d.m.Y H:i') }}
                                </div>
                            </div>
                        @elseif($status === 'ended')
                            <div class="py-12 text-center">
                                <div
                                    class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-6 mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Vaqt tugagan</h3>
                                <p class="text-slate-600 dark:text-slate-400 font-medium">Yakuniy nazorat vaqti yakunlandi.</p>
                                <div class="mt-4 text-sm text-slate-400 lowercase italic">
                                    Tugash vaqti: {{ $settings->end_time->format('d.m.Y H:i') }}
                                </div>
                            </div>
                        @else
                            {{-- Eligible and within time --}}
                            <div class="py-8">
                                <div
                                    class="mb-10 p-6 bg-cyan-50 dark:bg-cyan-900/20 border-2 border-cyan-100 dark:border-cyan-800 rounded-2xl">
                                    <h3 class="text-lg font-bold text-cyan-900 dark:text-cyan-100 mb-4 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Imtihon qoidalari
                                    </h3>
                                    <ul class="space-y-3 text-sm text-cyan-800 dark:text-cyan-300">
                                        <li class="flex items-start gap-2">
                                            <span class="mt-1 flex-shrink-0 w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                            Sizda faqat bitta urinish mavjud.
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="mt-1 flex-shrink-0 w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                            Testni yakunlagandan so'ng javoblarni o'zgartirib bo'lmaydi.
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="mt-1 flex-shrink-0 w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                            Belgilangan vaqt ichida topshirish shart.
                                        </li>
                                    </ul>
                                </div>
                                @if(auth()->user()->isAdmin())
                                 
                                @else
                                    <a href="{{ route('yakuniy.take') }}"
                                        class="block w-full text-center py-6 bg-cyan-600 hover:bg-cyan-500 text-white text-2xl font-black rounded-3xl shadow-[0_10px_40px_rgba(8,145,178,0.3)] transition transform hover:scale-[1.02] active:scale-[0.98]">
                                        IMTIHONNI BOSHLASH
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar info --}}
            <div class="space-y-8">
                <div
                    class="bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-900 dark:to-black rounded-3xl p-8 shadow-2xl border border-slate-700">
                    <h3 class="text-white font-bold text-xl mb-6">Ma'lumotlar</h3>

                    <div class="space-y-6">
                        <div>
                            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Oraliq ball</div>
                            <div class="flex items-end gap-2 text-white">
                                <span
                                    class="text-3xl font-black {{ $oraliqScore >= 30 ? 'text-green-400' : 'text-red-400' }}">{{ $oraliqScore }}</span>
                                <span class="text-slate-500 text-lg font-bold">/ 50</span>
                            </div>
                        </div>

                        @if($settings)
                            <div>
                                <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Imtihon oralig'i
                                </div>
                                <div class="text-slate-200 font-medium">
                                    {{ $settings->start_time->format('d.m.Y H:i') }} dan<br>
                                    {{ $settings->end_time->format('d.m.Y H:i') }} gacha
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection