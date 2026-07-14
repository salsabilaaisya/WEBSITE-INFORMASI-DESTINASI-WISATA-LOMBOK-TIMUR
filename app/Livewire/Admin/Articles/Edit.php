<?php

namespace App\Livewire\Admin\Articles;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Article;
use Flux\Flux;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public ?Article $article = null;

    public array $form = [
        'title' => '',
        'content' => '',
        'thumbnail' => null,
        'published_at' => null,
    ];

    #[On('edit-article')]
    public function loadArticle($id)
    {
        $this->article = Article::findOrFail($id);

        $this->form = [
            'title' => $this->article->title,
            'content' => $this->article->content,
            'thumbnail' => null,
            'published_at' => $this->article->published_at,
        ];

        Flux::modal('edit-article')->show();
    }


    public function edit($id)
    {
        $this->article = Article::findOrFail($id);

        $this->form = [
            'title' => $this->article->title,
            'content' => $this->article->content,
            'thumbnail' => null,
            'published_at' => $this->article->published_at,
        ];

        Flux::modal('edit-article')->show();
    }


    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.content' => 'required',
            'form.thumbnail' => 'nullable|image|max:2048',
            'form.published_at' => 'nullable|date',
        ]);


        $thumbnailPath = $this->article->thumbnail;


        if ($this->form['thumbnail']) {
            $thumbnailPath = $this->form['thumbnail']
                ->store('articles', 'public');
        }


        $this->article->update([
            'title' => $this->form['title'],
            'content' => $this->form['content'],
            'thumbnail' => $thumbnailPath,
            'published_at' => $this->form['published_at'],
        ]);


        $this->resetForm();

        Flux::modal('edit-article')->close();

        session()->flash(
            'success',
            'Article berhasil diperbarui'
        );

        $this->dispatch('article-updated');
    }


    public function resetForm()
    {
        $this->article = null;

        $this->form = [
            'title' => '',
            'content' => '',
            'thumbnail' => null,
            'published_at' => null,
        ];
    }


    public function render()
    {
        return view('components.articles.edit');
    }
}