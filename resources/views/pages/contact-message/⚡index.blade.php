<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ContactMessage;
use App\Livewire\Forms\ContactMessageForm;
use Flux\Flux;

new class extends Component
{
    use WithPagination;
    public ContactMessageForm $form;

    #[Computed]
    public function contactMessages()
    {
        return ContactMessage::latest()->paginate(10);
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $contactMessage = ContactMessage::find($id);

        $this->form->setContactMessage($contactMessage);

        Flux::modal('delete-contact-message')->show();
    }

    public function deleteContactMessage()
    {
        $this->form->contactMessage->delete();

        Flux::modal('delete-contact-message')->close();

        session()->flash('success', 'Contact message deleted successfully');

        $this->redirectRoute('contact-messages.index', navigate: true);
    }

};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Contact Messages</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your contact messages</flux:subheading>
    <flux:separator variant="subtle" />

    {{-- Table --}}
    <div class="overflow-x-auto">
        <flux:table :paginate="$this->contactMessages">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>

                <flux:table.column>Name</flux:table.column>

                <flux:table.column>Email</flux:table.column>

                <flux:table.column>Message</flux:table.column>

                <flux:table.column>Created At</flux:table.column>

                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->contactMessages as $contactMessage)

                    <flux:table.row :key="$contactMessage->id">
                        
                        <flux:table.cell>
                            {{ $loop->iteration + $this->contactMessages->firstItem() - 1 }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $contactMessage->name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <a href="mailto:{{ $contactMessage->email }}"
                               class="text-blue-600 hover:underline">
                                {{ $contactMessage->email }}
                            </a>
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ Str::limit($contactMessage->message, 50) }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ \Carbon\Carbon::parse($contactMessage->created_at)->format('d-m-Y') }}
                        </flux:table.cell>

                        <flux:table.cell>

                            <flux:dropdown>

                                <flux:button
                                    variant="ghost"
                                    size="sm"
                                    icon="ellipsis-horizontal"
                                    inset="top bottom">
                                </flux:button>

                                <flux:menu>

                                    <flux:menu.item
                                        variant="danger"
                                        icon="trash"
                                        wire:click="$dispatch('confirm-delete', {id: {{ $contactMessage->id }}})">
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

{{-- Delete Modal --}}
<flux:modal
    name="delete-contact-message"
    class="md:w-96">

    <form wire:submit.prevent="deleteContactMessage">

        <div class="space-y-4">

            <flux:heading size="lg">
                Delete Contact Message
            </flux:heading>

            <flux:text>
                Are you sure you want to delete this contact message?
            </flux:text>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <flux:modal.close>
                <flux:button variant="outline">
                    Cancel
                </flux:button>
            </flux:modal.close>

            <flux:button
                type="submit"
                variant="primary"
                color="danger">
                Delete
            </flux:button>

        </div>

    </form>

</flux:modal>


