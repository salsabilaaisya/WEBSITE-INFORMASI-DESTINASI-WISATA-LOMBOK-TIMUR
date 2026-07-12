<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>
            <flux:heading size="xl">
                Contact Messages
            </flux:heading>

            <flux:subheading class="mt-1">
                Manage messages from website visitors
            </flux:subheading>
        </div>

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
            placeholder="Search message..."
        />
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead>

                <tr class="border-b">

                    <th class="py-3 text-left">ID</th>

                    <th class="py-3 text-left">Name</th>

                    <th class="py-3 text-left">Email</th>

                    <th class="py-3 text-left">Status</th>

                    <th class="py-3 text-left">Date</th>

                    <th class="py-3 text-center">Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($messages as $message)

                <tr class="border-b hover:bg-zinc-50">

                    <td class="py-4">
                        {{ $message->id }}
                    </td>

                    <td class="py-4 font-medium">
                        {{ $message->name }}
                    </td>

                    <td class="py-4">
                        {{ $message->email }}
                    </td>

                    <td class="py-4">

                        @if($message->is_read)

                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                                ✅ Sudah Dilihat
                            </span>

                        @else

                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-700">
                                🔴 Belum Dilihat
                            </span>

                        @endif

                    </td>

                    </td>

                    <td class="py-4">
                        {{ $message->created_at->format('d M Y') }}
                    </td>

                    <td class="py-4">

                        <div class="flex justify-center gap-2">

                            <flux:modal.trigger name="view-message">

                                <flux:button
                                    size="sm"
                                    variant="outline"
                                    icon="eye"
                                    wire:click="view({{ $message->id }})"
                                >
                                    View
                                </flux:button>

                            </flux:modal.trigger>

                            <flux:button
                                size="sm"
                                variant="danger"
                                icon="trash"
                                wire:click="delete({{ $message->id }})"
                                wire:confirm="Delete this message?"
                            >
                                Delete
                            </flux:button>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="py-12 text-center text-zinc-500">

                        No messages found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div>

        {{ $messages->links() }}

    </div>


    {{-- Modal Detail --}}
    <flux:modal
        name="view-message"
        class="md:w-[700px]"
    >

        @if($selectedMessage)

            <div class="space-y-6">

                <div>

                    <flux:heading size="lg">
                        Message Detail
                    </flux:heading>

                    <flux:text class="mt-1">
                        Visitor information
                    </flux:text>

                </div>

                <div class="space-y-4">

                    <div>

                        <p class="text-sm text-zinc-500">
                            Name
                        </p>

                        <p class="font-semibold">
                            {{ $selectedMessage->name }}
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-zinc-500">
                            Email
                        </p>

                        <p class="font-semibold">
                            {{ $selectedMessage->email }}
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-zinc-500">
                            Sent At
                        </p>

                        <p>
                            {{ $selectedMessage->created_at->format('d F Y H:i') }}
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-zinc-500">
                            Message
                        </p>

                        <div class="mt-2 rounded-xl bg-zinc-100 p-4 dark:bg-zinc-800">

                            {{ $selectedMessage->message }}

                        </div>

                    </div>

                </div>

                <div class="flex justify-end">

                    <flux:modal.close>

                        <flux:button>

                            Close

                        </flux:button>

                    </flux:modal.close>

                </div>

            </div>

        @endif

    </flux:modal>

</div>