<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Form Create
    public $name = '';
    public $description = '';

    // Form Edit
    public $editId = null;
    public $editName = '';
    public $editDescription = '';

    // Search
    public $search = '';

    /**
     * Reset halaman ketika search berubah
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Simpan kategori baru
     */
    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset([
            'name',
            'description',
        ]);

        session()->flash('success', 'Category successfully added.');
    }

    /**
     * Ambil data untuk edit
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->editId = $category->id;
        $this->editName = $category->name;
        $this->editDescription = $category->description;

        $this->resetValidation();

        Flux::modal('add-category')->show();
    }

    /**
     * Update data
     */
    public function update()
    {
        $this->validate([
            'editName' => 'required|string|min:3|max:255',
            'editDescription' => 'nullable|string',
        ]);

        Category::findOrFail($this->editId)->update([
            'name' => $this->editName,
            'description' => $this->editDescription,
        ]);

        $this->cancelEdit();

        Flux::modal('add-category')->close();

        session()->flash('success', 'Category successfully updated.');
    }

    /**
     * Batal edit
     */
    public function cancelEdit()
    {
        $this->reset([
            'editId',
            'editName',
            'editDescription',
        ]);
    }

    /**
     * Hapus kategori
     */
    public function delete($id)
    {
        Category::findOrFail($id)->delete();

        session()->flash('success', 'Category successfully deleted.');

        $this->resetPage();
    }

    /**
     * Render
     */
    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('pages.category.index', [
            'categories' => $categories,
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'editId',
            'editName',
            'editDescription',
        ]);

        $this->resetValidation();
    }
}