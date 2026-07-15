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

            <flux:text class="mt-2 text-sm text-zinc-500">
                Total Category :
                <span class="font-semibold">{{ $categories->total() }}</span>
            </flux:text>
        </div>

        <div class="flex items-center gap-3">

            <div class="w-72">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="magnifying-glass"
                    placeholder="Search category..."
                />
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

    </div>

    <flux:separator variant="subtle" />

    {{-- Flash Message --}}
    @if(session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">

        <table class="w-full table-fixed">

            <thead class="bg-zinc-50">

                <tr>

                    <th class="w-20 px-6 py-4 text-left text-sm font-semibold">
                        No
                    </th>

                    <th class="w-56 px-6 py-4 text-left text-sm font-semibold">
                        Category
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold">
                        Description
                    </th>

                    <th class="w-48 px-6 py-4 text-center text-sm font-semibold">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr class="border-t hover:bg-zinc-50 transition">

                        <td class="px-6 py-5 align-top">
                            {{ $categories->firstItem() + $loop->index }}
                        </td>

                        <td class="px-6 py-5 align-top font-medium">
                            {{ $category->name }}
                        </td>

                        <td class="px-6 py-5 text-zinc-600 align-top">

                            <div class="whitespace-normal break-words leading-6">
                                {{ $category->description ?: '-' }}
                            </div>

                        </td>

                        <td class="px-6 py-5 align-middle">

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

                        <td colspan="4" class="py-12 text-center text-zinc-500">
                            Belum ada kategori.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div class="mt-8">
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