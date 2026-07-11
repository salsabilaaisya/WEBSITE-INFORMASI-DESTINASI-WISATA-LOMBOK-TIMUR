@extends('layouts.frontend')

@section('title','Articles')

@section('content')

{{-- HERO --}}
<section class="relative h-[500px] overflow-hidden">

    <img
        src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800"
        class="absolute inset-0 w-full h-full object-cover"
    >

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 flex h-full items-center justify-center">

        <div class="text-center text-white max-w-3xl">

            <h1 class="text-6xl font-bold">
                East Lombok Blog
            </h1>

            <p class="mt-6 text-xl text-gray-200">
                Discover tourism destinations, local culture,
                culinary experiences and travel inspiration.
            </p>

        </div>

    </div>

</section>

<section class="bg-white py-10">

<div class="max-w-7xl mx-auto px-6">

<form method="GET">

<div class="max-w-xl mx-auto">

<input
type="text"
name="search"
value="{{ request('search') }}"
placeholder="Search article..."
class="w-full rounded-full border border-gray-300 px-7 py-4 shadow focus:ring-2 focus:ring-teal-500"
/>

</div>

</form>

</div>

</section>

<section class="py-20 bg-gray-50">

<div class="max-w-7xl mx-auto px-6">

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

@forelse($articles as $article)

<div class="bg-white rounded-3xl overflow-hidden shadow hover:shadow-2xl transition duration-300">

@if($article->image)

<img
src="{{ asset('storage/'.$article->image) }}"
class="w-full h-64 object-cover"
/>

@endif

<div class="p-7">

<p class="text-sm text-gray-500">

{{ $article->created_at->format('d F Y') }}

</p>

<h2 class="text-2xl font-bold mt-3">

{{ $article->title }}

</h2>

<p class="mt-4 text-gray-600">

{{ \Illuminate\Support\Str::limit(strip_tags($article->content),140) }}

</p>

<a
href="{{ route('frontend.articles.show',$article) }}"
class="inline-flex items-center mt-6 text-teal-600 font-semibold hover:text-teal-700"
>

Read More →

</a>

</div>

</div>

@empty

<div class="col-span-3 text-center py-20">

<h2 class="text-3xl text-gray-500">

No Articles Found

</h2>

</div>

@endforelse

</div>

<div class="mt-14">

{{ $articles->links() }}

</div>

</div>

</section>

@endsection