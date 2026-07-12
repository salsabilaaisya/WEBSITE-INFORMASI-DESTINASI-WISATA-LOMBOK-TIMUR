@extends('layouts.frontend')

@section('title', $article->title . ' - East Lombok Blog')

@section('content')

{{-- HERO ARTICLE SECTION --}}
<section class="relative h-[60vh] min-h-[500px] flex items-end pb-16">
    @if($article->thumbnail)
        <img
            src="{{ asset('storage/'.$article->thumbnail) }}"
            class="absolute inset-0 h-full w-full object-cover"
            alt="{{ $article->title }}"
        >
    @else
        <div class="absolute inset-0 h-full w-full bg-gray-900"></div>
    @endif

    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/10"></div>

    <div class="relative z-10 w-full max-w-4xl mx-auto px-6 text-center">
        <a href="{{ route('frontend.articles') }}" class="inline-flex items-center text-teal-400 hover:text-teal-300 transition-colors font-medium mb-8 bg-black/30 px-4 py-2 rounded-full backdrop-blur-sm border border-white/10">
            ← Back to Articles
        </a>

        <div class="flex items-center justify-center gap-4 text-gray-300 font-medium tracking-wide uppercase text-sm mb-6">
            <span>East Lombok</span>
            <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
            <span>{{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->format('F d, Y') }}</span>
        </div>

        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight drop-shadow-lg mb-6">
            {{ $article->title }}
        </h1>
    </div>
</section>

{{-- ARTICLE CONTENT SECTION --}}
<section class="bg-white py-16 lg:py-24 relative">
    <div class="mx-auto max-w-4xl px-6 relative -mt-32 z-20">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-16 lg:p-20 border border-gray-100">
            
            <div class="article-body text-gray-700 text-lg md:text-xl leading-relaxed">
                {!! $article->content !!}
            </div>

        </div>
    </div>
</section>

<style>
    .article-body h2 {
        font-size: 2rem !important;
        font-weight: 700 !important;
        color: #111827 !important;
        margin-top: 1.5rem !important;
        margin-bottom: 1rem !important;
    }
    .article-body p {
        margin-bottom: 1.5rem !important;
        line-height: 1.8 !important;
    }
</style>

{{-- RELATED ARTICLES SECTION --}}
@if(isset($related) && $related->count())
<section class="py-24 bg-gray-50 border-t border-gray-200">
    <div class="mx-auto max-w-7xl px-6">
        <h2 class="mb-12 text-3xl font-bold text-gray-900 text-center">You might also like</h2>
        <div class="grid gap-8 md:grid-cols-3">
            @foreach($related as $item)
                <article class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <a href="{{ route('frontend.articles.show', $item) }}" class="block relative h-52 overflow-hidden">
                        @if($item->thumbnail)
                            <img src="{{ asset('storage/'.$item->thumbnail) }}" class="w-full h-full object-cover">
                        @endif
                    </a>
                    <div class="p-6 md:p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item->title }}</h3>
                        <a href="{{ route('frontend.articles.show', $item) }}" class="text-teal-600 font-semibold text-sm">Read Article →</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection