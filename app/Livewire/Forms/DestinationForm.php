<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Destination;
use Illuminate\Validation\Rule;
use Livewire\Form;

class DestinationForm extends Form
{
    public string $name = '';
    public string $description = '';
    public string $location = '';
    public string $category_id = '';
    public string $status = 'aktif'; 

    
    public $cover_path; 

    public ?int $destinationId = null;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                
                Rule::unique('destinations', 'name')->ignore($this->destinationId),
            ],
            'description' => ['required', 'string', 'max:1000'],
            'location'    => ['required', 'string'],
            'status'      => ['required', 'in:aktif,non_aktif'],
            'category_id' => ['required', 'exists:categories,id'],
            'cover_path'  => ['nullable', 'image', 'max:2048'], 
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Nama destinasi wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'location.required'    => 'Lokasi wajib diisi',
            'category_id.required' => 'Silakan pilih kategori',
        ];
    }

    public function setdestination(Destination $destination): void
    {
        $this->destinationId = $destination->id;

        $this->name = $destination->name;
        $this->description = $destination->description ?? '';
        $this->location = $destination->location;
        $this->status = $destination->status; 
        $this->category_id = $destination->category_id;
    }

    public function store()
    {
        $this->validate();

        $data = $this->only(['name', 'description', 'location', 'status', 'category_id']);
        $data['user_id'] = auth()->id(); 

        if ($this->cover_path) {
            $data['cover_path'] = $this->cover_path->store('destinations', 'public');
        }

        Destination::create($data);
        
        $this->reset();
    }

    public function update($id)
    {
        $this->validate();
        
        $destination = Destination::find($id);
        
        if ($destination) {
            $data = $this->only(['name', 'description', 'location', 'status', 'category_id']);
            
            if ($this->cover_path && !is_string($this->cover_path)) {
                $data['cover_path'] = $this->cover_path->store('destinations', 'public');
            }

            $destination->update($data);
        }
        
        $this->reset();
    }
}