<?php

namespace App\Http\Livewire\Front;

use App\Models\Setting;
use Livewire\Component;

class Footer extends Component
{
    public $socials = [];
    public function render()
    {
        $settings = Setting::find(1);
        if ($settings){
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
        return view('livewire.front.footer', ['settings' => $settings]);
    }
}
