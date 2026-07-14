<?php

namespace App\Livewire\Admin\Destination;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Destination;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    public $destination_id = null;
    public $name = '';
    public $category_id = '';
    public $location = '';
    public $description = '';
    public $cover_path;
    public $existing_cover = null;
    public $fileInputKey = 0;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $destinations = Destination::with('category')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('location', 'like', "%{$this->search}%")
                    ->orWhereHas('category', function ($category) {
                        $category->where('name', 'like', "%{$this->search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10);

        return view('pages.destination.index', [
            'destinations' => $destinations,
            'categories'   => Category::orderBy('name')->get(),
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_path' => 'nullable|image|max:10240',
        ], [
            'name.required' => 'Nama destinasi wajib diisi.',
            'name.min' => 'Nama destinasi minimal 3 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'location.required' => 'Lokasi wajib diisi.',
            'cover_path.image' => 'File cover harus berupa gambar.',
            'cover_path.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $cover = null;

        if ($this->cover_path) {
            $cover = $this->cover_path->store('destinations', 'public');
        }

        Destination::create([
            'name' => $this->name,
            'category_id' => $this->category_id,
            'user_id' => auth()->id(),
            'location' => $this->location,
            'description' => $this->description,
            'cover_path' => $cover,
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
        $this->existing_cover = $destination->cover_path;

        $this->resetValidation();

        Flux::modal('destination-form')->show();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_path' => 'nullable|image|max:10240',
        ]);

        $destination = Destination::findOrFail($this->destination_id);

        $data = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'location' => $this->location,
            'description' => $this->description,
        ];

        if ($this->cover_path) {

            if (
                $destination->cover_path &&
                Storage::disk('public')->exists($destination->cover_path)
            ) {
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

        if (
            $destination->cover_path &&
            Storage::disk('public')->exists($destination->cover_path)
        ) {
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
}