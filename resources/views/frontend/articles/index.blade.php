@extends('layouts.frontend')

@section('title', 'Articles - East Lombok Blog')

@section('content')

{{-- HERO SECTION --}}
<section class="relative h-[600px] overflow-hidden flex items-center justify-center">
    {{-- Background Image with Parallax feel --}}
    <img
        src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2070&auto=format&fit=crop"
        class="absolute inset-0 w-full h-full object-cover scale-105"
        alt="East Lombok Hero"
    >
    
    {{-- Elegant Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/80"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center text-white px-6 max-w-4xl mx-auto animate-fade-in-up">
        <span class="px-4 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-teal-300 text-sm font-semibold tracking-widest uppercase mb-6 inline-block backdrop-blur-sm">
            Explore The Beauty
        </span>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 drop-shadow-lg">
            East Lombok <span class="text-teal-400 font-serif italic text-6xl md:text-8xl">Blog</span>
        </h1>
        <p class="text-lg md:text-2xl text-gray-300 font-light leading-relaxed max-w-2xl mx-auto">
            Discover breathtaking tourism destinations, authentic local culture, and unforgettable culinary experiences.
        </p>
    </div>
</section>

{{-- SEARCH SECTION --}}
<section class="bg-gray-50/50 py-12 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6">
        <form method="GET" action="{{ route('frontend.articles') }}" class="max-w-2xl mx-auto relative group">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <svg class="h-6 w-6 text-gray-400 group-focus-within:text-teal-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search articles, destinations, or culture..."
                class="block w-full pl-14 pr-6 py-4 bg-white border-none rounded-full text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal-500 sm:text-lg sm:leading-6 transition-all hover:shadow-md"
            />
            <button type="submit" class="absolute inset-y-2 right-2 px-6 bg-teal-600 hover:bg-teal-700 text-white rounded-full font-medium transition-colors shadow-sm">
                Search
            </button>
        </form>
    </div>
</section>

{{-- ARTICLES GRID SECTION --}}
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Latest Stories</h2>
                <p class="text-gray-500 mt-2">Catch up on our newest travel guides and stories.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
            @forelse($articles as $article)
                <article class="group flex flex-col bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                    
                    {{-- Image Container with Hover Zoom --}}
                    <a href="{{ route('frontend.articles.show', $article) }}" class="relative h-64 overflow-hidden block">
                        @if($article->thumbnail) {{-- Menggunakan thumbnail agar konsisten dengan form backend --}}
                            <img
                                src="{{ asset('storage/'.$article->thumbnail) }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="{{ $article->title }}"
                            />
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>

                    {{-- Content --}}
                    <div class="flex flex-col flex-1 p-8">
                        <div class="flex items-center gap-3 text-sm text-gray-500 mb-4 font-medium">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->format('M d, Y') }}
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-teal-600 transition-colors">
                            <a href="{{ route('frontend.articles.show', $article) }}">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <p class="text-gray-600 leading-relaxed mb-6 line-clamp-3 flex-1">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <a href="{{ route('frontend.articles.show', $article) }}" class="inline-flex items-center text-teal-600 font-semibold hover:text-teal-800 transition-colors">
                                Read full story 
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-24 px-6 text-center bg-white rounded-3xl border border-gray-200 border-dashed">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Articles Found</h3>
                    <p class="text-gray-500 max-w-sm">We couldn't find any articles matching your search. Try adjusting your keywords.</p>
                    <a href="{{ route('frontend.articles') }}" class="mt-6 text-teal-600 font-medium hover:underline">Clear Search</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-16">
            {{ $articles->links() }}
        </div>
    </div>
</section>

@endsection