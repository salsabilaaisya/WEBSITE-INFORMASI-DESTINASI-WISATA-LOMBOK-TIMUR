<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                Destination
            </flux:heading>

            <flux:subheading class="mt-1 text-zinc-500 dark:text-zinc-400">
                Discover and manage all destination content in one place.
            </flux:subheading>
        </div>

        <flux:modal.trigger name="destination-form">
            <flux:button variant="primary" icon="plus" wire:click="resetForm" class="rounded-xl px-5 py-3">
                Add Destination
            </flux:button>
        </flux:modal.trigger>
    </div>

    <flux:separator variant="subtle" />

    {{-- Flash message --}}
    @if (session()->has('success'))
        <div
            class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-950/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

<div class="space-y-5">

    <div class="w-full max-w-sm">
        <flux:input
            icon="magnifying-glass"
            wire:model.live.debounce.300ms="search"
            placeholder="Search destination..."
        />
    </div>

            <flux:table>

            <flux:table.columns>

                <flux:table.column>No</flux:table.column>

                <flux:table.column>Cover</flux:table.column>

                <flux:table.column>Destination</flux:table.column>

                <flux:table.column>Category</flux:table.column>

                <flux:table.column>Location</flux:table.column>

                <flux:table.column class="text-center">
                    Action
                </flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @forelse($destinations as $destination)

                <flux:table.row>

                    <flux:table.cell>

                        {{ $loop->iteration + ($destinations->currentPage()-1) * $destinations->perPage() }}

                    </flux:table.cell>

                    <flux:table.cell>

                        @if($destination->cover_path)

                            <img
                                src="{{ asset('storage/'.$destination->cover_path) }}"
                                class="h-14 w-20 rounded-lg object-cover"
                            >

                        @else

                            -

                        @endif

                    </flux:table.cell>

                    <flux:table.cell>

                        <div>

                            <div class="font-semibold">

                                {{ $destination->name }}

                            </div>

                            <div class="text-sm text-zinc-500">

                                ID : {{ $destination->id }}

                            </div>

                        </div>

                    </flux:table.cell>

                    <flux:table.cell>

                        <flux:badge color="orange">

                            {{ $destination->category->name ?? '-' }}

                        </flux:badge>

                    </flux:table.cell>

                    <flux:table.cell>

                        {{ $destination->location }}

                    </flux:table.cell>

                    <flux:table.cell>

                        <div class="flex justify-center gap-2">

                            <flux:button
                                size="sm"
                                variant="ghost"
                                icon="pencil"
                                wire:click="edit({{ $destination->id }})"
                            />

                            <flux:button
                                size="sm"
                                variant="danger"
                                icon="trash"
                                wire:click="delete({{ $destination->id }})"
                                wire:confirm="Yakin ingin menghapus destination ini?"
                            />

                        </div>

                    </flux:table.cell>

                </flux:table.row>

                @empty

                <flux:table.row>

                    <flux:table.cell colspan="6">

                        Belum ada data destination.

                    </flux:table.cell>

                </flux:table.row>

                @endforelse

            </flux:table.rows>

        </flux:table>

        <div class="mt-6">

        {{ $destinations->links() }}

    </div>

    {{-- MODAL FORM --}}
    <flux:modal name="destination-form" class="md:w-[650px]">
        <form wire:submit.prevent="{{ $destination_id ? 'update' : 'save' }}" class="space-y-5">
            <div>
                <flux:heading size="lg">
                    {{ $destination_id ? 'Edit Destination' : 'Add Destination' }}
                </flux:heading>

                <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                    {{ $destination_id ? 'Perbarui data destination.' : 'Tambahkan data destination baru.' }}
                </flux:text>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                {{-- Name --}}
                <div class="md:col-span-2">
                    <flux:input label="Destination Name" wire:model="name" placeholder="Masukkan nama destination" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <flux:select label="Category" wire:model="category_id" placeholder="Choose category">
                        @foreach ($categories as $category)
                            <flux:select.option value="{{ $category->id }}">
                                {{ $category->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <flux:input label="Location" wire:model="location" placeholder="Masukkan lokasi" />
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <flux:textarea label="Description" wire:model="description"
                        placeholder="Masukkan deskripsi destination" />
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cover --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Cover Image
                    </label>

                    <input type="file" wire:key="cover-input-{{ $fileInputKey }}" wire:model="cover_path"
                        accept="image/*"
                        class="block w-full rounded-xl border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-white">

                    <div wire:loading wire:target="cover_path" class="text-sm text-blue-500">
                        Uploading image...
                    </div>

                    @error('cover_path')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    @if ($cover_path)
                        <div class="mt-2">
                            <p class="mb-2 text-sm text-zinc-500">Preview image baru:</p>
                            <img src="{{ $cover_path->temporaryUrl() }}"
                                class="h-28 w-28 rounded-xl border border-zinc-200 object-cover dark:border-zinc-700">
                        </div>
                    @endif
                </div>
            </div> {{-- penutup grid modal --}}

            <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">
                    {{ $destination_id ? 'Update Destination' : 'Save Destination' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>