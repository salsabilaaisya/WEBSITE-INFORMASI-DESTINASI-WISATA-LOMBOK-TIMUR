<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Destination;

new class extends Component
{
    use WithPagination;

    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function destinations()
    {
        return Destination::query()
            ->with(['category','user'])
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(5);
    }

    public function edit($id)
    {
        $this->dispatch('Tambah Destination', id: $id);
    }

    public function render()
    {
        return view('livewire.destination.index', [
            'destinations' => $this->destinations,
        ]);
    }
};