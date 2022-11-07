<?php

namespace App\Http\Livewire\Front;

use App\Models\Setting;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        $settings = Setting::find(1);
        return view('livewire.front.navbar', ['settings' => $settings]);
    }
}
