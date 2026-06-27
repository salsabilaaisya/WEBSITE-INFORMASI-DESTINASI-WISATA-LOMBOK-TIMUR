<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">
        Gallery
    </flux:heading>

    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">
        Manage your gallery
    </flux:subheading>

    <flux:separator variant="subtle" />

    {{-- Button Add Gallery --}}
    <div class="flex justify-end">
        <flux:modal.trigger name="add-gallery">
            <flux:button variant="primary" color="primary" icon="plus">
                Add Gallery
            </flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Modal Add Gallery --}}
    <flux:modal name="add-gallery" class="md:w-[550px]">
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Add Gallery
                </flux:heading>
                <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                    Tambahkan data gallery baru.
                </flux:text>
            </div>

            {{-- Destination --}}
            <flux:select
                label="Destination"
                wire:model="destination_id"
                placeholder="Choose destination..."
            >
                @foreach ($destinations as $destination)
                    <flux:select.option value="{{ $destination->id }}">
                        {{ $destination->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            @error('destination_id')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            {{-- Caption --}}
            <flux:textarea
                label="Caption"
                placeholder="Masukkan caption gallery"
                wire:model="caption"
            />
            @error('caption')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            {{-- Image --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Image
                </label>

                <input
                    type="file"
                    wire:model="image"
                    class="block w-full rounded-lg border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white px-3 py-2 text-sm"
                >

                @error('image')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                @if ($image)
                    <div class="mt-3">
                        <img
                            src="{{ $image->temporaryUrl() }}"
                            class="w-32 h-32 rounded-lg object-cover border border-zinc-200 dark:border-zinc-700"
                        >
                    </div>
                @endif
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" color="rose">
                    Save Gallery
                </flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Table Gallery --}}
    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Destination</flux:table.column>
            <flux:table.column>Image</flux:table.column>
            <flux:table.column>Caption</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($images as $image)
                <flux:table.row :key="$image->id">
                    <flux:table.cell>{{ $image->id }}</flux:table.cell>

                    <flux:table.cell>
                        {{ $image->destination->name ?? '-' }}
                    </flux:table.cell>

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
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />

                            <flux:menu>
                                <flux:menu.item
                                    icon="pencil"
                                    wire:click="edit({{ $image->id }})"
                                >
                                    Edit
                                </flux:menu.item>

                                <flux:menu.separator />

                                <flux:menu.item
                                    variant="danger"
                                    icon="trash"
                                    wire:click="delete({{ $image->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menghapus gallery ini?"
                                >
                                    Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center text-zinc-500 py-6">
                        Belum ada data gallery
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>