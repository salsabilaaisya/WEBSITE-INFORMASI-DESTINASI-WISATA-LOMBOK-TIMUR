@extends('layouts.frontend')

@section('content')

{{-- ==========================================
        HERO
========================================== --}}
<section class="relative h-[650px] overflow-hidden">

    {{-- Background Image --}}
    @if(!empty($about?->image))

        <img
            src="{{ asset('storage/'.$about->image) }}"
            alt="{{ $about?->title }}"
            class="absolute inset-0 w-full h-full object-cover">

    @else

        <div class="absolute inset-0 bg-slate-300"></div>

    @endif

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/20"></div>

    {{-- Content --}}
    <div class="relative max-w-7xl mx-auto h-full px-6">

        <div class="flex items-center h-full">

            <div class="max-w-2xl text-white">

                {{-- Badge --}}
                <span
                    class="inline-flex items-center rounded-full bg-white/20 backdrop-blur px-5 py-2 text-sm font-medium tracking-wide">

                    🌴 Wonderful Destination

                </span>

                {{-- Title --}}
                <h1
                    class="mt-6 text-5xl md:text-6xl font-extrabold leading-tight">

                    {{ $about?->title ?? 'Explore East Lombok' }}

                </h1>

                {{-- Description --}}
                <p
                    class="mt-6 text-lg leading-8 text-slate-200">

                    {{ $about?->short_description ?? 'Temukan pantai, pegunungan, budaya, dan keindahan alam terbaik yang dimiliki Kabupaten Lombok Timur.' }}

                </p>

                {{-- Button --}}
                <div class="mt-10 flex gap-4">

                    <a
                        href="{{ route('frontend.destinations') }}"
                        class="rounded-full bg-orange-500 px-8 py-4 font-semibold text-white transition hover:bg-orange-600">

                        Explore Destinations

                    </a>

                    <a
                        href="{{ route('frontend.gallery') }}"
                        class="rounded-full border border-white px-8 py-4 font-semibold text-white transition hover:bg-white hover:text-slate-900">

                        View Gallery

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- ==========================================
        ABOUT WEBSITE
========================================== --}}
<section class="py-16 md:py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16 items-start">

            {{-- KOLOM KIRI (Tentang Website & Gambar Utama) --}}
            <div class="flex flex-col items-start w-full">
                
                {{-- Badge "ABOUT US" --}}
                <span class="inline-flex px-4 py-1.5 rounded-full bg-emerald-100/70 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                    About Us
                </span>

                {{-- Judul Utama Dinamis (Mengecil otomatis di HP agar tidak patah berantakan) --}}
                <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight leading-tight">
                    Tentang Website
                </h2>

                {{-- Deskripsi Pendek --}}
                <p class="mt-4 text-[15px] sm:text-[16px] text-slate-500 leading-relaxed">
                    Mengenal lebih dekat informasi wisata Kabupaten Lombok Timur.
                </p>

                {{-- Garis Pembatas Hijau (Pemberi jarak setelah teks) --}}
                <div class="w-14 h-1 bg-emerald-500 mt-5 mb-8 rounded-full"></div>

                {{-- Gambar Utama (Tinggi otomatis menyesuaikan device agar user-friendly) --}}
                <img
                    src="{{ asset('storage/'.$about->image) }}"
                    alt="{{ $about->title }}"
                    class="w-full h-[250px] sm:h-[350px] md:h-[420px] lg:h-[480px] rounded-[30px] object-cover shadow-xl">

            </div>

            {{-- KOLOM KANAN (Informasi Detail & Bottom Cards) --}}
            <div class="space-y-8 w-full">

                {{-- Item 1 --}}
                <div class="flex gap-4 sm:gap-6 items-start">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0 text-emerald-700">
                        {{-- Icon Mountain --}}
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375 0 1 1-.75 0 .375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                            Keindahan Alam
                        </h3>
                        <p class="mt-1.5 sm:mt-2 text-[14px] sm:text-[15px] text-slate-500 leading-relaxed">
                            Lombok Timur adalah sebuah harmoni sempurna antara kemegahan alam dan warisan leluhur. Di sini, Anda bisa merasakan dinginnya kabut pagi di Lembah Sembalun yang berdiri megah di bawah kaki Gunung Rinjani.
                        </p>
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- Item 2 --}}
                <div class="flex gap-4 sm:gap-6 items-start">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0 text-emerald-700">
                        {{-- Icon Beach / Sun --}}
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                            Pantai Eksotis
                        </h3>
                        <p class="mt-1.5 sm:mt-2 text-[14px] sm:text-[15px] text-slate-500 leading-relaxed">
                            Nikmati keunikan pasir merah muda di Pantai Pink, hingga meresapi ketenangan hidup pedesaan yang asri di Tetebatu.
                        </p>
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- Item 3 --}}
                <div class="flex gap-4 sm:gap-6 items-start">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0 text-emerald-700">
                        {{-- Icon Traditional House --}}
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                            Budaya yang Lestari
                        </h3>
                        <p class="mt-1.5 sm:mt-2 text-[14px] sm:text-[15px] text-slate-500 leading-relaxed">
                            Lombok Timur juga menyimpan kehangatan budaya suku Sasak yang masih terjaga kelestariannya.
                        </p>
                    </div>
                </div>

                {{-- Bottom Cards (Grid 2 Kolom) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">

                    {{-- Card 1 --}}
                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm hover:shadow-md transition duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700 shrink-0">
                                {{-- Icon Map/Book --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                            <h4 class="text-[16px] font-bold text-slate-900 leading-tight">
                                Apa yang Kami Sajikan?
                            </h4>
                        </div>
                        <p class="text-[14px] text-slate-500 leading-relaxed">
                            Panduan Destinasi Lengkap: Mulai dari wisata gunung, air terjun tersembunyi, gili eksotis, hingga pantai-pantai perawan.
                        </p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm hover:shadow-md transition duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700 shrink-0">
                                {{-- Icon Lightbulb --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.82 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.496 1.508 1.333 1.508 2.316V18" />
                                </svg>
                            </div>
                            <h4 class="text-[16px] font-bold text-slate-900 leading-tight">
                                Tips & Trik Perjalanan
                            </h4>
                        </div>
                        <p class="text-[14px] text-slate-500 leading-relaxed">
                            Informasi rute, transportasi, akomodasi terbaik, dan estimasi biaya agar liburan Anda lebih hemat dan nyaman.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- =========================
    VISION & MISSION
========================= --}}
<section class="py-24 bg-gradient-to-b from-slate-50 to-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">

            <span
                class="text-orange-500 font-semibold tracking-[0.25em] uppercase">

                Vision & Mission

            </span>

            <h2
                class="mt-4 text-4xl font-bold text-slate-900">

                Our Commitment

            </h2>

            <p
                class="mt-4 text-slate-500 max-w-2xl mx-auto">

                Kami berkomitmen menjadi media informasi wisata yang
                terpercaya serta membantu wisatawan mengenal Lombok Timur
                lebih dekat.

            </p>

        </div>

        <div class="grid lg:grid-cols-2 gap-10 items-stretch">

            {{-- Vision --}}

            <div
            class="rounded-3xl bg-white p-10 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl h-full">

            <div
                class="w-16 h-16 rounded-full bg-sky-100 flex items-center justify-center">

                👁️

            </div>

            <h3
                class="mt-8 text-3xl font-bold text-slate-900">

                Our Vision

            </h3>

            <div
                class="mt-8 border-l-4 border-sky-500 pl-6">

                <p
                    class="italic text-slate-600 leading-9">

                    "{{ $about?->vision ?? '-' }}"

                </p>

            </div>

        </div>

            {{-- Mission --}}

        </div>

    </div>

        <div
            class="rounded-3xl bg-white p-10 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl h-full">

            <div
                class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center">

                🚀

            </div>

            <h3
                class="mt-8 text-3xl font-bold">

                Our Mission

            </h3>

            @php

                $missions = preg_split('/\r\n|\r|\n/', $about?->mission ?? '');

            @endphp

            <ul class="mt-8 space-y-6">

                @foreach($missions as $mission)

                    @if(trim($mission))

                        <li class="flex items-start gap-4">

                            <div
                                class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white font-bold">

                                ✓

                            </div>

                            <p
                                class="leading-8 text-slate-600">

                                {{ trim($mission) }}

                            </p>

                        </li>

                    @endif

                @endforeach

            </ul>

        </div>

</section>

{{-- ==========================================
        STATISTICS
========================================== --}}
<section class="py-24 bg-slate-50">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">

            <span
                class="text-orange-500 font-semibold uppercase tracking-[0.25em]">

                OUR STATISTICS

            </span>

            <h2
                class="mt-4 text-4xl font-bold text-slate-900">

                Explore East Lombok in Numbers

            </h2>

            <p
                class="mt-4 text-slate-500 max-w-2xl mx-auto">

                Berbagai informasi wisata yang telah kami kumpulkan
                untuk membantu wisatawan menjelajahi Lombok Timur.

            </p>

        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">

            {{-- Destination --}}
            <div
                class="rounded-3xl bg-white p-8 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                <div
                    class="w-16 h-16 rounded-full bg-sky-100 flex items-center justify-center text-3xl">

                    📍

                </div>

                <h3
                    class="mt-6 text-5xl font-bold text-slate-900">

                    {{ $destinationCount }}

                </h3>

                <p
                    class="mt-2 text-slate-500">

                    Destinations

                </p>

            </div>

            {{-- Gallery --}}
            <div
                class="rounded-3xl bg-white p-8 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                <div
                    class="w-16 h-16 rounded-full bg-pink-100 flex items-center justify-center text-3xl">

                    🖼️

                </div>

                <h3
                    class="mt-6 text-5xl font-bold text-slate-900">

                    {{ $galleryCount }}

                </h3>

                <p
                    class="mt-2 text-slate-500">

                    Gallery

                </p>

            </div>

            {{-- Article --}}
            <div
                class="rounded-3xl bg-white p-8 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                <div
                    class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center text-3xl">

                    📰

                </div>

                <h3
                    class="mt-6 text-5xl font-bold text-slate-900">

                    {{ $articleCount }}

                </h3>

                <p
                    class="mt-2 text-slate-500">

                    Articles

                </p>

            </div>

            {{-- Category --}}
            <div
                class="rounded-3xl bg-white p-8 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                <div
                    class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-3xl">

                    🏷️

                </div>

                <h3
                    class="mt-6 text-5xl font-bold text-slate-900">

                    {{ $categoryCount }}

                </h3>

                <p
                    class="mt-2 text-slate-500">

                    Categories

                </p>

            </div>

        </div>

    </div>

</section>

{{-- ==========================================
        CONTACT & SOCIAL MEDIA
========================================== --}}
<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        {{-- Heading --}}
        <div class="text-center mb-16">

            <span
                class="text-orange-500 font-semibold uppercase tracking-[0.25em]">

                CONTACT

            </span>

            <h2
                class="mt-4 text-4xl font-bold text-slate-900">

                Contact Information & Social Media

            </h2>

            <p
                class="mt-4 text-slate-500 max-w-2xl mx-auto">

                Jangan ragu menghubungi kami atau ikuti media sosial
                untuk mendapatkan informasi wisata terbaru.

            </p>

        </div>

        <div class="grid lg:grid-cols-2 gap-10">

            {{-- CONTACT CARD --}}
            <div
                class="bg-slate-50 rounded-3xl shadow-lg p-10 hover:shadow-xl transition">

                <h3
                    class="text-2xl font-bold mb-8">

                    Contact Information

                </h3>

                <div class="space-y-6">

                    {{-- Address --}}
                    <div class="flex items-start gap-4">

                        <div
                            class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-2xl">

                            📍

                        </div>

                            <div>

                                <h4 class="font-semibold">
                                    Address
                                </h4>

                                <p class="text-slate-600">
                                    {{ $about->address }}
                                </p>

                        </div>

                    </div>

                    {{-- Phone --}}
                    <div class="flex items-start gap-4">

                        <div
                            class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-2xl">

                            📞

                        </div>

                        <div>

                            <h4 class="font-semibold">
                                Phone
                            </h4>

                            <p class="text-slate-600">
                                {{ $about->phone }}
                            </p>

                        </div>

                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">

                            ✉ 

                        </div>

                        <div>

                            <h4 class="font-semibold">
                                Email
                            </h4>

                            <p class="text-slate-600">
                                {{ $about->email }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            {{-- SOCIAL CARD --}}
<div class="bg-slate-50 rounded-3xl shadow-lg p-10">

    <h3 class="text-2xl font-bold text-slate-900">
        Follow Us
    </h3>

    <p class="text-slate-500 mt-2 mb-8">
        Ikuti media sosial kami untuk mendapatkan informasi wisata terbaru.
    </p>

    <div class="space-y-5">

        {{-- Instagram --}}
        @if(!empty($about?->instagram))
        <a href="{{ $about->instagram }}"
           target="_blank"
           rel="noopener noreferrer"
           class="group flex items-center gap-5 p-5 bg-white rounded-2xl border hover:border-pink-400 hover:shadow-lg transition">

            <div class="w-14 h-14 rounded-full bg-pink-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="#E4405F"
                     class="w-8 h-8">

                    <path d="M7.75 2C4.57 2 2 4.57 2 7.75v8.5C2 19.43 4.57 22 7.75 22h8.5C19.43 22 22 19.43 22 16.25v-8.5C22 4.57 19.43 2 16.25 2h-8.5zm0 2h8.5A3.75 3.75 0 0120 7.75v8.5A3.75 3.75 0 0116.25 20h-8.5A3.75 3.75 0 014 16.25v-8.5A3.75 3.75 0 017.75 4zm8.75 1a1.25 1.25 0 100 2.5A1.25 1.25 0 0016.5 5zm-4.5 1.25A5.25 5.25 0 106 11.5 5.25 5.25 0 0012 6.25zm0 2A3.25 3.25 0 1112 17a3.25 3.25 0 010-6.5z"/>
                </svg>

            </div>

            <div>
                <h4 class="font-semibold text-lg">
                    Instagram
                </h4>

                <p class="text-slate-500">
                    Follow our Instagram
                </p>
            </div>

        </a>
        @endif


        {{-- Facebook --}}
        @if(!empty($about?->facebook))
        <a href="{{ $about->facebook }}"
           target="_blank"
           rel="noopener noreferrer"
           class="group flex items-center gap-5 p-5 bg-white rounded-2xl border hover:border-blue-500 hover:shadow-lg transition">

            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="#1877F2"
                     class="w-8 h-8">

                    <path d="M22 12A10 10 0 1010.44 21.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.89h-2.33v6.99A10 10 0 0022 12z"/>
                </svg>

            </div>

            <div>
                <h4 class="font-semibold text-lg">
                    Facebook
                </h4>

                <p class="text-slate-500">
                    Visit our Facebook
                </p>
            </div>

        </a>
        @endif


        {{-- YouTube --}}
        @if(!empty($about?->youtube))
        <a href="{{ $about->youtube }}"
           target="_blank"
           rel="noopener noreferrer"
           class="group flex items-center gap-5 p-5 bg-white rounded-2xl border hover:border-red-500 hover:shadow-lg transition">

            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="#FF0000"
                     class="w-8 h-8">

                    <path d="M23.5 6.2a2.97 2.97 0 00-2.09-2.1C19.57 3.6 12 3.6 12 3.6s-7.57 0-9.41.5A2.97 2.97 0 00.5 6.2 31.87 31.87 0 000 12a31.87 31.87 0 00.5 5.8 2.97 2.97 0 002.09 2.1c1.84.5 9.41.5 9.41.5s7.57 0 9.41-.5a2.97 2.97 0 002.09-2.1A31.87 31.87 0 0024 12a31.87 31.87 0 00-.5-5.8zM9.75 15.5v-7l6.5 3.5-6.5 3.5z"/>
                </svg>

            </div>

            <div>
                <h4 class="font-semibold text-lg">
                    YouTube
                </h4>

                <p class="text-slate-500">
                    Watch our videos
                </p>
            </div>

        </a>
        @endif

    </div>

</div>

</div>

</div>

</seaction>

{{-- ==========================================
        LOCATION
========================================== --}}
<section class="py-24 bg-white">

    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-14">

            <span
                class="inline-block bg-green-100 text-green-700 px-6 py-2 rounded-full font-semibold">

                OUR LOCATION

            </span>

            <h2
                class="text-5xl font-bold text-slate-900 mt-6">

                Visit Our Office

            </h2>

            <p
                class="text-slate-500 mt-5 max-w-3xl mx-auto text-lg leading-8">

                Find our tourism information center in East Lombok.
                We are ready to assist your travel planning.

            </p>

        </div>

        {{-- Google Maps --}}
        <div
            class="overflow-hidden rounded-3xl shadow-xl">

            <iframe
                src="https://www.google.com/maps?q=Lombok+Timur&output=embed"
                width="100%"
                height="500"
                style="border:0;"
                allowfullscreen
                loading="lazy">
            </iframe>

        </div>

    </div>

</section>

{{-- ==========================================
        CTA
========================================== --}}
<section class="py-24">

    <div class="max-w-6xl mx-auto px-6">

        <div
            class="relative rounded-[35px] overflow-hidden">

            {{-- Background --}}
            <img
                src="{{ asset('storage/'.$about->image) }}"
                class="absolute inset-0 w-full h-full object-cover">

            {{-- Overlay --}}
            <div
                class="absolute inset-0 bg-gradient-to-r from-black/70 to-emerald-700/60">
            </div>

            {{-- Content --}}
            <div
                class="relative z-10 py-24 px-12 text-center text-white">

                <h2
                    class="text-5xl font-bold">

                    Ready to Explore East Lombok?

                </h2>

                <p
                    class="mt-6 max-w-3xl mx-auto text-xl leading-9">

                    Discover beautiful beaches, majestic mountains,
                    waterfalls, local culture, culinary experiences,
                    and unforgettable adventures.

                </p>

                <a
                    href="{{ route('frontend.destinations') }}"
                    class="inline-flex mt-10 px-10 py-4 bg-white text-emerald-700 rounded-full font-semibold hover:scale-105 transition">

                    Explore Destinations →

                </a>

            </div>

        </div>

    </div>

</section>

@endsection