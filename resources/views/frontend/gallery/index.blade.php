@extends('layouts.frontend')

@section('title', 'Gallery')

@section('content')

{{-- HERO --}}
<section class="relative h-[50vh] overflow-hidden">
    <img
        src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
        class="absolute inset-0 h-full w-full object-cover"
        alt="East Lombok Hero Image"
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
            {{-- Form pencarian otomatis mengirim data saat menekan Enter --}}
            <form action="{{ url()->current() }}" method="GET">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search destination or caption..."
                    class="w-full rounded-full border border-gray-300 px-6 py-4 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 outline-none transition-all shadow-sm"
                >
            </form>
        </div>
    </div>
</section>

{{-- FILTER --}}
<section class="py-8">
    <div class="mx-auto flex max-w-7xl flex-wrap justify-center gap-4 px-6">
        
        {{-- Tombol Semua --}}
        <a href="{{ url()->current() . (request('search') ? '?search='.request('search') : '') }}" 
           class="rounded-full px-6 py-2 transition-all font-medium {{ !request('category') ? 'bg-teal-600 text-white shadow-md' : 'border border-gray-300 text-gray-700 hover:bg-teal-600 hover:text-white' }}">
            Semua
        </a>

        {{-- Tombol Pantai --}}
        <a href="{{ url()->current() . '?category=pantai' . (request('search') ? '&search='.request('search') : '') }}" 
           class="rounded-full px-6 py-2 transition-all font-medium {{ request('category') == 'pantai' ? 'bg-teal-600 text-white shadow-md' : 'border border-gray-300 text-gray-700 hover:bg-teal-600 hover:text-white' }}">
            Pantai
        </a>

        {{-- Tombol Gunung --}}
        <a href="{{ url()->current() . '?category=gunung' . (request('search') ? '&search='.request('search') : '') }}" 
           class="rounded-full px-6 py-2 transition-all font-medium {{ request('category') == 'gunung' ? 'bg-teal-600 text-white shadow-md' : 'border border-gray-300 text-gray-700 hover:bg-teal-600 hover:text-white' }}">
            Gunung
        </a>

        {{-- Tombol Air Terjun --}}
        <a href="{{ url()->current() . '?category=air-terjun' . (request('search') ? '&search='.request('search') : '') }}" 
           class="rounded-full px-6 py-2 transition-all font-medium {{ request('category') == 'air-terjun' ? 'bg-teal-600 text-white shadow-md' : 'border border-gray-300 text-gray-700 hover:bg-teal-600 hover:text-white' }}">
            Air Terjun
        </a>

    </div>
</section>

{{-- GALLERY --}}
<section class="pb-20">
    <div class="mx-auto max-w-7xl px-6">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

            @forelse($galleries as $gallery)
                <div class="group overflow-hidden rounded-3xl bg-white shadow-lg duration-300 hover:-translate-y-2 hover:shadow-2xl border border-gray-100">
                    <div class="overflow-hidden h-72">
                        <img
                            src="{{ asset('storage/'.$gallery->image) }}"
                            class="h-full w-full object-cover duration-500 group-hover:scale-110"
                            alt="{{ $gallery->caption }}"
                        >
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 line-clamp-1">
                            {{ $gallery->caption }}
                        </h3>
                        <p class="mt-2 text-gray-500 flex items-center gap-1 font-medium text-sm">
                            📍 {{ $gallery->destination->name ?? 'Unknown' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-gray-400 text-lg">No gallery images found matching your criteria.</p>
                    @if(request('search') || request('category'))
                        <a href="{{ url()->current() }}" class="mt-4 inline-block text-teal-600 font-semibold hover:underline">Reset Filters</a>
                    @endif
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection