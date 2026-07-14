<?php

namespace App\Livewire\Admin\Articles;

use Livewire\Component;
use App\Models\Article;
use Livewire\WithFileUploads;
use Flux\Flux;

class Create extends Component
{
    use WithFileUploads;

    public $title = '';
    public $slug = '';
    public $description = '';
    public $content = '';
    public $image;
    public $category_id = '';

    public array $form = [
        'title' => '',
        'content' => '',
        'thumbnail' => null,
        'published_at' => null,
    ];


    public function save()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.content' => 'required',
            'form.thumbnail' => 'nullable|image|max:10240',
            'form.published_at' => 'nullable|date',
        ]);

        $thumbnailPath = null;

        if ($this->form['thumbnail']) {
            $thumbnailPath = $this->form['thumbnail']->store('articles', 'public');
        }

        Article::create([
            'title' => $this->form['title'],
            'content' => $this->form['content'],
            'thumbnail' => $thumbnailPath,
            'user_id' => auth()->id(),
            'published_at' => $this->form['published_at'],
        ]);

        $this->reset();

        Flux::modal('create-article')->close();

        session()->flash(
            'success',
            'Article berhasil ditambahkan'
        );

        $this->dispatch('article-created');
    }

    public function resetForm()
    {
        $this->reset([
            'title',
            'description',
            'content',
            'image',
        ]);

        $this->resetValidation();
    }


    public function render()
    {
        return view('components.articles.create');
    }
}