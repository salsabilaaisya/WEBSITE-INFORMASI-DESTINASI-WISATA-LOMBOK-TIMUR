<?php

namespace App\Livewire\Admin\Articles;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Article;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    #[Computed]
    public function articles()
    {
        return Article::latest()->paginate(10);
    }

    #[On('article-created')]
    public function refreshArticles()
    {
        unset($this->articles);
    }

    public function edit($id)
    {
        $this->dispatch('edit-article', id: $id);
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        session()->flash('success', 'Artikel berhasil dihapus.');

         $this->resetPage();
    }

    public function render()
    {
        return view('pages.articles.index');
    }
}