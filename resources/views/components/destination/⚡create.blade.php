<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <flux:modal name="create-destination" class="md:w-105">
    <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-pink-900 dark:text-white">
                    Tambahkan Destinasi
                </flux:heading>
                <flux:text class="text-yellow-500 dark:text-white-400">
                    Tambahkan Destinasi Baru di profil mu
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Nama"
                    placeholder="Tambahkan nama destinasi"
                    wire:model="form.nama"
                />

                <flux:textarea
                    label="Descripsition"
                    placeholder="Tambahkan deskripsi destinasi"
                    wire:model="form.description"
                />

                <flux:input
                    label="Location"
                    placeholder="Tambahkan lokasi destinasi"
                    wire:model="form.location"
                />
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
                

        </form>
</flux:modal>
</div>