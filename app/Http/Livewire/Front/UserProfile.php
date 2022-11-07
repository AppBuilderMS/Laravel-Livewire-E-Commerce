<?php

namespace App\Http\Livewire\Front;

use App\Models\Profile;
use App\Models\User;
use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        $userProfile = Profile::where('user_id', \Auth::user()->id)->first();
        if(!$userProfile){
            $profile = new Profile();
            $profile->user_id = \Auth::user()->id;
            $profile->save();
        }
        $user = User::find(\Auth::user()->id);
        return view('livewire.front.user-profile', ['user' => $user])->layout('front-end.layout.app', ['title' => 'User Profile | E-Commerce']);
    }
}
