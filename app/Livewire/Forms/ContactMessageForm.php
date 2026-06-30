<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\ContactMessage;

class ContactMessageForm extends Form
{
    // Menyimpan data ContactMessage yang dipilih
    public ?ContactMessage $contactMessage = null;

    // Property untuk menampilkan data
    public string $name = '';
    public string $email = '';
    public string $message = '';

    /**
     * Mengambil data Contact Message yang dipilih
     */
    public function setContactMessage(ContactMessage $contactMessage): void
    {
        $this->contactMessage = $contactMessage;

        $this->name = $contactMessage->name;
        $this->email = $contactMessage->email;
        $this->message = $contactMessage->message;
    }
}
