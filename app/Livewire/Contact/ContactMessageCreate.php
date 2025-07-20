<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class ContactMessageCreate extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    public function mount()
    {
        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
        }
    }

    public function submit()
    {
        $this->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ] + (Auth::guest() ? [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ] : []));

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        ContactMessage::create($data);

        session()->flash('message', 'We will shortly respond to your message. Thank you for your participation.');

        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact.contact-message-create')->layout('layouts.app');
    }
}
