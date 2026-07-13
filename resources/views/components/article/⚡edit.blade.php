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

        $this->redirectRoute('frontend.articles', navigate: true);

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

        $this->redirectRoute('frontend.articles', navigate: true);

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



                <div>

                    <label class="block text-sm font-medium mb-2">Content</label>

                    <div

                        x-data="tiptapEditor({ modalName: 'edit-article', model: 'form.content', placeholder: 'Edit article content...' })"

                        class="tiptap-editor border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden"

                        wire:ignore

                    >

                        <div class="tiptap-toolbar flex flex-wrap gap-0.5 p-2 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">

                            <button type="button" @click="editor?.chain().focus().toggleBold().run()" :class="{ 'is-active': isActive('bold') }" title="Bold"><strong>B</strong></button>

                            <button type="button" @click="editor?.chain().focus().toggleItalic().run()" :class="{ 'is-active': isActive('italic') }" title="Italic"><em>I</em></button>

                            <button type="button" @click="editor?.chain().focus().toggleUnderline().run()" :class="{ 'is-active': isActive('underline') }" title="Underline"><u>U</u></button>

                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>

                            <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': isActive('heading', { level: 1 }) }" title="Heading 1">H1</button>

                            <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': isActive('heading', { level: 2 }) }" title="Heading 2">H2</button>

                            <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'is-active': isActive('heading', { level: 3 }) }" title="Heading 3">H3</button>

                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>

                            <button type="button" @click="editor?.chain().focus().toggleBulletList().run()" :class="{ 'is-active': isActive('bulletList') }" title="Bullet List">&#8226; List</button>

                            <button type="button" @click="editor?.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': isActive('orderedList') }" title="Ordered List">1. List</button>

                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>

                            <button type="button" @click="editor?.chain().focus().setTextAlign('left').run()" :class="{ 'is-active': isActive({ textAlign: 'left' }) }" title="Align Left">&larr;</button>

                            <button type="button" @click="editor?.chain().focus().setTextAlign('center').run()" :class="{ 'is-active': isActive({ textAlign: 'center' }) }" title="Center">&harr;</button>

                            <button type="button" @click="editor?.chain().focus().setTextAlign('right').run()" :class="{ 'is-active': isActive({ textAlign: 'right' }) }" title="Align Right">&rarr;</button>

                            <span class="w-px mx-1 bg-zinc-300 dark:bg-zinc-600 self-stretch"></span>

                            <button type="button" @click="editor?.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': isActive('blockquote') }" title="Blockquote">&#8220;</button>

                            <button type="button" @click="editor?.chain().focus().toggleCode().run()" :class="{ 'is-active': isActive('code') }" title="Code">&lt;/&gt;</button>

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

                            <button type="button" @click="editor?.chain().focus().undo().run()" :disabled="!editor?.can().undo()" title="Undo">&#8630;</button>

                            <button type="button" @click="editor?.chain().focus().redo().run()" :disabled="!editor?.can().redo()" title="Redo">&#8631;</button>

                        </div>

                        <div x-ref="editor" class="tiptap"></div>

                    </div>

                </div>



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