<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Destination;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function destinations()
    {
        return destination::latest()->paginate(1);
    }
};
?>

<div class="max-w-7x1 mx-auto space-y-4">
    <flux:heading size="xl" class="text-pink-800 dark:text-white">Destinations</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 zinc:text-white-400">Manage your Destinations</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-destination">
        <flux:button variant="primary" icon="plus" color="rose"> Edit Destination</flux:button>
    </flux:modal.trigger>

    <livewire:destination.create />
 
    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->Destinations">
            <flux:table.columns>
                <flux:table.column >Id</flux:table.column>
                <flux:table.column >Name</flux:table.column>
                <flux:table.column >Descriptions</flux:table.column>
                <flux:table.column >Location</flux:table.column>
                <flux:table.column >Image</flux:table.column>
                <flux:table.column >Category</flux:table.column>
                <flux:table.column >User</flux:table.column>
                <flux:table.column >Status</flux:table.column>
                <flux:table.column >Action</flux.table.column>
            </flux:table.columns>

    <flux:table.rows>
    @foreach ($this->destinations as $destination)
            <flux:table.row :key="$destination->id">

                <flux:table.cell>
                    {{ $loop->iteration + $this->destinations->firstItem() - 1 }}
                </flux:table.cell>

                <flux:table.cell class="flex items-center gap-3">
                    {{ $destination->name }}
                </flux:table.cell>

                <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                    {{ $destination->description ?? '-' }}
                </flux:table.cell>

                <flux:table.cell>
                    {{ $destination->location }}
                </flux:table.cell>

                <flux:table.cell>
                @if($destination->image)
                    <img
                        src="{{ asset('storage/image/' . $destination->image) }}"
                        alt="{{ $destination->name }}" width="120"
                        class="w-14 h-14 object-cover rounded-lg">
                @endif
                </flux:table.cell>

                <flux:table.cell>
                    {{ $destination ->category_id }}
                </flux:table.cell>

                <flux:table.cell>
                    {{ $destination->user_id }}
                </flux:table.cell>

                <flux:table.cell>
                    
                    @if($destination->status === 'aktif')
                        <flux:badge color="green" size="sm" inset="top bottom">Aktif</flux:badgde>
                    @else
                        <flux:badge color="zinc" size="sm" inset="top bottom">Tidak Aktif</flux:badge>
                    @endif
                </flux:table.cell>

            <flux:table.cell>
                <flux:dropdown>
                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"></flux:button>

                    <flux:menu>
                        <flux:menu.item icon="pencil"
                            wire:click="edit({{ $destination->id }})">
                            Edit
                        </flux:menu.item>

                        <flux:menu.separator />

                        <flux:menu.item
                            variant="danger"
                            icon="trash"
                            wire:click="$dispatch('confirm-delete', {id: {{ $destination->id }}})">
                            Delete
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </flux:table.cell>

        </flux:table.row>
    @endforeach
</flux:table.rows>