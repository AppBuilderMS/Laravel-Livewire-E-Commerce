<?php

namespace App\Http\Livewire\Front;

use App\Models\Setting;
use Livewire\Component;

class Contact extends Component
{
    public $name;
    public $email;
    public $phone;
    public $comment;
    public $socials = [];

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'comment' => 'required'
        ]);
    }

    public function sendMessage()
    {
        $this->validate([
          'name' => 'required',
          'email' => 'required|email',
          'phone' => 'required|numeric',
          'comment' => 'required'
        ]);

        $contact = new \App\Models\Contact();
        $contact->name = $this->name;
        $contact->email = $this->email;
        $contact->phone = $this->phone;
        $contact->comment = $this->comment;
        $contact->save();
        $this->restInputs();
        session()->flash('message' , 'We received your message and will contact you back soon.');
    }

    public function restInputs()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->comment = '';
    }

    public function render()
    {
        $settings = Setting::find(1);
        if($settings){
            $this->socials = [
                'twitter' => $settings->twitter,
                'facebook' => $settings->facebook,
                'youtube' => $settings->youtube,
                'instagram' => $settings->instagram,
                'pinterest' => $settings->pinterest,
                'dribbble' => $settings->dribble,
            ];
        }else{
            $this->socials = [];
        }
        return view('livewire.front.contact', ['settings' => $settings])->layout('front-end.layout.app', ['title' => 'Contact | E-Commerce']);
    }
}
