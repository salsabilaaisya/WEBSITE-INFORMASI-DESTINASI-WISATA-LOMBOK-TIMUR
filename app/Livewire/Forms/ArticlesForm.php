<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Articles;
use Illuminate\Validation\Rule;

class ArticlesForm extends Form
{
    public string $title = '';
    
    public string $content = '';

    public string $thumbnail = '';

    public int $user_id = 0;

    public string $published_at = '';

    public ?Articles $article = null;

    
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('articles', 'title')->ignore($this->article?->id),
            ],
            'content' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'thumbnail' => [
                'nullable',
                'string',
                'max:255',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'published_at' => [
                'required',
                'date',
            ],
        ];
    }

    public function store()
    {
        $this->validate();
        Articles::create($this->only(['title', 'content', 'thumbnail', 'user_id', 'published_at']));
        $this->reset();
    }
}


