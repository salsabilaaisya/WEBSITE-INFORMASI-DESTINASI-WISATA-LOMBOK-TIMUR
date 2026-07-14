<div class="max-w-7xl mx-auto space-y-4">

    <flux:heading size="xl">
        Article
    </flux:heading>

    <flux:subheading>
        Manage your articles
    </flux:subheading>

    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-article">
        <flux:button variant="primary" icon="plus">

            Add Article
        </flux:button>
    </flux:modal.trigger>

    <livewire:admin.articles.create />
    <livewire:admin.articles.edit />

    <x-flash-message />

    <div class="overflow-x-auto">

        <flux:table :paginate="$this->articles">

            <flux:table.columns>

                <flux:table.column>No</flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Content</flux:table.column>
                <flux:table.column>Thumbnail</flux:table.column>
                <flux:table.column>User</flux:table.column>
                <flux:table.column>Published</flux:table.column>
                <flux:table.column>Action</flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @foreach($this->articles as $article)

                    <flux:table.row :key="$article->id">

                        <flux:table.cell>
                            {{ $loop->iteration }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $article->title }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content),80) }}
                        </flux:table.cell>

                        <flux:table.cell>

                            @if($article->thumbnail)

                                <img
                                    src="{{ asset('storage/'.$article->thumbnail) }}"
                                    class="w-16 h-16 rounded object-cover"
                                >

                            @else

                                -

                            @endif

                        </flux:table.cell>

                        <flux:table.cell>

                            {{ $article->user->name ?? '-' }}

                        </flux:table.cell>

                        <flux:table.cell>

                            {{ $article->published_at
                                ? \Carbon\Carbon::parse($article->published_at)->format('d M Y')
                                : '-'
                            }}

                        </flux:table.cell>

                        <flux:table.cell>

                            <flux:dropdown>

                                <flux:button
                                    variant="ghost"
                                    size="sm"
                                    icon="ellipsis-horizontal"
                                />

                                <flux:menu>

                                    <flux:menu.item
                                        icon="pencil"
                                        wire:click="edit({{ $article->id }})"
                                    >
                                        Edit
                                    </flux:menu.item>

                                    <flux:menu.separator />

                                    <flux:menu.item
                                        variant="danger"
                                        icon="trash"
                                        wire:click="delete({{ $article->id }})"
                                    >
                                        Delete
                                    </flux:menu.item>

                                </flux:menu>

                            </flux:dropdown>

                        </flux:table.cell>

                    </flux:table.row>

                @endforeach

            </flux:table.rows>

        </flux:table>

    </div>

</div>