<?php

namespace App\Http\Livewire\Back;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    public $business_name;
    public $email;
    public $phone;
    public $phone2;
    public $address;
    public $twitter;
    public $facebook;
    public $youtube;
    public $instagram;
    public $pinterest;
    public $dribbble;
    public $currency;
    public $newLogo1;
    public $oldLogo1;
    public $newLogo2;
    public $oldLogo2;

    public function mount()
    {
        $settings = Setting::find(1);
        if($settings) {
            $this->business_name = $settings->business_name;
            $this->email = $settings->email;
            $this->phone = $settings->phone;
            $this->phone2 = $settings->phone2;
            $this->address = $settings->address;
            $this->twitter = $settings->twitter;
            $this->facebook = $settings->facebook;
            $this->youtube = $settings->youtube;
            $this->instagram = $settings->instagram;
            $this->pinterest = $settings->pinterest;
            $this->dribbble = $settings->dribbble;
            $this->currency = $settings->currency;
            $this->oldLogo1 = $settings->newLogo1;
            $this->oldLogo2 = $settings->newLogo2;
        }
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'business_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'phone2' => 'required|numeric',
            'address' => 'required',
            'twitter' => 'required',
            'facebook' => 'required',
            'youtube'  => 'required',
            'instagram'  => 'required',
            'pinterest' => 'required',
            'dribbble' => 'required',
            'currency' => 'required',
            'newLogo1' => $this->newLogo1 ? 'required|image' : '',
            'newLogo2' => $this->newLogo2 ? 'required|image' : '',
        ]);
    }

    public function saveSettings()
    {
        $this->validate([
            'business_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'phone2' => 'required|numeric',
            'address' => 'required',
            'twitter' => 'required',
            'facebook' => 'required',
            'youtube'  => 'required',
            'instagram'  => 'required',
            'pinterest' => 'required',
            'dribbble' => 'required',
            'currency' => 'required',
            'newLogo1' => $this->newLogo1 ? 'required|image' : '',
            'newLogo2' => $this->newLogo2 ? 'required|image' : '',
        ]);


        $settings = Setting::find(1);

        if(! $settings){
            if($this->newLogo1){
                Image::make($this->newLogo1)->resize(350, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/'.$this->newLogo1->hashName()));
            }

            if($this->newLogo2) {
                Image::make($this->newLogo2)->resize(350, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/'.$this->newLogo2->hashName()));
            }
            $settings = new Setting();
        }


        if($this->newLogo1){
            //delete old image
            if($this->newLogo1 != 'defaultLogo1.png'){
                Storage::disk('public_uploads')->delete('/'.$settings->newLogo1);
            }
            //create new image
            Image::make($this->newLogo1)->save(public_path('uploads/'.$this->newLogo1->hashName()));
        }

        if($this->newLogo2){
            //delete old image
            if($this->newLogo2 != 'defaultLogo2.png'){
                Storage::disk('public_uploads')->delete('/'.$settings->newLogo2);
            }
            //create new image
            Image::make($this->newLogo2)->save(public_path('uploads/'.$this->newLogo2->hashName()));
        }


        $settings->business_name = $this->business_name;
        $settings->email = $this->email;
        $settings->phone = $this->phone;
        $settings->phone2 = $this->phone2;
        $settings->address = $this->address;
        $settings->twitter = $this->twitter;
        $settings->facebook = $this->facebook;
        $settings->youtube = $this->youtube;
        $settings->instagram = $this->instagram;
        $settings->pinterest = $this->pinterest;
        $settings->dribbble = $this->dribbble;
        $settings->currency = $this->currency;

        $settings->newLogo1 = $this->newLogo1 ? $this->newLogo1->hashName() : $this->oldLogo1;
        $settings->newLogo2 = $this->newLogo2 ? $this->newLogo2->hashName() : $this->oldLogo2;

        $settings->save();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Settings has been saved successfully!',
        ]);

    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Settings'],
        ];
        return view('livewire.back.settings')->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}
