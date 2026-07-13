<?php

namespace App\Livewire\Admin\Message;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Models\ContactMessage;

class Index extends Component
{
    use WithPagination;

    public ?ContactMessage $contactMessage = null;

    #[Computed]
    public function contactMessages()
    {
        return ContactMessage::latest()->paginate(10);
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $this->contactMessage = ContactMessage::findOrFail($id);

        Flux::modal('delete-contact-message')->show();
    }

    public function deleteContactMessage()
    {
        if ($this->contactMessage) {
            $this->contactMessage->delete();
        }

        Flux::modal('delete-contact-message')->close();

        session()->flash('success', 'Contact message deleted successfully');
    }

    public function render()
    {
        return view('message.index');
    }
}