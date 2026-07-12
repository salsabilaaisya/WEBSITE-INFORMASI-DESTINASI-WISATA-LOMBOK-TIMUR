<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $message = '';

    public function send()
    {
        $this->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        $this->reset();

        session()->flash(
            'success',
            'Your message has been sent successfully.'
        );
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}