@php
    $totalDestinations = \App\Models\Destination::count();
    $totalArticles = \App\Models\Article::count();
    $totalCategories = \App\Models\Category::count();
    $totalGalleries = \App\Models\Gallery::count();

    $totalMessages = \App\Models\ContactMessage::count();
    $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
    $recentMessages = \App\Models\ContactMessage::latest()->take(5)->get();

    $recentDestinations = \App\Models\Destination::with('category')->latest()->take(5)->get();
    $recentArticles = \App\Models\Article::latest()->take(5)->get();

    $stats = [
        [
            'label' => 'Destinasi Wisata',
            'value' => $totalDestinations,
            'desc' => 'Total destinasi terdaftar',
            'icon' => 'map-pin',
            'gradient' => 'from-orange-400 to-rose-500',
            'bg' => 'bg-orange-50 dark:bg-orange-950/30',
            'text' => 'text-orange-600 dark:text-orange-400',
        ],
        [
            'label' => 'Artikel & Berita',
            'value' => $totalArticles,
            'desc' => 'Total artikel diterbitkan',
            'icon' => 'newspaper',
            'gradient' => 'from-sky-400 to-blue-600',
            'bg' => 'bg-sky-50 dark:bg-sky-950/30',
            'text' => 'text-sky-600 dark:text-sky-400',
        ],
        [
            'label' => 'Kategori',
            'value' => $totalCategories,
            'desc' => 'Kategori destinasi & artikel',
            'icon' => 'tag',
            'gradient' => 'from-violet-400 to-purple-600',
            'bg' => 'bg-violet-50 dark:bg-violet-950/30',
            'text' => 'text-violet-600 dark:text-violet-400',
        ],
        [
            'label' => 'Galeri Foto',
            'value' => $totalGalleries,
            'desc' => 'Total foto dalam galeri',
            'icon' => 'photo',
            'gradient' => 'from-emerald-400 to-teal-600',
            'bg' => 'bg-emerald-50 dark:bg-emerald-950/30',
            'text' => 'text-emerald-600 dark:text-emerald-400',
        ],
        [
            'label' => 'Pesan Masuk',
            'value' => $totalMessages,
            'desc' => 'Total pesan masuk',
            'icon' => 'envelope',
            'gradient' => 'from-amber-400 to-orange-600',
            'bg' => 'bg-amber-50 dark:bg-amber-950/30',
            'text' => 'text-amber-600 dark:text-amber-400',
        ],
    ];
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">

        {{-- ── TOP GRID: Hero + Stat Cards ────────────────────────── --}}
        <div class="grid gap-4 lg:grid-cols-5 lg:items-stretch">

            {{-- Hero Banner — spans 2 cols on desktop --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-accent px-6 py-8 text-white shadow-lg lg:col-span-2">
                {{-- decorative circles --}}
                <div class="pointer-events-none absolute -right-10 -top-10 size-48 rounded-full bg-white/10 blur-2xl">
                </div>
                <div class="pointer-events-none absolute -bottom-8 -left-8 size-40 rounded-full bg-white/10 blur-2xl">
                </div>

                <div class="relative flex h-full flex-col justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Selamat datang kembali 👋</p>
                        <h1 class="mt-1 text-2xl font-bold tracking-tight text-zinc-500 dark:text-zinc-400">
                            {{ auth()->user()->name }}</h1>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ now()->translatedFormat('l, d F Y') }}<br class="hidden sm:inline">
                            <span class="hidden sm:inline">&mdash; </span>Website Informasi Destinasi Wisata Lombok
                            Timur
                        </p>
                    </div>
                    <div>
                        <flux:badge color="lime" class="font-semibold">● Sistem Aktif</flux:badge>
                    </div>
                </div>
            </div>

            {{-- Stat Cards — 2x2 grid, spans 3 cols on desktop --}}
            <div class="grid grid-cols-2 gap-3 lg:col-span-3">
                @foreach ($stats as $stat)
                    <flux:card class="group relative overflow-hidden p-3 transition-shadow duration-300 hover:shadow-md">
                        {{-- gradient accent bar --}}
                        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r {{ $stat['gradient'] }} rounded-t-xl">
                        </div>

                        <div class="flex items-center gap-3 pt-1">
                            {{-- icon --}}
                            <div class="flex size-9 shrink-0 items-center justify-center rounded-lg {{ $stat['bg'] }}">
                                <flux:icon :icon="$stat['icon']" class="size-4 {{ $stat['text'] }}" />
                            </div>

                            {{-- text --}}
                            <div class="min-w-0">
                                <p
                                    class="truncate text-[10px] font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                    {{ $stat['label'] }}
                                </p>
                                <p class="text-xl font-bold tabular-nums leading-tight">
                                    {{ $stat['value'] }}
                                </p>
                            </div>
                        </div>
                    </flux:card>
                @endforeach
            </div>

        </div>

        {{-- ── BOTTOM SECTION ───────────────────────────────────────── --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Recent Destinations – 3 cols --}}
            <div class="lg:col-span-2">
                <flux:card class="h-full">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <flux:heading size="lg">Destinasi Terbaru</flux:heading>
                            <flux:subheading class="text-xs">5 destinasi yang baru ditambahkan</flux:subheading>
                        </div>
                        <flux:button variant="ghost" size="sm" icon="arrow-right" :href="route('admin.destinations')"
                        >
                            Lihat semua
                        </flux:button>
                    </div>

                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Destinasi</flux:table.column>
                            <flux:table.column>Lokasi</flux:table.column>
                            <flux:table.column>Kategori</flux:table.column>
                            <flux:table.column>Status</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @forelse ($recentDestinations as $destination)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <div class="flex items-center gap-3">
                                            @if ($destination->cover_path)
                                                <img src="{{ asset('storage/'.$destination->cover_path) }}"
                                                    alt="{{ $destination->name }}"
                                                    class="size-9 rounded-lg object-cover shrink-0">
                                            @else
                                                <div
                                                    class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-orange-400 to-rose-500">
                                                    <flux:icon.map-pin class="size-4 text-white" />
                                                </div>
                                            @endif
                                            <span class="font-medium">{{ Str::limit($destination->name, 22) }}</span>
                                        </div>
                                    </flux:table.cell>
                                    <flux:table.cell class="text-zinc-500 text-sm">
                                        {{ Str::limit($destination->location ?? '-', 20) }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($destination->category)
                                            <flux:badge size="sm" color="zinc">{{ $destination->category->name }}</flux:badge>
                                        @else
                                            <span class="text-zinc-400 text-xs">—</span>
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if (($destination->status ?? 'aktif') === 'aktif')
                                            <flux:badge size="sm" color="green" inset="top bottom">Aktif</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="zinc" inset="top bottom">Non-aktif</flux:badge>
                                        @endif
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="4">
                                        <div class="py-6 text-center text-sm text-zinc-400">
                                            Belum ada destinasi yang ditambahkan.
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </flux:card>
            </div>

            {{-- Recent Articles – 2 cols --}}
            <div class="lg:col-span-1">
                <flux:card class="h-full">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <flux:heading size="lg">Artikel Terbaru</flux:heading>
                            <flux:subheading class="text-xs">5 artikel terbaru</flux:subheading>
                        </div>
                        <flux:button variant="ghost" size="sm" icon="arrow-right" :href="route('admin.articles')"
                            wire:navigate>
                            Lihat semua
                        </flux:button>
                    </div>

                    {{-- Recent Contact Messages --}}
                    <div class="lg:col-span-1">
                        <flux:card>

                            <div class="mb-4 flex items-center justify-between">

                                <div>
                                    <flux:heading size="lg">
                                        Contact Messages
                                    </flux:heading>

                                    <flux:subheading class="text-xs">
                                        5 pesan terbaru
                                    </flux:subheading>
                                </div>

                                <flux:button
                                    variant="ghost"
                                    size="sm"
                                    icon="arrow-right"
                                    :href="route('admin.messages')">

                                    Lihat semua

                                </flux:button>

                            </div>

                            <div class="space-y-3">

                                @forelse($recentMessages as $message)

                                    <div class="flex items-start justify-between border-b pb-3">

                                        <div>

                                            <p class="font-medium">
                                                {{ $message->name }}
                                            </p>

                                            <p class="text-sm text-zinc-500">
                                                {{ Str::limit($message->message,40) }}
                                            </p>

                                            <p class="text-xs text-zinc-400 mt-1">
                                                {{ $message->created_at->diffForHumans() }}
                                            </p>

                                        </div>

                                        @if($message->is_read)

                                            <flux:badge color="green">
                                                Dibaca
                                            </flux:badge>

                                        @else

                                            <flux:badge color="red">
                                                Belum Dibaca
                                            </flux:badge>

                                        @endif

                                    </div>

                                @empty

                                    <p class="text-center text-sm text-zinc-400 py-6">
                                        Belum ada pesan.
                                    </p>

                                @endforelse

                            </div>

                        </flux:card>
                    </div>

                    <div class="flex flex-col divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($recentArticles as $article)
                            <div class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                                {{-- colored dot --}}
                                <div class="mt-1.5 size-2 shrink-0 rounded-full bg-gradient-to-br from-sky-400 to-blue-600">
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium leading-snug">
                                        {{ Str::limit($article->title, 45) }}
                                    </p>
                                    <p class="mt-0.5 text-xs text-zinc-400">
                                        {{ $article->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-sm text-zinc-400">
                                Belum ada artikel yang diterbitkan.
                            </div>
                        @endforelse
                    </div>
                </flux:card>
            </div>

        </div>
    </div>
</x-layouts::app>