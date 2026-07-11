@extends('layouts.frontend')

@section('title', 'Gallery')

@section('content')

{{-- HERO --}}
<section class="relative h-[50vh] overflow-hidden">

    <img
        src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
        class="absolute inset-0 h-full w-full object-cover"
    >

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 flex h-full items-center justify-center">

        <div class="text-center text-white">

            <p class="mb-4 tracking-[8px] uppercase text-teal-300">
                Explore Gallery
            </p>

            <h1 class="text-5xl font-bold">
                Beautiful Moments
                <br>
                of East Lombok
            </h1>

            <p class="mt-6 text-lg text-gray-200">
                Discover unforgettable scenery and tourism destinations.
            </p>

        </div>

    </div>

</section>

{{-- SEARCH --}}
<section class="bg-white py-10 shadow-sm">

    <div class="mx-auto max-w-7xl px-6">

        <div class="mx-auto max-w-xl">

            <input
                type="text"
                placeholder="Search destination..."
                class="w-full rounded-full border border-gray-300 px-6 py-4 focus:border-teal-500 focus:ring-2 focus:ring-teal-500"
            >

        </div>

    </div>

</section>

{{-- FILTER --}}
<section class="py-8">

    <div class="mx-auto flex max-w-7xl flex-wrap justify-center gap-4 px-6">

        <button class="rounded-full bg-teal-600 px-6 py-2 text-white">
            Semua
        </button>

        <button class="rounded-full border px-6 py-2 hover:bg-teal-600 hover:text-white">
            Pantai
        </button>

        <button class="rounded-full border px-6 py-2 hover:bg-teal-600 hover:text-white">
            Gunung
        </button>

        <button class="rounded-full border px-6 py-2 hover:bg-teal-600 hover:text-white">
            Air Terjun
        </button>

    </div>

</section>

{{-- GALLERY --}}
<section class="pb-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

            @foreach($galleries as $gallery)

                <div class="group overflow-hidden rounded-3xl bg-white shadow-lg duration-300 hover:-translate-y-2 hover:shadow-2xl">

                    <div class="overflow-hidden">

                        <img
                            src="{{ asset('storage/'.$gallery->image) }}"
                            class="h-72 w-full object-cover duration-500 group-hover:scale-110"
                        >

                    </div>

                    <div class="p-6">

                        <h3 class="text-2xl font-bold">

                            {{ $gallery->caption }}

                        </h3>

                        <p class="mt-2 text-gray-500">

                            📍 {{ $gallery->destination->name }}

                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection