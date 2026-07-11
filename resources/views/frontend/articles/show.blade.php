@extends('layouts.frontend')

@section('title',$article->title)

@section('content')

<section class="relative h-[550px]">

@if($article->image)

<img
src="{{ asset('storage/'.$article->image) }}"
class="absolute inset-0 w-full h-full object-cover">

@endif

<div class="absolute inset-0 bg-black/60"></div>

<div class="relative z-10 flex items-center justify-center h-full">

<div class="text-center text-white max-w-4xl">

<p class="uppercase tracking-[10px] text-cyan-300">

East Lombok Blog

</p>

<h1 class="text-6xl font-bold mt-5">

{{ $article->title }}

</h1>

<p class="mt-8 text-xl">

{{ $article->created_at->format('d F Y') }}

</p>

</div>

</div>

</section>

<section class="py-20">

<div class="max-w-5xl mx-auto px-6">

<a
href="{{ route('frontend.articles') }}"
class="text-teal-600 font-semibold">

← Back to Articles

</a>

<div class="bg-white shadow-xl rounded-3xl p-12 mt-10">

<div class="prose prose-lg max-w-none">

{!! $article->content !!}

</div>

</div>

</div>

</section>

<section class="py-20 bg-slate-50">

<div class="max-w-5xl mx-auto px-6">

<a
href="{{ route('frontend.articles') }}"
class="text-teal-600"
>

← Back

</a>

@if($article->thumbnail)

<img
src="{{ asset('storage/'.$article->thumbnail) }}"
class="w-full h-[450px] object-cover rounded-3xl mt-8"
>

@endif

<h1 class="text-5xl font-bold mt-10">

{{ $article->title }}

</h1>

<p class="mt-4 text-gray-500">

{{ $article->created_at->format('d F Y') }}

</p>

<div class="prose max-w-none mt-10">

{!! $article->content !!}

</div>

</div>

</section>

@if($related->count())

<section class="py-20">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-4xl font-bold mb-10">

Related Articles

</h2>

<div class="grid md:grid-cols-3 gap-8">

@foreach($related as $item)

<div class="bg-white rounded-3xl shadow overflow-hidden">

@if($item->thumbnail)

<img
src="{{ asset('storage/'.$item->thumbnail) }}"
class="w-full h-52 object-cover"
>

@endif

<div class="p-6">

<h3 class="text-xl font-bold">

{{ $item->title }}

</h3>

<p class="mt-3 text-gray-600">

{{ \Illuminate\Support\Str::limit(strip_tags($item->content),100) }}

</p>

<a
href="{{ route('frontend.articles.show',$item) }}"
class="inline-block mt-4 text-teal-600 font-semibold"
>

Read More →

</a>

</div>

</div>

@endforeach

</div>

</div>

</section>

@endif

@if($related->count())

<section class="bg-gray-50 py-20">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-4xl font-bold mb-10">

Related Articles

</h2>

<div class="grid md:grid-cols-3 gap-8">

@foreach($related as $item)

<div class="bg-white rounded-2xl shadow overflow-hidden">

@if($item->image)

<img
src="{{ asset('storage/'.$item->image) }}"
class="w-full h-52 object-cover">

@endif

<div class="p-6">

<p class="text-sm text-gray-500">

{{ $item->created_at->format('d M Y') }}

</p>

<h3 class="text-2xl font-bold mt-3">

{{ $item->title }}

</h3>

<p class="mt-3 text-gray-600">

{{ \Illuminate\Support\Str::limit(strip_tags($item->content),100) }}

</p>

<a
href="{{ route('frontend.articles.show',$item) }}"
class="inline-block mt-5 text-teal-600 font-semibold">

Read More →

</a>

</div>

</div>

@endforeach

</div>

</div>

</section>

@endif

@endsection