<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use App\Models\ContactMessage;
class ContactMessageIndex extends Component
{
    public $contactmessages;

    public function mount(){
        $this->loadContactMessages();
    }
    public function loadContactMessages()
    {
        $this->contactmessages = ContactMessage::with('user')->get();

    }
public function deleteAllRead()
{
    ContactMessage::where('is_read', true)->delete();

    session()->flash('message', 'All read messages have been deleted.');

    // Refresh the contact messages collection to update the UI
    $this->contactmessages = ContactMessage::all();
}

    public function delete($id)
{
    $contactMessage = ContactMessage::find($id);
    if ($contactMessage) {
        $contactMessage->delete();
        session()->flash('message', 'Deleted successfully.');
       $this->loadContactMessages();
    } else {
        session()->flash('error', 'Message not found.');
        $this->loadContactMessages();
    }
}

    public function render()
    {
        return view('livewire.contact.contact-message-index')
            ->layout('layouts.app');
    }
}
