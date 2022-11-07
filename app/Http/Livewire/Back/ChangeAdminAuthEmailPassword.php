<?php

namespace App\Http\Livewire\Back;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangeAdminAuthEmailPassword extends Component
{
    public $name;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount(){
        $this->name = admin()->name;
        $this->email = admin()->email;
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'string',
            'email' => 'email',
//            'current_password' => 'required',
//            'password' => 'required|min:8|confirmed|different:current_password',
        ]);
    }

    public function changePassword()
    {
        $this->validate([
            'name' => 'string',
            'email' => 'email',
//            'current_password' => 'required',
            'password' => $this->current_password ? 'required|min:8|confirmed|different:current_password' : '',
        ]);

        if($this->current_password){
            if(Hash::check($this->current_password, Auth::user()->password))
            {
                $admin = Admin::findOrFail(admin()->id);
                $admin->name = $this->name;
                $admin->email = $this->email;
                $admin->password = Hash::make($this->password);
                $admin->save();
                session()->flash('password_success', 'Admin data has been changed successfully!');
            }else{
                session()->flash('password_error', "Password doesn't match!");
            }
        }else{
            $admin = Admin::findOrFail(admin()->id);
            $admin->name = $this->name;
            $admin->email = $this->email;
            $admin->save();
            session()->flash('password_success', 'Admin data has been changed successfully!');
        }
    }
    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Edit Admin Profile'],
        ];
        return view('livewire.back.change-admin-auth-email-password')->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}
