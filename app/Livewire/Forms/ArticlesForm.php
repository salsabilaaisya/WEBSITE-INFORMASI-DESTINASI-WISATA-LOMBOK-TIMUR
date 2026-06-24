<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Article;
use Illuminate\Validation\Rule;

class ArticlesForm extends Form
{
    public string $title = '';
    public string $content = '';
    public $thumbnail;
    public string $published_at = '';
    public ?Article $article = null;

    
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
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
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

        $thumbnailPath = null;

        if ($this->thumbnail) {

            $thumbnailPath = $this->thumbnail->store(
                'articles',
                'public'
            );
        }

        Article::create([
            'title' => $this->title,
            'content' => $this->content,
            'thumbnail' => $thumbnailPath,
            'user_id' => auth()->id(),
            'published_at' => $this->published_at,
        ]);

        $this->reset();
    }

    public function setArticle(Article $article): void
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->content = $article->content ?? '';
        $this->thumbnail = $article->thumbnail ?? '';
        $this->user_id = $article->user_id;
        $this->published_at = $article->published_at ?? '';
    }

    // update
    public function update()
    {
        $this->validate();
        $this->article->update([
            'title' => $this->title,
            'content' => $this->content,
            'thumbnail' => $this->thumbnail,
            'user_id' => auth()->id(),
            'published_at' => $this->published_at,]);
    }
}

