<?php

use Livewire\Volt\Component;
use App\Models\Gallery;

new class extends Component
{
    public function with(): array
    {
        return [
            'images' => Gallery::with('destination')->latest()->get(),
        ];
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4 p-6">
    <flux:heading size="xl" class="text-pink-800 dark:text-white">
        Gallery
    </flux:heading>

    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">
        Manage your gallery
    </flux:subheading>

    <flux:separator variant="subtle" />

    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Image</flux:table.column>
            <flux:table.column>Caption</flux:table.column>
            <flux:table.column>Destination</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($images as $image)
                <flux:table.row :key="$image->id">
                    <flux:table.cell>{{ $image->id }}</flux:table.cell>

                    <flux:table.cell>
                        @if ($image->image)
                            <img
                                src="{{ asset('storage/' . $image->image) }}"
                                alt="{{ $image->caption }}"
                                class="w-16 h-16 rounded-lg object-cover"
                            >
                        @else
                            <span class="text-zinc-400">No image</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $image->caption ?? '-' }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $image->destination->name ?? '-' }}
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center py-6 text-zinc-500">
                        Belum ada data gallery
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>