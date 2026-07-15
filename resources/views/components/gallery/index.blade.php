<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <flux:heading size="xl">
                Gallery
            </flux:heading>

            <flux:subheading class="mt-1">
                Manage your gallery
            </flux:subheading>
        </div>

        <flux:modal.trigger name="add-gallery">
            <flux:button
                variant="primary"
                icon="plus"
                wire:click="resetForm"
            >
                Add Gallery
            </flux:button>
        </flux:modal.trigger>

    </div>

    <flux:separator variant="subtle" />

    {{-- Flash Message --}}
    @if(session()->has('success'))
        <div class="rounded-lg bg-green-100 text-green-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="flex justify-between items-center">

        <div class="w-80">
            <input
                type="text"
                wire:model.live="search"
                placeholder="Search gallery..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2"
            />
        </div>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-3">ID</th>

                    <th class="text-left py-3">Image</th>

                    <th class="text-left py-3">Destination</th>

                    <th class="text-left py-3">Caption</th>

                    <th class="text-center py-3">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($images as $image)

                    <tr class="border-b hover:bg-zinc-50">

                        <td class="py-3">
                            {{ $images->firstItem() + $loop->index }}
                        </td>

                        <td class="py-3">

                            @if($image->image)

                                <img
                                    src="{{ asset('storage/'.$image->image) }}"
                                    class="w-16 h-16 rounded-lg object-cover border"
                                >

                            @else

                                <span class="text-zinc-400">
                                    No Image
                                </span>

                            @endif

                        </td>

                        <td class="py-3">
                            {{ $image->destination->name ?? '-' }}
                        </td>

                        <td class="py-3">
                            {{ $image->caption }}
                        </td>

                        <td class="py-3">

                            <div class="flex justify-center gap-2">

                                <flux:button
                                    size="sm"
                                    variant="ghost"
                                    icon="pencil"
                                    wire:click="edit({{ $image->id }})"
                                >
                                    Edit
                                </flux:button>

                                <flux:button
                                    size="sm"
                                    variant="danger"
                                    icon="trash"
                                    wire:click="delete({{ $image->id }})"
                                    wire:confirm="Yakin ingin menghapus gallery ini?"
                                >
                                    Delete
                                </flux:button>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-8 text-zinc-500">

                            Belum ada data gallery.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $images->links() }}
    </div>

    {{-- Modal --}}
    <flux:modal name="add-gallery" class="md:w-[550px]">

        <form
            wire:submit.prevent="{{ $gallery_id ? 'update' : 'save' }}"
            class="space-y-5"
        >

            <div>

                <flux:heading size="lg">

                    {{ $gallery_id ? 'Edit Gallery' : 'Add Gallery' }}

                </flux:heading>

                <flux:text class="mt-1">

                    {{ $gallery_id ? 'Perbarui gallery.' : 'Tambahkan gallery baru.' }}

                </flux:text>

            </div>

            <flux:select
                label="Destination"
                wire:model="destination_id"
                placeholder="Choose destination"
            >

                @foreach($destinations as $destination)

                    <flux:select.option value="{{ $destination->id }}">

                        {{ $destination->name }}

                    </flux:select.option>

                @endforeach

            </flux:select>

            @error('destination_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <flux:input
                label="Caption"
                wire:model="caption"
                placeholder="Caption Gallery"
            />

            @error('caption')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <div>

                <label class="text-sm font-medium">

                    Image

                </label>

                <input
                    type="file"
                    wire:model="image"
                    class="w-full border rounded-lg p-2 mt-2"
                >

                @error('image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                @if($this->image)

                    <img
                        src="{{ $this->image->temporaryUrl() }}"
                        class="w-32 h-32 object-cover rounded-lg mt-4 border"
                    >

                @endif

            </div>

            <div class="flex justify-end gap-3 pt-4">

                <flux:modal.close>

                    <flux:button variant="ghost">

                        Cancel

                    </flux:button>

                </flux:modal.close>

                <flux:button
                    type="submit"
                    variant="primary"
                >

                    {{ $gallery_id ? 'Update Gallery' : 'Save Gallery' }}

                </flux:button>

            </div>

        </form>

    </flux:modal>

</div>