<?php

namespace App\Http\Controllers;

use App\Models\User;

class LoginController extends Controller
{
    public function authenticate()
    {
        // Not wanting to spend so much time on the authentication, just mocking for now
        auth()->login($user = User::latest()->first());
        return $user;
    }

    public function user()
    {
        return auth()->user();
    }

    public function logout()
    {
        auth()->logout();
    }
}
