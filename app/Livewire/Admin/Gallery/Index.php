<?php

namespace App\Livewire\Admin\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Gallery;
use App\Models\Destination;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads, WithPagination;

    public $gallery_id = null;
    public $destination_id = '';
    public $title = '';
    public $description = '';
    public $image;

    public $search = '';

    public function render()
    {
        return view('pages.gallery.index', [
            'images' => Gallery::with('destination')
                ->whereHas('destination', function ($query) {
                    $query->where('name', 'like', "%{$this->search}%");
                })
                ->orWhere('title', 'like', "%{$this->search}%")
                ->latest()
                ->paginate(10),

            'destinations' => Destination::orderBy('name')->get(),
        ]);
    }

    public function save()
    {
        $this->validate([
            'destination_id' => 'required|exists:destinations,id',
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ], [
            'destination_id.required' => 'Destinasi wajib dipilih.',
            'title.required' => 'Judul wajib diisi.',
            'image.required' => 'Gambar wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $imagePath = $this->image->store('gallery', 'public');

        Gallery::create([
            'destination_id' => $this->destination_id,
            'title' => $this->title,
            'image' => $imagePath,
        ]);

        $this->resetForm();

        Flux::modal('add-gallery')->close();

        session()->flash('success', 'Gallery berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        $this->gallery_id = $gallery->id;
        $this->destination_id = $gallery->destination_id;
        $this->title = $gallery->title;

        $this->resetValidation();

        Flux::modal('add-gallery')->show();
    }

    public function update()
    {
        $this->validate([
            'destination_id' => 'required|exists:destinations,id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $gallery = Gallery::findOrFail($this->gallery_id);

        $data = [
            'destination_id' => $this->destination_id,
            'title' => $this->title,
        ];

        if ($this->image) {

            if (
                $gallery->image &&
                Storage::disk('public')->exists($gallery->image)
            ) {
                Storage::disk('public')->delete($gallery->image);
            }

            $data['image'] = $this->image->store('gallery', 'public');
        }

        $gallery->update($data);

        $this->resetForm();

        Flux::modal('add-gallery')->close();

        session()->flash('success', 'Gallery berhasil diperbarui.');
    }

    public function delete($id)
    {
        $gallery = Gallery::findOrFail($id);

        if (
            $gallery->image &&
            Storage::disk('public')->exists($gallery->image)
        ) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        session()->flash('success', 'Gallery berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset([
            'gallery_id',
            'destination_id',
            'title',
            'image',
        ]);

        $this->resetValidation();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}