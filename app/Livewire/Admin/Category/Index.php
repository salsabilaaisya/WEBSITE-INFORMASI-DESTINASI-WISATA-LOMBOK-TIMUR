<?php

namespace App\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;

class Index extends Component
{
    public string $name = '';
    public string $description = '';

    public ?int $editId = null;
    public string $editName = '';
    public string $editDescription = '';

    public function save()
    {
        $this->validate([
            'name' => ['required', 'min:3'],
            'description' => ['nullable'],
        ]);

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset(['name', 'description']);

        session()->flash('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->editId = $category->id;
        $this->editName = $category->name;
        $this->editDescription = $category->description;
    }

    public function update()
    {
        $this->validate([
            'editName' => ['required', 'min:3'],
        ]);

        Category::findOrFail($this->editId)->update([
            'name' => $this->editName,
            'description' => $this->editDescription,
        ]);

        $this->reset([
            'editId',
            'editName',
            'editDescription',
        ]);

        session()->flash('success', 'Kategori berhasil diperbarui!');
    }

    public function cancelEdit()
    {
        $this->reset([
            'editId',
            'editName',
            'editDescription',
        ]);
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();

        session()->flash('success', 'Kategori berhasil dihapus!');
    }

    public function render()
    {
        return view('pages.category.index', [
            'categories' => Category::latest()->get(),
        ]);
    }
}