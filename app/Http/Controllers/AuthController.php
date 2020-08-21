<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $data= $request->validate([
            'username'=> 'required|string|max:100',
            'email'=> 'required|email|unique:users,email|max:100',
            'password'=> 'required|string|max:100|min:6',
            
        ]);
        $data['password']= Hash::make($data['password']);

        $user = User::create([
            'username'=> $data['username'],
            'email'=> $data['email'],
            'password'=> $data['password'],
            'api_token'=>Str::random(64)
        ]);
        Auth::login($user);

        return redirect(route('books.index'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $data= $request->validate([
            'email'=> 'required|email|max:100',
            'password'=> 'required|string|max:100|min:6',
        ]);
        
        if(! Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
        {
            return redirect(route('auth.login'));
        }

        return redirect(route('books.index'));

    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('auth.login'));
    }
}
