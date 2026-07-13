@extends('layouts.frontend')

@section('title','Explore Destinations')

@section('content')

{{-- ================= HERO ================= --}}

<section
    class="relative h-[520px] overflow-hidden">

    <img
        src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
        class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/60"></div>

    <div
        class="relative z-10 flex items-center justify-center h-full">

        <div
            class="text-center max-w-5xl px-6">

            <span
                class="inline-block px-5 py-2 rounded-full bg-teal-500 text-white text-sm font-semibold tracking-widest uppercase">

                Explore East Lombok

            </span>

            <h1
                class="mt-8 text-6xl md:text-7xl font-extrabold text-white leading-tight">

                Discover Beautiful
                <span class="text-teal-400">
                    Destinations
                </span>

            </h1>

            <p
                class="mt-8 text-xl text-gray-200 leading-9">

                Explore the beauty of beaches, waterfalls,
                mountains, culture, and hidden gems across
                East Lombok.

            </p>

        </div>

    </div>

</section>

{{-- ================= SEARCH ================= --}}

<section class="-mt-14 relative z-20">

    <div class="max-w-4xl mx-auto px-6">

        <form
            action="{{ route('frontend.destinations') }}"
            method="GET">

            <div
                class="bg-white rounded-full shadow-xl border border-gray-100 p-2 flex items-center">

                {{-- Icon Search --}}
                <div class="pl-5 pr-3 text-gray-400">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/>

                    </svg>

                </div>

                {{-- Input --}}
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search destinations, beaches, waterfalls..."
                    class="flex-1 border-0 focus:ring-0 text-lg py-4 bg-transparent placeholder:text-gray-400">

                {{-- Tombol --}}
                <button
                    type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-10 py-4 rounded-full font-semibold transition">

                    Search

                </button>

            </div>

        </form>

    </div>

</section>

{{-- ================= CATEGORY ================= --}}

<section
    class="py-14">

    <div
        class="max-w-7xl mx-auto px-6">

        <div
            class="flex flex-wrap gap-4 justify-center">

            <a
                href="{{ route('frontend.destinations') }}"
                class="px-6 py-3 rounded-full shadow transition
                {{ request('category') ? 'bg-white hover:bg-gray-100' : 'bg-teal-600 text-white' }}">

                All

            </a>

            @foreach($categories as $category)

                <a
                    href="{{ route('frontend.destinations',[
                        'category'=>$category->id,
                        'search'=>request('search')
                    ]) }}"
                    class="px-6 py-3 rounded-full shadow transition

                    {{ request('category') == $category->id
                        ? 'bg-teal-600 text-white'
                        : 'bg-white hover:bg-gray-100'
                    }}">

                    {{ $category->name }}

                </a>

            @endforeach

        </div>

    </div>

</section>

{{-- ================= DESTINATION LIST ================= --}}

<section class="pb-20 bg-gray-50">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse($destinations as $destination)

                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 group">

                    {{-- Cover --}}
                    @if($destination->cover_path)

                        <div class="overflow-hidden">

                            <img
                                src="{{ asset('storage/'.$destination->cover_path) }}"
                                alt="{{ $destination->name }}"
                                class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">

                        </div>

                    @else

                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500">

                            No Image Available

                        </div>

                    @endif

                    <div class="p-7">

                        {{-- Category --}}
                        <span class="inline-block bg-teal-100 text-teal-700 text-sm font-medium px-4 py-1 rounded-full">

                            {{ $destination->category->name ?? 'Uncategorized' }}

                        </span>

                        {{-- Title --}}
                        <h2 class="text-2xl font-bold text-gray-800 mt-5">

                            {{ $destination->name }}

                        </h2>

                        {{-- Location --}}
                        <div class="mt-3">

                            <span class="text-sm uppercase tracking-wide text-gray-400">

                                Location

                            </span>

                            <p class="text-gray-700 font-medium mt-1">

                                {{ $destination->location }}

                            </p>

                        </div>

                        {{-- Description --}}
                        <p class="mt-5 text-gray-600 leading-8 text-justify">

                            {{ \Illuminate\Support\Str::limit(strip_tags($destination->description),130) }}

                        </p>

                        {{-- Button --}}
                        <a
                            href="{{ route('frontend.destinations.show',$destination) }}"
                            class="inline-flex items-center mt-8 bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-3 rounded-full transition">

                            View Detail

                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-3 py-20 text-center">

                    <h2 class="text-3xl font-bold text-gray-500">

                        Destination Not Found

                    </h2>

                    <p class="mt-3 text-gray-400">

                        Try another keyword or category.

                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-16">

            {{ $destinations->links() }}

        </div>

    </div>

</section>
@endsection