<?php

namespace App\Http\Livewire\Front;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditUserProfile extends Component
{
    use WithFileUploads;

    public $newImage;
    public $image;
    public $name;
    public $email;
    public $phone;
    public $line1;
    public $line2;
    public $city;
    public $province;
    public $country;
    public $zipcode;

    public function mount()
    {
        $user = User::find(\Auth::user()->id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->image = $user->profile->image;
        $this->phone = $user->profile->phone;
        $this->line1 = $user->profile->line1;
        $this->line2 = $user->profile->line2;
        $this->city = $user->profile->city;
        $this->province = $user->profile->province;
        $this->country = $user->profile->country;
        $this->zipcode = $user->profile->zipcode;

    }

    public function updateUserProfile()
    {
        $user = User::find(\Auth::user()->id);
        $user->name = $this->name;
        $user->save();

        if($this->newImage){
            //delete old image
            if($this->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/profile/'.$this->image);
            }
            //create new image
            Image::make($this->newImage)->save(public_path('uploads/profile/'.$this->newImage->hashName()));

            $user->profile->image = $this->newImage->hashName();
        }

        $user->profile->phone = $this->phone;
        $user->profile->line1 = $this->line1;
        $user->profile->line2 = $this->line2;
        $user->profile->city = $this->city;
        $user->profile->province = $this->province;
        $user->profile->country = $this->country;
        $user->profile->zipcode = $this->zipcode;
        $user->profile->save();

        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Profile has been saved successfully!',
        ]);
    }

    public function render()
    {
        $user = User::find(\Auth::user()->id);
        return view('livewire.front.edit-user-profile', ['user' => $user])->layout('front-end.layout.app', ['title' => 'Edit User Profile | E-Commerce']);
    }
}
