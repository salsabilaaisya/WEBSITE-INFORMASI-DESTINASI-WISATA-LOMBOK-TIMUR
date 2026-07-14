<nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">

    <div class="max-w-7xl mx-auto px-8">

        <div class="flex items-center justify-between h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold text-lg">
                    EL
                </div>

                <div>
                    <h1 class="text-xl font-bold text-slate-800">
                        Explore East Lombok
                    </h1>

                    <p class="text-xs text-slate-500">
                        Wonderful Destination
                    </p>
                </div>

            </a>

            {{-- Menu --}}
            <div class="hidden lg:flex items-center gap-10 text-[15px] font-medium">

                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">
                    Home
                </a>

                <a href="{{ route('frontend.destinations') }}" class="hover:text-teal-600 transition">
                    Destinations
                </a>

                <a href="{{ route('frontend.gallery') }}" class="hover:text-teal-600 transition">
                    Gallery
                </a>

                <a href="{{ route('frontend.articles') }}" class="hover:text-teal-600 transition">
                    Articles
                </a>

                <a href="{{ route('about') }}">
                    About
                </a>

            </div>

            {{-- Login --}}
            <div>

                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="px-5 py-2 rounded-xl bg-teal-600 text-white hover:bg-teal-700 transition"
                    >
                        Dashboard
                    </a>

                @else

                    <a
                        href="/login"
                        class="px-5 py-2 rounded-xl border border-teal-600 text-teal-600 hover:bg-teal-600 hover:text-white transition"
                    >
                        Login
                    </a>

                @endauth

            </div>

        </div>

    </div>

</nav>

<div class="h-20"></div>