<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\ArticlesForm;

new class extends Component {
    use WithFileUploads;
    public ArticlesForm $form;
    //
    public function save()
    {
        $this->form->store();
        Flux::modal('create-article')->close();

        // session
        session()->flash('success', 'Article created successfully');

        $this->redirectRoute('frontend.articles', navigate: true);

    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-article" class="md:w-full" x-on:close="$wire.resetForm()">
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

                <div>
                    <label class="block text-sm font-medium mb-2">Content</label>
                    <div x-data="tiptapEditor({ modalName: 'create-article', model: 'form.content', placeholder: 'Enter article content...' })"
                        class="tiptap-editor border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden"
                        wire:ignore>
                        <div
                            class="tiptap-toolbar flex flex-wrap gap-0.5 p-2 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                            <button type="button" @click="editor?.chain().focus().toggleBold().run()"
                                :class="{ 'is-active': isActive('bold') }" title="Bold"><strong>B</strong></button>
                            <button type="button" @click="editor?.chain().focus().toggleItalic().run()"
                                :class="{ 'is-active': isActive('italic') }" title="Italic"><em>I</em></button>
                            <button type="button" @click="editor?.chain().focus().toggleUnderline().run()"
                                :class="{ 'is-active': isActive('underline') }" title="Underline"><u>U</u></button>
                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>
                            <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 1 }).run()"
                                :class="{ 'is-active': isActive('heading', { level: 1 }) }"
                                title="Heading 1">H1</button>
                            <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()"
                                :class="{ 'is-active': isActive('heading', { level: 2 }) }"
                                title="Heading 2">H2</button>
                            <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 3 }).run()"
                                :class="{ 'is-active': isActive('heading', { level: 3 }) }"
                                title="Heading 3">H3</button>
                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>
                            <button type="button" @click="editor?.chain().focus().toggleBulletList().run()"
                                :class="{ 'is-active': isActive('bulletList') }" title="Bullet List">&#8226;
                                List</button>
                            <button type="button" @click="editor?.chain().focus().toggleOrderedList().run()"
                                :class="{ 'is-active': isActive('orderedList') }" title="Ordered List">1. List</button>
                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>
                            <button type="button" @click="editor?.chain().focus().setTextAlign('left').run()"
                                :class="{ 'is-active': isActive({ textAlign: 'left' }) }"
                                title="Align Left">&larr;</button>
                            <button type="button" @click="editor?.chain().focus().setTextAlign('center').run()"
                                :class="{ 'is-active': isActive({ textAlign: 'center' }) }"
                                title="Center">&harr;</button>
                            <button type="button" @click="editor?.chain().focus().setTextAlign('right').run()"
                                :class="{ 'is-active': isActive({ textAlign: 'right' }) }"
                                title="Align Right">&rarr;</button>
                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>
                            <button type="button" @click="editor?.chain().focus().toggleBlockquote().run()"
                                :class="{ 'is-active': isActive('blockquote') }" title="Blockquote">&#8220;</button>
                            <button type="button" @click="editor?.chain().focus().toggleCode().run()"
                                :class="{ 'is-active': isActive('code') }" title="Code">&lt;/&gt;</button>
                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>
                            <button type="button" @click="
                                if (editor) {
                                    const url = window.prompt('Enter link URL:')
                                    if (url) editor.chain().focus().setLink({ href: url }).run()
                                }
                            " :class="{ 'is-active': isActive('link') }" title="Link">&#128279;</button>
                            <button type="button" @click="
                                if (editor) {
                                    const url = window.prompt('Enter image URL:')
                                    if (url) editor.chain().focus().setImage({ src: url }).run()
                                }
                            " title="Image">&#128247;</button>
                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>
                            <button type="button" @click="editor?.chain().focus().undo().run()"
                                :disabled="!editor?.can().undo()" title="Undo">&#8630;</button>
                            <button type="button" @click="editor?.chain().focus().redo().run()"
                                :disabled="!editor?.can().redo()" title="Redo">&#8631;</button>
                        </div>
                        <div x-ref="editor" class="tiptap"></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Thumbnail
                    </label>

                    <input type="file" wire:model="form.thumbnail" class="w-full border rounded p-2">
                </div>

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