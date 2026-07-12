<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>
            <flux:heading size="xl">
                Category
            </flux:heading>

            <flux:subheading class="mt-1">
                Manage your categories
            </flux:subheading>
        </div>

        <flux:modal.trigger name="add-category">
            <flux:button
                variant="primary"
                icon="plus"
                wire:click="resetForm"
            >
                Add Category
            </flux:button>
        </flux:modal.trigger>

    </div>

    <flux:separator variant="subtle"/>

    {{-- Flash Message --}}
    @if(session()->has('success'))
        <div class="rounded-lg bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="w-80">
        <flux:input
            wire:model.live.debounce.300ms="search"
            icon="magnifying-glass"
            placeholder="Search category..."
        />
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead>

                <tr class="border-b">

                    <th class="py-3 text-left">
                        ID
                    </th>

                    <th class="py-3 text-left">
                        Category
                    </th>

                    <th class="py-3 text-left">
                        Description
                    </th>

                    <th class="py-3 text-center">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr class="border-b hover:bg-zinc-50">

                        <td class="py-4">
                            {{ $category->id }}
                        </td>

                        <td class="py-4 font-medium">
                            {{ $category->name }}
                        </td>

                        <td class="py-4 text-zinc-600">
                            {{ $category->description ?: '-' }}
                        </td>

                        <td class="py-4">

                            <div class="flex justify-center gap-2">

                                <flux:button
                                    size="sm"
                                    variant="outline"
                                    icon="pencil"
                                    wire:click="edit({{ $category->id }})"
                                >
                                    Edit
                                </flux:button>

                                <flux:button
                                    size="sm"
                                    variant="danger"
                                    icon="trash"
                                    wire:click="delete({{ $category->id }})"
                                    wire:confirm="Yakin ingin menghapus kategori ini?"
                                >
                                    Delete
                                </flux:button>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="py-10 text-center text-zinc-500">

                            Belum ada kategori.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $categories->links() }}
    </div>


    {{-- Modal --}}
    <flux:modal name="add-category" class="md:w-[500px]">

        <form
            wire:submit.prevent="{{ $editId ? 'update' : 'save' }}"
            class="space-y-5"
        >

            <div>

                <flux:heading size="lg">

                    {{ $editId ? 'Edit Category' : 'Add Category' }}

                </flux:heading>

                <flux:text class="mt-1">

                    {{ $editId ? 'Update category.' : 'Create new category.' }}

                </flux:text>

            </div>

            @if($editId)

                <flux:input
                    label="Category Name"
                    wire:model="editName"
                    placeholder="Category Name"
                />

                @error('editName')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <flux:textarea
                    label="Description"
                    wire:model="editDescription"
                    placeholder="Description"
                />

            @else

                <flux:input
                    label="Category Name"
                    wire:model="name"
                    placeholder="Category Name"
                />

                @error('name')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <flux:textarea
                    label="Description"
                    wire:model="description"
                    placeholder="Description"
                />

            @endif

            <div class="flex justify-end gap-3 pt-4">

                <flux:modal.close>

                    <flux:button variant="outline">
                        Cancel
                    </flux:button>

                </flux:modal.close>

                <flux:button
                    type="submit"
                    variant="primary"
                >

                    {{ $editId ? 'Update Category' : 'Save Category' }}

                </flux:button>

            </div>

        </form>

    </flux:modal>

</div>