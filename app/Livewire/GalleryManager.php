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
    public string $caption = '';
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
            'caption'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category'    => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'photo'       => $photoRule,
        ];
    }

    protected $messages = [
        'caption.required'  => 'Judul foto wajib diisi.',
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
        $this->caption     = $gallery->caption;
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
            'caption'       => $this->caption,
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
        $this->caption       = '';
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
                $q->where('caption', 'like', '%' . $this->search . '%')
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
