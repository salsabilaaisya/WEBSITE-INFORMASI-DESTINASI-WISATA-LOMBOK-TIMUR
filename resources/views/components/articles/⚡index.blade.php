<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Article;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function articles()
    { 
        return Article::latest()->paginate(10);
    }

    //
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Article</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your articles</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-article">
        <flux:button variant="primary" icon="plus" color="primary">Add Article</flux:button>
    </flux:modal.trigger>

    <livewire:articles.create />

    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->articles">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column >Title</flux:table.column>
                <flux:table.column>Content</flux:table.column>
                <flux:table.column>Thumbnail</flux:table.column>
                <flux:table.column>User_id</flux:table.column>
                <flux:table.column>Published_at</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->articles as $article)
                    <flux:table.row :key="$article->id">

                        <flux:table.cell class="whitespace-nowrap">{{ $loop->iteration }}</flux:table.cell>
                        
                        <flux:table.cell class="flex items-center gap-3">
                            {{ $article->title }}
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $article->content ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">{{ $article->thumbnail ?? '-' }}</flux:table.cell>

                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $article->user_id ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d-m-Y') : '-' }}
                        </flux:table.cell>

                        <flux:table.cell>


                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $article->id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $article->id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $article->id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>


    </div>
    
</div>