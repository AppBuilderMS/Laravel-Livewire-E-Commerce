<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function store(LoginRequest $request){
/*        if( ! Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))){
            throw ValidationException::withMessages([
               'email' => 'Invalid email or password'
            ]);
        }*/

        $request->authenticate('admin');

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
