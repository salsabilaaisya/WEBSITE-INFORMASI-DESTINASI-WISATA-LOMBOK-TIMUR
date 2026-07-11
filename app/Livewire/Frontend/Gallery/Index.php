<?php

namespace App\Livewire\Frontend\Gallery;

use Livewire\Component;
use App\Models\Gallery;

class Index extends Component
{
    public $search = '';

    public function render()
    {
        $galleries = Gallery::with('destination')
            ->when($this->search, function ($query) {
                $query->where('caption', 'like', '%' . $this->search . '%')
                    ->orWhereHas('destination', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->get();

        return view('livewire.frontend.gallery.index', [
            'galleries' => $galleries
        ]);
    }
}