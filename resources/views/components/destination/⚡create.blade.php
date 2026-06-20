<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Destination;
use App\Models\Category;
use App\Livewire\Forms\DestinationForm;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;
    
    public DestinationForm $form;

    #[Computed]
    public function categories() {
        return Category::all();
    }

    #[On('load-destination')]
    public function loadDestination($id) {
        $destination = Destination::find($id);
        if ($destination) {
            $this->form->setdestination($destination);
            Flux::modal('manage-destination')->show();
        }
    }

    #[On('clear-form')]
    public function clearForm() {
        $this->resetForm();
        Flux::modal('manage-destination')->show();
    }

    public function save() {
        // Pengecekan ketat: jika ada destinationId, jalankan UPDATE, bukan STORE
        if ($this->form->destinationId) {
            $this->form->update($this->form->destinationId);
            session()->flash('success', 'Destination updated successfully');
        } else {
            $this->form->store();
            session()->flash('success', 'Destination created successfully');
        }

        Flux::modal('manage-destination')->close();
        $this->redirectRoute('destination.index', navigate: true);
    }

    public function resetForm() {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
        <form class="space-y-8" wire:submit.prevent="save">
            
            {{-- 🛠️ SOLUSI UTAMA: Taruh ini agar ID terkunci aman di browser & tidak menjadi null --}}
            <input type="hidden" wire:model="form.destinationId">

            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    {{ $this->form->destinationId ? 'Edit Destinasi Wisata' : 'Tambah Destinasi Wisata' }}
                </flux:heading>
            </div>

            <div class="space-y-6">
                <flux:input
                    label="Nama Destinasi"
                    placeholder="Masukkan nama destinasi"
                    wire:model="form.name"
                />

                <flux:textarea
                    label="Deskripsi"
                    placeholder="Masukkan deskripsi lengkap..."
                    wire:model="form.description"
                />

                <flux:input
                    label="Lokasi"
                    placeholder="Masukkan lokasi"
                    wire:model="form.location"
                />

                <flux:select label="Category" wire:model="form.category_id" placeholder="Choose category...">
                    @foreach ($this->categories as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select label="Status" wire:model="form.status">
                    <flux:select.option value="aktif">Aktif</flux:select.option>
                    <flux:select.option value="non aktif">Non Aktif</flux:select.option>
                </flux:select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">
                    {{ $this->form->destinationId ? 'Simpan Perubahan' : 'Tambah Destinasi' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>