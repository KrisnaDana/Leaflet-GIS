<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('user')->attempt($validated)){
            $request->session()->regenerate();
            return redirect()->intended(route('index'))->with(['toast_primary' => 'Login succesfully.']);
        }else{
            return redirect()->back()->with(['toast_danger' => 'The provided credentials do not match our records.']);
        }
    }

    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|string|email:rfc,dns|unique:App\Models\User,email',
            'password' => 'required|string|min:8|max:20|same:password_confirmation',
            'password_confirmation' => 'required|string|min:8|max:20|same:password'
        ]);
        $user = array(
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        );
        User::create($user);
        return redirect()->back()->with(['toast_primary' => 'Register successfully.']);
    }
    
    public function logout(Request $request){
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back()->with(['toast_primary' => 'Logout successfully.']);
    }
}
