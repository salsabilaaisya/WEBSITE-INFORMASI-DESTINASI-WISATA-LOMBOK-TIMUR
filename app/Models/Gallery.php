<?php

namespace App\Http\Livewire\Pages\Gallery;

use Livewire\Component;
use App\Models\Gallery;

class Index extends Component
{
    public function render()
    {
        $images = Gallery::latest()->get();

        return view('pages.gallery.index', [
            'images' => $images,
        ]);
    }
}
