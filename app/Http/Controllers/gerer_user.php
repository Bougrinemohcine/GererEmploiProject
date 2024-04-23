<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class gerer_user extends Controller
{
    public function gererUser(){
        return view('gererUser');
    }
    public function updateUser(UserRequest $request,User $user){
        $formFields = $request->validated();
        $formFields['password'] = Hash::make($request->password);
        $user->fill($formFields)->save();
        return to_route('gererUser');
    }
}
