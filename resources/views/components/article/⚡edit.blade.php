<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Article;
use App\Livewire\Forms\ArticlesForm;

new class extends Component
{
    public ArticlesForm $form;

   #[On('edit-article')]
    public function editArticle($id){
        $article = Article::find($id);
        $this->form->setArticle($article);
        Flux::modal('edit-article')->show();
    }

    public function updateArticle(){
        $this->form->update();
        Flux::modal('edit-article')->close();
        session()->flash('success', 'Article updated successfully');
        $this->redirectRoute('articles.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $article = Article::find($id);
        $this->form->setArticle($article);
        Flux::modal('delete-article')->show();
    }

    public function deleteArticle(){
        $this->form->article->delete();
        Flux::modal('delete-article')->close();
        session()->flash('success', 'Article deleted successfully');
        $this->redirectRoute('articles.index', navigate: true);
    }
};
?>

<div>

    <flux:modal
        name="edit-article"
        class="md:w-150"
        x-on:close="$wire.resetForm()"
    >
        <form class="space-y-8" wire:submit.prevent="updateArticle">

            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Article
                </flux:heading>

                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit your article details below
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">

                <flux:input
                    label="Title"
                    placeholder="Enter article title"
                    wire:model="form.title"
                    wire:dirty.class.text-red-500
                />

                <flux:textarea
                    label="Content"
                    placeholder="Enter article content"
                    wire:model="form.content"
                    wire:dirty.class.text-red-500
                />

                <flux:input
                    label="Thumbnail"
                    placeholder="Enter thumbnail"
                    wire:model="form.thumbnail"
                    wire:dirty.class.text-red-500
                />

                <flux:input
                    label="User ID"
                    type="number"
                    placeholder="Enter user id"
                    wire:dirty.class.text-red-500
                />

                <flux:input
                    label="Published At"
                    type="date"
                    wire:model="form.published_at"
                    wire:dirty.class.text-red-500
                />

            </div>

            <div
                wire:show="$dirty"
                class="text-red-500 dark:text-red-400"
            >
                you have unsaved changes
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">

                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">
                        Cancel
                    </flux:button>
                </flux:modal.close>

                <flux:button
                    variant="primary"
                    color="primary"
                    type="submit"
                >
                    Update
                </flux:button>

            </div>

        </form>
    </flux:modal>

    {{-- delete modal --}}

    <flux:modal 
        name="delete-article" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deleteArticle">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Article
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    This action cannot be undone.
                </flux:text>
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>