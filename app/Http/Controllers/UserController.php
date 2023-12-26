<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $newUser = User::create($data);

        auth()->login($newUser);

        return redirect(route('index'));
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route(
            'index'
        ));
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        if (auth()->attempt($data)) {
            $request->session()->regenerate();

            return redirect(route('index'));
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
