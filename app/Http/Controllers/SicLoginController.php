<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SicLoginController extends Controller
{
    public function showForm()
    {
        return view('pages.sic.panel.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('sic')->attempt($credentials)) {
            session(['user_id' => Auth::guard('sic')->user()->id]);
            return redirect()->route('sic.show');
        }

        // Autenticação falhou
        return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::guard('sic')->logout();

        return redirect()->route('sic.login');
    }
}
