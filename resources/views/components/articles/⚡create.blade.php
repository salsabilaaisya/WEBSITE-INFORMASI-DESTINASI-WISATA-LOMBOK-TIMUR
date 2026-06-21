<?php

use Livewire\Component;
use App\Livewire\Forms\ArticlesForm;

new class extends Component {
    public ArticlesForm $form;
    //
    public function save()
    {
        $this->form->store();
        Flux::modal('create-article')->close();

        // session
        session()->flash('success', 'Article created successfully');

        $this->redirectRoute('articles.index',navigate: true);

    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-article" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Articles
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new article to your account
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input label="Title" placeholder="Enter articles title" wire:model="form.title" />

                <flux:textarea label="Content" placeholder="Enter articles content" wire:model="form.content" />

                <flux:input label="Thumbnail" placeholder="Enter thumbnail filename" wire:model="form.thumbnail" />

                <flux:input label="Published At" type="date" wire:model="form.published_at" />
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>


        </form>
    </flux:modal>
</div>