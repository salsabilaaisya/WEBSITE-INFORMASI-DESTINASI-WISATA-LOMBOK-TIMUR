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
    public string $thumbnail = '';
    public int $user_id = 0;
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
            'string',
            'max:255',
            ],
            'user_id' => [
            'required',
            'integer',
            'exists:users,id',
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
        Article::create($this->only(['title', 'content', 'thumbnail', 'user_id', 'published_at']));
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
        $this->article->update(
        $this->only([
            'title',
            'content',
            'thumbnail',
            'user_id',
            'published_at']));
    }
}

