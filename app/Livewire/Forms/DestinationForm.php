<?php

namespace App\Livewire\Forms;

use App\Models\Destination;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DestinationForm extends Form
{
 public string $name = '';
 public string $description ='';
 public string $location ='';
 public $image ='';
 public string $category_id = '';
 public string $user_id = '';
 public string $status = 'draft';

 public ?Destination $destination = null;

 public function rules(): array
 {
    return [
        'name' => [
            'required',
            'string',
            'min :3',
            'max:255',
            Rule::unique('destinations', 'name')->ignore($this->destination?->id),
        ],
        'description' => [
            'required',
            'string',
            'min:10',
        ],
        'location' => [
            'required',
            'string',
            'max:255',
        ],
        'image' => [
            'nullable',
            'file',
            'image',
            'max:2048',
        ],
        'category_id' => [
            'required',
            'exists:categories,id',
        ],
        'user_id' => [
            'required',
            'exists:users,id',
        ],
        'status' => [
            'required',
            Rule::in(['aktif','nonaktif']),
        ],
    ];
}

    public function setDestination(Destination $destination): void
    { 
        $this->destination =$destination;
        $this->name = $destination->name;
        $this->description = $destination->description;
        $this->location = $destination->location;
        $this->image = $destination->image;
        $this->category_id = $destination->category_id;
        $this->user_id = $destination->user_id; 
        $this->status = $destination->status;
    }

    public function store()
    {
        $this->validate();

        if ($this->image) {
            $this->image = $this->image->store('destinations', 'public');
        }

        Destination::create($this->only([
            'name',
            'description',
            'location',
            'image',
            'category_id',
            'user_id',
            'status',
        ]));

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        if($this->image && is_object($this->image)) {
            if ($this->destination->image) {
                \Storage::disk('public')->delete($this->destination->image);
            }
            $this->image = $this->image->store('destinations', 'public');
        } else {
            $this->image = $this->destination->image;
        }

        $this->destination->update($this->only([
            'name',
            'description',
            'location',
            'image',
            'category_id',
            'user_id',
            'status',
        ]));
    }
}
