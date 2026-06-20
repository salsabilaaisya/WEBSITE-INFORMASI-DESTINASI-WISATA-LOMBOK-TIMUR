<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DestinationForm extends Form
{
    public string $name = '';
    
    public string $description = '';

    public ?Destination $destination = null;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('destinations', 'name')->ignore($this->destination?->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function setdestination(Destination $destination): void
    {
        $this->destination = $destination;
        $this->name = $destination->name;
        $this->description = $destination->description ?? '';
    }

    public function store()
    {
        $this->validate();
        destination::create($this->only(['name', 'description']));
        $this->reset();
    }

    // update
    public function update()
    {
        $this->validate();
        $this->destination->update($this->only(['name', 'description']));
    }
}
