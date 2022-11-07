<?php

namespace App\Http\Livewire\Back\Contacts;

use App\Models\Contact;
use Livewire\Component;

class ContactDetails extends Component
{
    public $contact_id;
    public $name;
    public $email;
    public $phone;
    public $comment;

    protected $listeners = [
        'forceCloseModal',
        'sendContactId'
    ];

    public function sendContactId($value)
    {
        $this->contact_id = $value;
        $contact = Contact::findOrFail($this->contact_id);
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->comment = $contact->comment;

    }

    public function forceCloseModal()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->comment = '';
        //they clear the error bag.
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function formReset()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->comment = '';
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('livewire.back.contacts.contact-details');
    }
}
