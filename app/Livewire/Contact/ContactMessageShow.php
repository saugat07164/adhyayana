<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use App\Models\ContactMessage;

class ContactMessageShow extends Component
{
    public $contactmessage;

    public function mount(ContactMessage $contactmessage)
    {
        $this->contactmessage = $contactmessage->load('user');
    }

    public function markAsRead()
{
    if (! $this->contactmessage->is_read) {
        $this->contactmessage->is_read = true;
        $this->contactmessage->save();

        session()->flash('success', 'Message marked as read.');
    }
}

    public function delete()
    {
        $this->contactmessage->delete();
        session()->flash('success', 'Message deleted successfully.');
        return redirect()->route('contactmessages.index');
    }

    public function render()
    {
        return view('livewire.contact.contact-message-show')->layout('layouts.app');
    }
}
