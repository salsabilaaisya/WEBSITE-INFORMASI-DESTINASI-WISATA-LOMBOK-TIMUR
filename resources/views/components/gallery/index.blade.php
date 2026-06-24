<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class GalleryManager extends Component
{
    use WithFileUploads, WithPagination;

    // Form fields
    public string $title = '';
    public string $description = '';
    public string $category = '';
    public bool $is_featured = false;
    public $photo; // uploaded file

    // UI state
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $showLightbox = false;
    public ?int $editingId = null;
    public ?int $deletingId = null;
    public ?int $lightboxId = null;

    // Filter & search
    public string $search = '';
    public string $filterCategory = '';
    public string $viewMode = 'grid'; // grid | list

    protected function rules(): array
    {
        $photoRule = $this->editingId
            ? 'nullable|image|max:2048'
            : 'required|image|max:2048';

        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category'    => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'photo'       => $photoRule,
        ];
    }

    protected $messages = [
        'title.required'  => 'Judul foto wajib diisi.',
        'photo.required'  => 'Foto wajib diunggah.',
        'photo.image'     => 'File harus berupa gambar.',
        'photo.max'       => 'Ukuran foto maksimal 2MB.',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $gallery = Gallery::findOrFail($id);
        $this->editingId = $id;
        $this->title       = $gallery->title;
        $this->description = $gallery->description ?? '';
        $this->category    = $gallery->category ?? '';
        $this->is_featured = $gallery->is_featured;
        $this->photo       = null;
        $this->showModal   = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title'       => $this->title,
            'description' => $this->description,
            'category'    => $this->category,
            'is_featured' => $this->is_featured,
        ];

        if ($this->photo) {
            // Hapus foto lama jika edit
            if ($this->editingId) {
                $old = Gallery::find($this->editingId);
                if ($old && Storage::disk('public')->exists($old->image_path)) {
                    Storage::disk('public')->delete($old->image_path);
                }
            }
            $data['image_path'] = $this->photo->store('gallery', 'public');
        }

        if ($this->editingId) {
            Gallery::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Foto berhasil diperbarui!');
        } else {
            Gallery::create($data);
            session()->flash('success', 'Foto berhasil ditambahkan!');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId     = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deletingId) {
            $gallery = Gallery::findOrFail($this->deletingId);
            if (Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $gallery->delete();
            session()->flash('success', 'Foto berhasil dihapus!');
        }
        $this->showDeleteModal = false;
        $this->deletingId      = null;
    }

    public function openLightbox(int $id): void
    {
        $this->lightboxId   = $id;
        $this->showLightbox = true;
    }

    public function toggleFeatured(int $id): void
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->update(['is_featured' => !$gallery->is_featured]);
    }

    public function getCategories(): array
    {
        return Gallery::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();
    }

    private function resetForm(): void
    {
        $this->title       = '';
        $this->description = '';
        $this->category    = '';
        $this->is_featured = false;
        $this->photo       = null;
        $this->resetValidation();
    }

    public function render()
    {
        $query = Gallery::query()
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
            )
            ->when($this->filterCategory, fn($q) =>
                $q->where('category', $this->filterCategory)
            )
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc');

        $galleries   = $query->paginate(12);
        $lightboxItem = $this->lightboxId ? Gallery::find($this->lightboxId) : null;
        $categories  = $this->getCategories();
        $totalCount  = Gallery::count();
        $featuredCount = Gallery::where('is_featured', true)->count();

        return view('livewire.gallery-manager', compact(
            'galleries', 'lightboxItem', 'categories', 'totalCount', 'featuredCount'
        ));
    }
}


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