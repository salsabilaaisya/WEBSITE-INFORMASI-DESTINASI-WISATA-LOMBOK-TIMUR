<section class="relative h-screen">

    <img
        src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
        class="absolute inset-0 w-full h-full object-cover"
    >

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative max-w-7xl mx-auto h-full flex items-center px-8">

        <div class="text-white max-w-3xl">

            <span class="uppercase tracking-[5px] text-teal-300">
                Welcome to
            </span>

            <h1 class="text-6xl font-bold leading-tight mt-4">

                Explore the Beauty of
                <br>

                East Lombok

            </h1>

            <p class="mt-8 text-xl text-slate-200 leading-9">

                Discover beaches, mountains, waterfalls,
                culture, and unforgettable adventures
                across East Lombok.

            </p>

            <div class="mt-10 flex gap-5">

                <a
                    href="{{ route('frontend.destinations') }}"
                    class="px-8 py-4 rounded-xl bg-teal-600 hover:bg-teal-700 transition"
                >
                    Explore Destination
                </a>

                <a
                    href="{{ route('frontend.about') }}"
                    class="px-8 py-4 rounded-xl border border-white hover:bg-white hover:text-black transition"
                >
                    Learn More
                </a>

            </div>

        </div>

    </div>

</section>