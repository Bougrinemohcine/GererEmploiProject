<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function createUser(UserRequest $request)
    {
        $formFields = $request->validated();
        $formFields['password'] = Hash::make($request->password);
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required | confirmed',
        // ]);
        User::create($formFields);
        return redirect()->route('home')->with('success', 'Votre Compte a été bien créé.');
    }

    public function login(Request $request){
        $credentials = ['email' => $request->email , 'password' => $request->password];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            return redirect()->route('home');
        }else{
            return back()->withErrors([
                'email' => 'Email ou mot de passe est incorrect. '
            ])->onlyInput('email');
        }
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return to_route('showLogin');
    }

}
