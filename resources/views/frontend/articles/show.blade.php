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

    {{-- Dark gradient for text readability --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/10"></div>

    <div class="relative z-10 w-full max-w-4xl mx-auto px-6 text-center">
        <a href="{{ route('frontend.articles') }}" class="inline-flex items-center text-teal-400 hover:text-teal-300 transition-colors font-medium mb-8 bg-black/30 px-4 py-2 rounded-full backdrop-blur-sm border border-white/10">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Articles
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
    
    {{-- Main Article Card --}}
    <div class="mx-auto max-w-4xl px-6 relative -mt-32 z-20">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-16 lg:p-20 border border-gray-100">
            
            {{-- TIPTAP/HTML CONTENT RENDER AREA --}}
            {{-- Menggunakan class 'prose' agar tag <p> dan spacing antar paragraf dari admin muncul dengan benar --}}
            <article class="prose prose-lg md:prose-xl prose-slate max-w-none 
                prose-headings:font-bold prose-headings:text-gray-900 
                prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-6
                prose-a:text-teal-600 hover:prose-a:text-teal-700 
                prose-img:rounded-2xl prose-img:shadow-lg 
                prose-blockquote:border-teal-500 prose-blockquote:bg-gray-50 prose-blockquote:p-4 prose-blockquote:rounded-r-xl prose-blockquote:not-italic prose-blockquote:text-gray-700">
                
                {!! $article->content !!}
                

            </article>

        </div>
    </div>
</section>

{{-- RELATED ARTICLES SECTION --}}
@if(isset($related) && $related->count())
<section class="py-24 bg-gray-50 border-t border-gray-200">
    <div class="mx-auto max-w-7xl px-6">
        
        <h2 class="mb-12 text-3xl font-bold text-gray-900 text-center">
            You might also like
        </h2>

        <div class="grid gap-8 md:grid-cols-3">
            @foreach($related as $item)
                <article class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <a href="{{ route('frontend.articles.show', $item) }}" class="block relative h-52 overflow-hidden">
                        @if($item->thumbnail)
                            <img
                                src="{{ asset('storage/'.$item->thumbnail) }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="{{ $item->title }}">
                        @endif
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                    </a>

                    <div class="p-6 md:p-8">
                        <p class="text-sm font-medium text-teal-600 mb-3">
                            {{ \Carbon\Carbon::parse($item->published_at ?? $item->created_at)->format('M d, Y') }}
                        </p>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 leading-snug group-hover:text-teal-600 transition-colors line-clamp-2">
                            <a href="{{ route('frontend.articles.show', $item) }}">
                                {{ $item->title }}
                            </a>
                        </h3>

                        <p class="text-gray-600 line-clamp-2 mb-5 text-sm">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}
                        </p>

                        <a href="{{ route('frontend.articles.show', $item) }}" class="inline-flex font-semibold text-teal-600 hover:text-teal-800 text-sm items-center transition-colors">
                            Read Article 
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection