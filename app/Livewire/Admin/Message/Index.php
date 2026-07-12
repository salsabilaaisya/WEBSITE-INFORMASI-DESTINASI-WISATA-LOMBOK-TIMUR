<?php

namespace App\Livewire\Admin\Message;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';

    public $selectedMessage = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function view($id)
    {
        $this->selectedMessage = ContactMessage::findOrFail($id);

        if (!$this->selectedMessage->is_read) {

            $this->selectedMessage->update([
                'is_read' => true,
            ]);

            $this->selectedMessage->refresh();
        }
    }

    public function delete($id)
    {
        ContactMessage::findOrFail($id)->delete();

        session()->flash('success', 'Message deleted successfully.');
    }

    public function render()
    {
        return view('message.index', [
        'messages' => ContactMessage::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('message', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10),
    ]);
    }
}