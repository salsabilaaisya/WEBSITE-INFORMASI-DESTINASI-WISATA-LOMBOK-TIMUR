@extends('layouts.frontend')

@section('title','Destinations')

@section('content')

<section class="bg-gradient-to-b from-teal-50 to-white py-20">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center">

            <h1 class="text-5xl font-bold text-slate-800">
                Explore East Lombok
            </h1>

            <p class="mt-4 text-slate-500 max-w-2xl mx-auto">
                Discover the beauty of beaches, mountains and culture in East Lombok.
            </p>

        </div>

        <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

            @forelse($destinations as $destination)

            <div class="overflow-hidden rounded-3xl bg-white shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                <img
                    src="{{ asset('storage/'.$destination->cover_path) }}"
                    class="h-64 w-full object-cover">

                <div class="p-6">

                    <span class="rounded-full bg-teal-100 px-3 py-1 text-xs font-semibold text-teal-700">
                        {{ $destination->category->name }}
                    </span>

                    <h2 class="mt-4 text-2xl font-bold">
                        {{ $destination->name }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        📍 {{ $destination->location }}
                    </p>

                    <p class="mt-4 line-clamp-3 text-slate-600">
                        {{ $destination->description }}
                    </p>

                    <a
                        href="{{ route('frontend.destinations.show',$destination) }}"
                        class="mt-6 inline-flex rounded-xl bg-teal-600 px-5 py-3 font-medium text-white transition hover:bg-teal-700">

                        View Detail

                    </a>

                </div>

            </div>

            @empty

            <div class="col-span-3 rounded-xl bg-white p-10 text-center shadow">

                Belum ada destination.

            </div>

            @endforelse

        </div>

    </div>

</section>

@endsection