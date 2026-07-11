<?php

namespace App\Livewire\Admin\Article;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Article;

class Index extends Component
{
    use WithPagination;

    #[Computed]
    public function articles()
    {
        return Article::latest()->paginate(10);
    }

    public function edit($id)
    {
        $this->dispatch('edit-article', id: $id);
    }

    public function render()
    {
        return view('pages.articles.index');
    }
}