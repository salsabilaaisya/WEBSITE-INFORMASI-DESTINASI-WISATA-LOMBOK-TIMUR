@php
    $totalDestinations = \App\Models\Destination::count();
    $totalArticles = \App\Models\Article::count();
    $totalCategories = \App\Models\Category::count();
    $totalGalleries = \App\Models\Gallery::count();

    $recentDestinations = \App\Models\Destination::latest()->take(5)->get();
    $recentArticles = \App\Models\Article::latest()->take(5)->get();
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <flux:heading size="xl" level="1">Overview</flux:heading>
        
        <!-- Stats Row -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:subheading>Destinasi Wisata</flux:subheading>
                    <flux:icon.map-pin class="size-5 text-zinc-400" />
                </div>
                <flux:heading size="xl">{{ $totalDestinations }}</flux:heading>
                <flux:text class="text-xs text-zinc-500">Total destinasi terdaftar</flux:text>
            </flux:card>

            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:subheading>Artikel & Berita</flux:subheading>
                    <flux:icon.newspaper class="size-5 text-zinc-400" />
                </div>
                <flux:heading size="xl">{{ $totalArticles }}</flux:heading>
                <flux:text class="text-xs text-zinc-500">Total artikel diterbitkan</flux:text>
            </flux:card>

            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:subheading>Kategori</flux:subheading>
                    <flux:icon.tag class="size-5 text-zinc-400" />
                </div>
                <flux:heading size="xl">{{ $totalCategories }}</flux:heading>
                <flux:text class="text-xs text-zinc-500">Kategori destinasi & artikel</flux:text>
            </flux:card>

            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:subheading>Galeri Foto</flux:subheading>
                    <flux:icon.photo class="size-5 text-zinc-400" />
                </div>
                <flux:heading size="xl">{{ $totalGalleries }}</flux:heading>
                <flux:text class="text-xs text-zinc-500">Total foto dalam galeri</flux:text>
            </flux:card>
        </div>

        <!-- Recent Data Row -->
        <div class="grid gap-6 md:grid-cols-2 mt-2">
            <!-- Recent Destinations -->
            <flux:card>
                <flux:heading size="lg" class="mb-4">Destinasi Terbaru</flux:heading>
                
                <div class="overflow-x-auto">
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Nama</flux:table.column>
                            <flux:table.column>Lokasi</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @forelse($recentDestinations as $destination)
                                <flux:table.row>
                                    <flux:table.cell class="font-medium">{{ $destination->name }}</flux:table.cell>
                                    <flux:table.cell class="text-zinc-500">{{ Str::limit($destination->location, 30) }}</flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="2" class="text-center text-zinc-500">Belum ada data destinasi</flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </div>
            </flux:card>

            <!-- Recent Articles -->
            <flux:card>
                <flux:heading size="lg" class="mb-4">Artikel Terbaru</flux:heading>
                
                <div class="overflow-x-auto">
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Judul</flux:table.column>
                            <flux:table.column>Tanggal</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @forelse($recentArticles as $article)
                                <flux:table.row>
                                    <flux:table.cell class="font-medium">{{ Str::limit($article->title, 40) }}</flux:table.cell>
                                    <flux:table.cell class="text-zinc-500">{{ $article->created_at->format('d M Y') }}</flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="2" class="text-center text-zinc-500">Belum ada data artikel</flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </div>
            </flux:card>
        </div>
    </div>
</x-layouts::app>