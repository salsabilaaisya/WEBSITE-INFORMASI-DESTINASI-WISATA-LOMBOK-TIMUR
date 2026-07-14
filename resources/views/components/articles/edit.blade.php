<div>

    <flux:modal 
        name="edit-article" 
        class="md:w-full"
        x-on:close="$wire.resetForm()"
    >

        <form wire:submit="update" class="space-y-6">

            <flux:heading size="lg">
                Edit Article
            </flux:heading>


            <flux:input
                label="Title"
                wire:model="form.title"
            />


            <flux:textarea
                label="Content"
                wire:model="form.content"
            />


            <input 
                type="file"
                wire:model="form.thumbnail"
            >


            <flux:input
                label="Published At"
                type="date"
                wire:model="form.published_at"
            />


            <div class="flex justify-end gap-3">

                <flux:modal.close>
                    <flux:button variant="outline">
                        Cancel
                    </flux:button>
                </flux:modal.close>


                <flux:button type="submit" variant="primary">
                    Update
                </flux:button>

            </div>

        </form>

    </flux:modal>

</div>