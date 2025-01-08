<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $users = session('users', []);

        if (isset($users[$request->username]) && $users[$request->username]['password'] === $request->password) {
            session(['user' => ['username' => $request->username, 'is_login' => true]]);
            return redirect('/profile')->with('success', 'Login berhasil!');
        }

        return redirect('login')->with('error', 'Username atau password salah!');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $data = $request->only('username', 'password');

        $users = session('users', []);

        $users[$data['username']] = [
            'password' => $data['password'],
        ];

        session(['users' => $users]);

        return redirect('login')->with('success', 'Registration Successful!');
    }

    public function showProfile()
    {
        return view('profile');
    }
}
