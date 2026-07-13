<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\ContactMessage;

class ContactForm extends Component
{
    public $name='';
    public $email='';
    public $message='';

    public function send()
    {
        $this->validate([
            'name'=>'required|min:3',
            'email'=>'required|email',
            'message'=>'required|min:10',
        ]);

        ContactMessage::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'message'=>$this->message,
        ]);

        $this->reset();

        session()->flash('success','Message sent successfully.');
    }

    public function render()
    {
        return view('livewire.frontend.contact-form');
    }
}