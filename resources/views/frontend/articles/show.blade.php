@extends('layouts.frontend')

@section('title', $article->title)

@section('content')

{{-- HERO --}}
<section class="relative h-[550px] overflow-hidden">

    @if($article->thumbnail)
        <img
            src="{{ asset('storage/'.$article->thumbnail) }}"
            class="absolute inset-0 h-full w-full object-cover"
            alt="{{ $article->title }}">
    @endif

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 flex h-full items-center justify-center">

        <div class="max-w-4xl px-6 text-center text-white">

            <p class="text-sm uppercase tracking-[8px] text-cyan-300">
                EAST LOMBOK BLOG
            </p>

            <h1 class="mt-6 text-5xl font-bold leading-tight md:text-6xl">
                {{ $article->title }}
            </h1>

            <p class="mt-8 text-lg text-gray-200">
                {{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->format('d F Y') }}
            </p>

        </div>

    </div>

</section>

{{-- ARTICLE --}}
<section class="bg-gray-50 py-20">

    <div class="mx-auto max-w-5xl px-6">

        <a
            href="{{ route('frontend.articles') }}"
            class="inline-flex items-center font-semibold text-teal-600 transition hover:text-teal-700">

            ← Back to Articles

        </a>

        <div class="mt-8 rounded-3xl bg-white p-8 shadow-xl md:p-14">

            <article class="article-content">

                {!! $article->content !!}

            </article>

        </div>

    </div>

</section>

{{-- RELATED ARTICLE --}}
@if($related->count())

<section class="py-20">

    <div class="mx-auto max-w-7xl px-6">

        <h2 class="mb-12 text-4xl font-bold">
            Related Articles
        </h2>

        <div class="grid gap-8 md:grid-cols-3">

            @foreach($related as $item)

                <div class="overflow-hidden rounded-3xl bg-white shadow transition duration-300 hover:shadow-xl">

                    @if($item->thumbnail)

                        <img
                            src="{{ asset('storage/'.$item->thumbnail) }}"
                            class="h-52 w-full object-cover"
                            alt="{{ $item->title }}">

                    @endif

                    <div class="p-6">

                        <p class="text-sm text-gray-500">
                            {{ $item->created_at->format('d F Y') }}
                        </p>

                        <h3 class="mt-3 text-2xl font-bold">
                            {{ $item->title }}
                        </h3>

                        <p class="mt-4 text-justify leading-7 text-gray-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content),120) }}
                        </p>

                        <a
                            href="{{ route('frontend.articles.show',$item) }}"
                            class="mt-6 inline-flex font-semibold text-teal-600 hover:text-teal-700">

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