<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('user')->attempt($validated)){
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        }else{
            return redirect()->back()->with(['error' => 'The provided credentials do not match our records.']);
        }
    }

    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|string|email:rfc,dns|unique:App\Models\User:email',
            'password' => 'required|string|min:8|max:20|same:password_confirmation',
            'password_confirmation' => 'required|string|min:8|max:20|same:password'
        ]);
        $user = array(
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
        );
        User::create($user);
        return back();
    }
    
    public function logout(Request $request){
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return back();
    }
}
