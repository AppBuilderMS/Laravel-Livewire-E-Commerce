<?php

namespace App\Http\Livewire\Front;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserChangePassword extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
           'current_password' => 'required',
           'password' => 'required|min:8|confirmed|different:current_password',
        ]);
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed|different:current_password',
        ]);

        if(Hash::check($this->current_password, Auth::user()->password))
        {
            $user = User::findOrFail(Auth::user()->id);
            $user->password = Hash::make($this->password);
            $user->save();
            session()->flash('password_success', 'Password has been changed successfully!');
        }else{
            session()->flash('password_error', "Password doesn't match!");
        }
    }
    public function render()
    {
        return view('livewire.front.user-change-password')->layout('front-end.layout.app', ['title' => 'Change Password | E-Commerce']);
    }
}
