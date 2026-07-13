@extends('layouts.frontend')

@section('title', $destination->name)

@section('content')

{{-- HERO --}}
<section class="relative h-[600px] overflow-hidden">

    @if($destination->cover_path)
        <img
            src="{{ asset('storage/'.$destination->cover_path) }}"
            class="absolute inset-0 w-full h-full object-cover">
    @endif

    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/50 to-black/70"></div>

    <div class="relative z-10 flex items-center justify-center h-full">

        <div class="text-center text-white max-w-4xl px-6">

            <span class="inline-block bg-teal-500 px-5 py-2 rounded-full text-sm font-semibold shadow-lg">
                {{ $destination->category->name }}
            </span>

            <h1 class="mt-6 text-5xl md:text-6xl font-bold leading-tight">
                {{ $destination->name }}
            </h1>

            <div class="mt-8 flex justify-center">

                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md rounded-2xl px-6 py-4 shadow-xl">

                    <div class="w-12 h-12 rounded-full bg-teal-500 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6 text-white"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0"/>

                        </svg>

                    </div>

                    <div class="text-left">

                        <p class="text-xs uppercase tracking-widest text-teal-200">
                            Location
                        </p>

                        <p class="text-lg font-semibold">
                            {{ $destination->location }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- DESCRIPTION --}}
<section class="py-20 bg-slate-50">

<div class="max-w-6xl mx-auto px-6">

<a
href="{{ route('frontend.destinations') }}"
class="inline-flex items-center gap-2 text-teal-600 hover:text-teal-700 font-semibold">

← Back to Destinations

</a>

<div class="bg-white rounded-3xl shadow-xl mt-10 p-10">

<h2 class="text-3xl font-bold text-slate-800 mb-8">

About Destination

</h2>

<div class="prose prose-lg max-w-none text-gray-700 leading-9">

{!! nl2br(e($destination->description)) !!}

</div>

</div>

</div>

</section>



{{-- GALLERY --}}
<section class="py-20 bg-white">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-4xl font-bold text-center mb-14">

Photo Gallery

</h2>

@if($destination->galleries->count())

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

@foreach($destination->galleries as $gallery)

<div class="group rounded-3xl overflow-hidden shadow-lg bg-white hover:shadow-2xl transition">

<img
src="{{ asset('storage/'.$gallery->image) }}"
class="w-full h-72 object-cover group-hover:scale-110 transition duration-700">

<div class="p-6">

<h3 class="font-semibold text-lg">

{{ $gallery->caption }}

</h3>

</div>

</div>

@endforeach

</div>

@else

<div class="bg-slate-100 rounded-3xl p-16 text-center text-slate-500">

No gallery available.

</div>

@endif

</div>

</section>



{{-- RELATED --}}
@if($related->count())

<section class="py-20 bg-slate-50">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-4xl font-bold mb-12">

Related Destinations

</h2>

<div class="grid md:grid-cols-3 gap-8">

@foreach($related as $item)

<a
href="{{ route('frontend.destinations.show',$item) }}"
class="rounded-3xl overflow-hidden bg-white shadow-lg hover:shadow-2xl transition duration-300">

@if($item->cover_path)

<img
src="{{ asset('storage/'.$item->cover_path) }}"
class="w-full h-60 object-cover">

@endif

<div class="p-6">

<span class="inline-block bg-teal-100 text-teal-700 text-sm px-4 py-1 rounded-full">

{{ $item->category->name ?? '-' }}

</span>

<h3 class="text-2xl font-bold mt-5">

{{ $item->name }}

</h3>

<div class="mt-5 flex items-center gap-3">

<div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 text-teal-600"
fill="none"
viewBox="0 0 24 24"
stroke="currentColor">

<path
stroke-linecap="round"
stroke-linejoin="round"
stroke-width="2"
d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>

<path
stroke-linecap="round"
stroke-linejoin="round"
stroke-width="2"
d="M15 11a3 3 0 11-6 0 3 3 0 016 0"/>

</svg>

</div>

<span class="text-gray-600">

{{ $item->location }}

</span>

</div>

</div>

</a>

@endforeach

</div>

</div>

</section>

@endif

@endsection