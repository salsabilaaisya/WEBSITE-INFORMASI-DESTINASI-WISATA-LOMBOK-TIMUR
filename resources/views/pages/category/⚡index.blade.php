<?php

use App\Models\Category;
use Livewire\Component;

new class extends Component
{
    public string $name = '';
    public string $description = '';

    public ?int $editId = null;
    public string $editName = '';
    public string $editDescription = '';
 
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
        'editDescription'
    ]);

    session()->flash('success', 'Kategori berhasil diperbarui!');
}

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

    public function delete($id)
    {
        Category::findOrFail($id)->delete();

        session()->flash('success', 'Kategori berhasil dihapus!');
    }

    public function with(): array
    {
        return [
            'categories' => Category::latest()->get(),
        ];
    }
};

?>

<div>
@if(session('success'))
    <div class="mb-4 rounded bg-green-100 p-3 text-green-700">
        {{ session('success') }}
    </div>
@endif

<div class="mb-6 rounded border p-4">
    <h2 class="mb-4 text-lg font-semibold">
        Tambah Kategori
    </h2>

    <form wire:submit="save" class="space-y-3">
        <div>
            <label class="block mb-1">Nama Kategori</label>

            <input
                type="text"
                wire:model="name"
                class="w-full rounded border p-2"
            >

            @error('name')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Deskripsi</label>

            <textarea
                wire:model="description"
                class="w-full rounded border p-2"
            ></textarea>
        </div>

        <div>
        <flux:button variant="primary" color="teal">
            Simpan
        </button>
        </div>
    </form>
</div>
@if($editId)

<div class="mb-6 rounded border p-4 bg-yellow-50">
    <h2 class="mb-4 text-lg font-semibold">
        Edit Kategori
    </h2>

    <form wire:submit="update">

        <input
            type="text"
            wire:model="editName"
            class="w-full rounded border p-2 mb-3"
        >

        <textarea
            wire:model="editDescription"
            class="w-full rounded border p-2 mb-3"
        ></textarea>

        <button
            type="submit"
            class="rounded bg-green-600 px-4 py-2 text-white"
        >
            Update
        </button>

    </form>
</div>

@endif
<hr class="my-6">

<table class="w-full border">
    <thead>
        <tr>
            <th class="border p-2">ID</th>
            <th class="border p-2">Nama</th>
            <th class="border p-2">Deskripsi</th>
            <th class="border p-2">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $category)
            <tr>
                <td class="border p-2">{{ $category->id }}</td>
                <td class="border p-2">{{ $category->name }}</td>
                <td class="border p-2">{{ $category->description }}</td>

                <td class="border p-2">
                    <button
                        wire:click="edit({{ $category->id }})"
                        class="mr-2 rounded bg-yellow-500 px-3 py-1 text-white"
                    >
                        ✏️ Edit
</button>
                    <button
                        wire:click="delete({{ $category->id }})"
                        class="inline-flex items-center gap-2 rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700"
                    >
                        🗑️ Hapus
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>