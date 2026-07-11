@extends('layouts.admin')

@section('title', 'Galeri Foto')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Galeri Foto</h1>
        <p class="mt-4 text-gray-600">Halaman galeri lama sudah dipindahkan ke Flux UI. Silakan gunakan menu <strong>Gallery</strong> atau <a href="{{ route('admin.gallery') }}" class="text-blue-600 underline">buka galeri baru</a>.</p>
    </div>
@endsection
