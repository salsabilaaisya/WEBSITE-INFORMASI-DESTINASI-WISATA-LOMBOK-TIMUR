<?php

namespace App\Livewire\Admin\About;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\About;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $about;

    public $title;
    public $short_description;
    public $description;
    public $vision;
    public $mission;

    public $address;
    public $phone;
    public $email;

    public $facebook;
    public $instagram;
    public $youtube;

    public $image;

    public function mount()
    {
        $this->about = About::first();

        if (!$this->about) {

            $this->about = About::create([
                'title' => '',
            ]);

        }

        $this->fill([
            'title' => $this->about->title,
            'short_description' => $this->about->short_description,
            'description' => $this->about->description,
            'vision' => $this->about->vision,
            'mission' => $this->about->mission,
            'address' => $this->about->address,
            'phone' => $this->about->phone,
            'email' => $this->about->email,
            'facebook' => $this->about->facebook,
            'instagram' => $this->about->instagram,
            'youtube' => $this->about->youtube,
        ]);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'short_description' => 'nullable',
            'description' => 'nullable',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'youtube' => 'nullable',
            'image' => 'nullable|image|max:10240',
        ]);

        $data = [

            'title' => $this->title,

            'short_description' => $this->short_description,

            'description' => $this->description,

            'vision' => $this->vision,

            'mission' => $this->mission,

            'address' => $this->address,

            'phone' => $this->phone,

            'email' => $this->email,

            'facebook' => $this->facebook,

            'instagram' => $this->instagram,

            'youtube' => $this->youtube,

        ];

        if ($this->image) {

            if (
                $this->about->image &&
                Storage::disk('public')->exists($this->about->image)
            ) {
                Storage::disk('public')->delete($this->about->image);
            }

            $data['image'] = $this->image->store('about', 'public');
        }

        $this->about->update($data);

        session()->flash(
            'success',
            'About berhasil diperbarui.'
        );
    }

    public function render()
    {
        return view('about.index');
    }
}