<div class="max-w-7xl mx-auto space-y-6">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">
        Category
    </flux:heading>

    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">
        Manage your categories
    </flux:subheading>

    <flux:separator variant="subtle" />


    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700 dark:border-green-800 dark:bg-green-950/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM TAMBAH CATEGORY --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <flux:heading size="lg" class="mb-4 text-zinc-900 dark:text-white">
            Tambah Kategori
        </flux:heading>

        <form wire:submit.prevent="save" class="space-y-4">
            <flux:input
                label="Nama Kategori"
                wire:model="name"
                placeholder="Masukkan nama kategori"
            />

            @error('name')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <flux:textarea
                label="Deskripsi"
                wire:model="description"
                placeholder="Masukkan deskripsi kategori"
            />

            @error('description')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" color="primary">
                    Simpan
                </flux:button>
            </div>
        </form>
    </div>

    {{-- FORM EDIT CATEGORY --}}
    @if ($editId)
        <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm dark:border-yellow-800 dark:bg-yellow-950/20">
            <flux:heading size="lg" class="mb-4 text-zinc-900 dark:text-white">
                Edit Kategori
            </flux:heading>

            <form wire:submit.prevent="update" class="space-y-4">
                <flux:input
                    label="Nama Kategori"
                    wire:model="editName"
                    placeholder="Masukkan nama kategori"
                />

                @error('editName')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <flux:textarea
                    label="Deskripsi"
                    wire:model="editDescription"
                    placeholder="Masukkan deskripsi kategori"
                />

                <div class="flex justify-end gap-3">
                    <flux:button type="button" variant="outline" wire:click="cancelEdit">
                        Batal
                    </flux:button>

                    <flux:button type="submit" variant="primary" color="amber">
                        Update
                    </flux:button>
                </div>
            </form>
        </div>
    @endif

    {{-- TABLE CATEGORY --}}
    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Description</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($categories as $category)
                <flux:table.row :key="$category->id">
                    <flux:table.cell>{{ $category->id }}</flux:table.cell>
                    <flux:table.cell>{{ $category->name }}</flux:table.cell>
                    <flux:table.cell>{{ $category->description ?: '-' }}</flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:button
                                size="sm"
                                variant="outline"
                                wire:click="edit({{ $category->id }})"
                            >
                                Edit
                            </flux:button>

                            <flux:button
                                size="sm"
                                variant="danger"
                                wire:click="delete({{ $category->id }})"
                                wire:confirm="Yakin ingin menghapus kategori ini?"
                            >
                                Hapus
                            </flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="4" class="py-6 text-center text-zinc-500">
                        Belum ada data kategori
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>