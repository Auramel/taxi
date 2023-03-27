<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(Request $request): View
    {
        return view('auth.login');
    }

    public function login_(Request $request): RedirectResponse
    {
        $password = $request->get('password');

        if ($password === env('PASSWORD')) {
            $request->getSession()->set('user', true);
            return redirect()->route('users.list');
        }

        return redirect()->route('auth.login');
    }
}
