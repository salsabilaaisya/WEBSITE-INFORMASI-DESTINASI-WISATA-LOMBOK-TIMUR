<?php

use Livewire\Component;
use App\Models\Category;
use App\Models\User;
use Livewire\Attributes\Computed;
use App\Livewire\Forms\DestinationForm;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public DestinationForm $form;

    #[Computed]
    public function categories()
    {
        return Category::all();
    }

    #[Computed]
    public function users()
    {
        return User::all();
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-destination')->close();

        session()->flash('success', 'Destination created successfully');

        $this->redirectRoute('destinations.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal 
        name="create-destination" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Tambah Destinasi
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Masukkan data destinasi baru
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Nama Destinasi"
                    placeholder="Masukkan nama destinasi"
                    wire:model="form.name"
                />

                <flux:textarea
                    label="Deskripsi"
                    placeholder="Tuliskan deskripsi destinasi..."
                    wire:model="form.description"
                    rows="6"
                />

                <flux:input
                    label="Lokasi"
                    placeholder="Masukkan lokasi destinasi"
                    wire:model="form.location"
                />

                <flux:select label="Kategori" wire:model="form.category_id" placeholder="Pilih kategori...">
                    @foreach ($this->categories as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select label="User" wire:model="form.user_id" placeholder="Pilih user...">
                    @foreach ($this->users as $user)
                        <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select label="Status" name="status" wire:model="form.status">
                    <flux:select.option value="aktif">Aktif</flux:select.option>
                    <flux:select.option value="nonaktif">Non Aktif</flux:select.option>
                </flux:select>

                <flux:input
                    label="Gambar"
                    type="file"
                    accept="image/*"
                    wire:model="form.image"
                />
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
