<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Destination;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;

new class extends Component {
    use WithFileUploads;

    public $destination_id = null;
    public $name = '';
    public $category_id = '';
    public $location = '';
    public $description = '';
    public $cover_path;
    public $existing_cover = null;
    public $fileInputKey = 0;

    public function with(): array
    {
        return [
            'destinations' => Destination::with('category')->latest()->get(),
            'categories'   => Category::latest()->get(),
        ];
    }

    public function save()
    {
        $this->validate([
            'name'        => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_path'  => 'nullable|image|max:2048',
        ], [
            'name.required'        => 'Nama destinasi wajib diisi.',
            'name.min'             => 'Nama destinasi minimal 3 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'location.required'    => 'Lokasi wajib diisi.',
            'cover_path.image'     => 'File cover harus berupa gambar.',
            'cover_path.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        $cover = null;
        if ($this->cover_path) {
            $cover = $this->cover_path->store('destinations', 'public');
        }

        Destination::create([
            'name'        => $this->name,
            'category_id' => $this->category_id,
            'user_id'     => auth()->id(),
            'location'    => $this->location,
            'description' => $this->description,
            'cover_path'  => $cover,
        ]);

        $this->resetForm();
        Flux::modal('destination-form')->close();

        session()->flash('success', 'Destination berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);

        $this->destination_id = $destination->id;
        $this->name = $destination->name;
        $this->category_id = $destination->category_id;
        $this->location = $destination->location;
        $this->description = $destination->description;

        $this->resetValidation();

        Flux::modal('destination-form')->show();
    }

    public function update()
    {
        $this->validate([
            'name'        => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_path'  => 'nullable|image|max:2048',
        ]);

        $destination = Destination::findOrFail($this->destination_id);

        $data = [
            'name'        => $this->name,
            'category_id' => $this->category_id,
            'location'    => $this->location,
            'description' => $this->description,
        ];

        if ($this->cover_path) {
            if ($destination->cover_path && Storage::disk('public')->exists($destination->cover_path)) {
                Storage::disk('public')->delete($destination->cover_path);
            }

            $data['cover_path'] = $this->cover_path->store('destinations', 'public');
        }

        $destination->update($data);

        $this->resetForm();
        Flux::modal('destination-form')->close();

        session()->flash('success', 'Destination berhasil diperbarui.');
    }

    public function delete($id)
    {
        $destination = Destination::findOrFail($id);

        if ($destination->cover_path && Storage::disk('public')->exists($destination->cover_path)) {
            Storage::disk('public')->delete($destination->cover_path);
        }

        $destination->delete();

        session()->flash('success', 'Destination berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset([
            'destination_id',
            'name',
            'category_id',
            'location',
            'description',
            'cover_path',
            'existing_cover',
        ]);

        $this->fileInputKey++;
        $this->resetValidation();
    }
};
?>

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
            <flux:button
                variant="primary"
                icon="plus"
                wire:click="resetForm"
                class="rounded-xl px-5 py-3"
            >
                Add Destination
            </flux:button>
        </flux:modal.trigger>
    </div>

    <flux:separator variant="subtle" />

    {{-- Flash message --}}
    @if (session()->has('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-950/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- GRID DESTINATION --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
    @forelse ($destinations as $destination)
        <div class="group w-full max-w-[320px] justify-self-center overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">

            {{-- Cover --}}
            <div class="relative h-44 w-full overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                @if ($destination->cover_path)
                    <img
                        src="{{ asset('storage/' . $destination->cover_path) }}"
                        alt="{{ $destination->name }}"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    >
                @else
                    <div class="flex h-full items-center justify-center text-sm text-zinc-400">
                        No image
                    </div>
                @endif

                {{-- Badge category --}}
                <div class="absolute left-3 top-3">
                    <span class="rounded-full bg-orange-500 px-3 py-1 text-xs font-semibold text-white shadow">
                        {{ $destination->category->name ?? 'No Category' }}
                    </span>
                </div>
            </div>

            {{-- Content --}}
            <div class="space-y-3 p-4">
                <div>
                    <h3 class="line-clamp-1 text-xl font-bold text-zinc-900 dark:text-white">
                        {{ $destination->name }}
                    </h3>

                    <div class="mt-2 flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                        <flux:icon.map-pin class="h-4 w-4" />
                        <span class="line-clamp-1">{{ $destination->location }}</span>
                    </div>
                </div>

                <p class="line-clamp-3 min-h-[72px] text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                    {{ $destination->description ?: 'Belum ada deskripsi untuk destinasi ini.' }}
                </p>

                <div class="flex items-center justify-between text-sm text-zinc-500">
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                        Active
                    </span>

                    <span>ID: {{ $destination->id }}</span>
                </div>

                <div class="grid grid-cols-2 gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                    <flux:button
                        variant="ghost"
                        icon="pencil"
                        wire:click="edit({{ $destination->id }})"
                        class="w-full"
                    >
                        Edit
                    </flux:button>

                    <flux:button
                        variant="danger"
                        icon="trash"
                        wire:click="delete({{ $destination->id }})"
                        wire:confirm="Yakin ingin menghapus destination ini?"
                        class="w-full"
                    >
                        Delete
                    </flux:button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full rounded-2xl border border-dashed border-zinc-300 bg-white p-10 text-center text-zinc-500 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400">
            Belum ada data destination.
        </div>
    @endforelse
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
                    <flux:input
                        label="Destination Name"
                        wire:model="name"
                        placeholder="Masukkan nama destination"
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <flux:select
                        label="Category"
                        wire:model="category_id"
                        placeholder="Choose category"
                    >
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
                    <flux:input
                        label="Location"
                        wire:model="location"
                        placeholder="Masukkan lokasi"
                    />
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <flux:textarea
                        label="Description"
                        wire:model="description"
                        placeholder="Masukkan deskripsi destination"
                    />
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cover --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Cover Image
                    </label>

                    <input
                        type="file"
                        wire:key="cover-input-{{ $fileInputKey }}"
                        wire:model="cover_path"
                        accept="image/*"
                        class="block w-full rounded-xl border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                    >

                    <div wire:loading wire:target="cover_path" class="text-sm text-blue-500">
                        Uploading image...
                    </div>

                    @error('cover_path')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    @if ($cover_path)
                        <div class="mt-2">
                            <p class="mb-2 text-sm text-zinc-500">Preview image baru:</p>
                            <img
                                src="{{ $cover_path->temporaryUrl() }}"
                                class="h-28 w-28 rounded-xl border border-zinc-200 object-cover dark:border-zinc-700"
                            >
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