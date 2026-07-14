<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Explore East Lombok</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Alpine.js untuk animasi slideshow galeri di sisi kiri --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-zinc-900 font-sans antialiased overflow-x-hidden">
    <div class="min-h-screen grid lg:grid-cols-2">
        {{-- Sisi Kiri: Galeri Foto Bergerak / Slideshow Otomatis --}}
        <div 
            x-data="{ 
                activeSlide: 0, 
                slides: [
                    { 
                        url: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1200&auto=format&fit=crop', 
                        title: 'Pantai Pink Lombok Timur',
                        desc: 'Keindahan pasir berwarna pink yang memukau.'
                    },
                    { 
                        url: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1200&auto=format&fit=crop', 
                        title: 'Pesona Gunung Rinjani',
                        desc: 'Jalur pendakian terindah di Asia Tenggara.'
                    },
                    { 
                        url: 'https://images.unsplash.com/photo-1519046904884-53103b34b206?q=80&w=1200&auto=format&fit=crop', 
                        title: 'Gili Lampu & Gili Kondo',
                        desc: 'Surga bawah laut yang tenang dan asri.'
                    }
                ],
                init() {
                    setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    }, 4500);
                }
            }" 
            class="relative hidden lg:flex flex-col justify-between p-12 bg-zinc-900 overflow-hidden"
        >
            <template x-for="(slide, index) in slides" :key="index">
                <div 
                    x-show="activeSlide === index"
                    x-transition:enter="transition-opacity ease-out duration-1000"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-90 scale-100"
                    x-transition:leave="transition-opacity ease-in duration-1000"
                    x-transition:leave-start="opacity-90 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full"
                >
                    <img :src="slide.url" :alt="slide.title" class="w-full h-full object-cover">
                </div>
            </template>

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent pointer-events-none"></div>

            {{-- Header Brand --}}
            <div class="relative z-10 flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-teal-600 text-white font-bold shadow-lg shadow-teal-600/40 animate-pulse">
                    EL
                </div>
                <span class="text-white text-lg font-semibold tracking-wide drop-shadow-md">Explore East Lombok</span>
            </div>

            {{-- Dynamic Content & Mini Gallery Indicator --}}
            <div class="relative z-10 space-y-4 mb-4">
                <div class="space-y-2">
                    <span class="text-teal-300 text-xs font-semibold uppercase tracking-widest bg-teal-900/60 border border-teal-500/30 px-3 py-1 rounded-full backdrop-blur-sm" x-text="slides[activeSlide].title"></span>
                    <h1 class="text-4xl font-extrabold text-white leading-tight drop-shadow-lg transition-all duration-500" x-text="slides[activeSlide].title"></h1>
                    <p class="text-zinc-100 text-sm max-w-md drop-shadow transition-all duration-500" x-text="slides[activeSlide].desc"></p>
                </div>

                {{-- Indikator Titik Galeri --}}
                <div class="flex items-center gap-2 pt-2">
                    <template x-for="(slide, idx) in slides" :key="idx">
                        <button 
                            @click="activeSlide = idx"
                            :class="activeSlide === idx ? 'w-8 bg-teal-400' : 'w-2 bg-white/50 hover:bg-white/80'"
                            class="h-2 rounded-full transition-all duration-300"
                        ></button>
                    </template>
                </div>
            </div>

            <div class="relative z-10 text-xs text-zinc-300 drop-shadow">
                &copy; {{ date('Y') }} Explore East Lombok. All rights reserved.
            </div>
        </div>

        {{-- Sisi Kanan: Background Foto Pegunungan & Card Glassmorphism Register --}}
        <div class="relative flex items-center justify-center p-8 sm:p-12 lg:p-16 overflow-hidden bg-zinc-900">
            <img 
                src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1200&auto=format&fit=crop" 
                alt="Mountain View" 
                class="absolute inset-0 w-full h-full object-cover opacity-60"
            >
            <div class="absolute inset-0 bg-zinc-900/40 backdrop-blur-[4px]"></div>

            {{-- Form Container --}}
            <div class="relative z-10 w-full max-w-md p-8 sm:p-10 rounded-3xl bg-white/90 dark:bg-zinc-900/90 backdrop-blur-2xl border border-white/30 dark:border-zinc-700/60 shadow-2xl space-y-6 transform transition duration-500 hover:scale-[1.01]">
                <div class="space-y-1 text-center lg:text-left">
                    <div class="inline-flex lg:hidden items-center justify-center w-12 h-12 rounded-xl bg-teal-600 text-white font-bold mb-3 shadow-lg shadow-teal-600/30">
                        EL
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                        Create an account
                    </h2>
                    <p class="text-xs text-zinc-600 dark:text-zinc-400">
                        Enter your details below to create your account.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-teal-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            autocomplete="name"
                            placeholder="Full name"
                            class="w-full px-4 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white/90 dark:bg-zinc-950/90 text-zinc-900 dark:text-white text-sm focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition duration-200"
                        >
                        @error('name')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email"
                            placeholder="email@example.com"
                            class="w-full px-4 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white/90 dark:bg-zinc-950/90 text-zinc-900 dark:text-white text-sm focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition duration-200"
                        >
                        @error('email')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white/90 dark:bg-zinc-950/90 text-zinc-900 dark:text-white text-sm focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition duration-200"
                        >
                        @error('password')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Confirm Password</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white/90 dark:bg-zinc-950/90 text-zinc-900 dark:text-white text-sm focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition duration-200"
                        >
                        @error('password_confirmation')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm shadow-lg shadow-teal-600/30 transform transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 mt-2"
                    >
                        Create account
                    </button>
                </form>

                <div class="text-center text-xs text-zinc-600 dark:text-zinc-400 pt-2">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-teal-600 font-semibold hover:underline ml-1">Log in</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>