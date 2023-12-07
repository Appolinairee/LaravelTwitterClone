<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register() {
        return view('Auth.register');
    }

    public function store(Request $request) {

        $request->validate([
            'name'  => ['required', 'min:3', 'max:40'],
            'email'  => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'confirmed'],
        ]);

        User::create([
            'name'  => $request->name,
            'email'  => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('welcome')->with('success', 'L\'utilisateur '. $request->name . ' est créé avec succès');
    }

    public function login(){
        return view('Auth.login');
    }

    public function authenticate(Request $request){
        // dd('test1');
        $validated = $request->validate([
            'email'  => ['required', 'email'],
            'password'  => ['required']
        ]);

       if(auth()->attempt($validated)){
            $request->session()->regenerate();
            return redirect()->route('welcome')->with('success', 'Login is successfully');
       }

        return redirect()->route('login')->withErrors([
            'email' => "Email don't find",
        ]);
    }

    public function logout() {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'You logOut successfully');
    }
}
