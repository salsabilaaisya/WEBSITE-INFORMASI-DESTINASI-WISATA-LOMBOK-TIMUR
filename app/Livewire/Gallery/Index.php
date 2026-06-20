<?php

namespace App\Livewire\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Gallery;

class Index extends Component
{
    use WithFileUploads;

    public $title;
    public $image;

    public function save()
    {
        $this->validate([
            'image' => 'required|image|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        $path = $this->image->store('gallery', 'public');

        Gallery::create([
            'title' => $this->title,
            'image' => $path,
        ]);

        $this->reset(['title', 'image']);

        session()->flash('success', 'Foto berhasil diupload!');
    }

    public function render()
    {
        return view('livewire.gallery.index', [
            'galleries' => Gallery::latest()->get()
        ])->layout('layouts.sidebar'); // Mengarahkan komponen agar dibungkus template sidebar kamu
    }
}