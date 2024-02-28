<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            return redirect()->route('items.index');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        if(Auth::check())
        {
            return redirect()->route('items.index');
        }

        $validated = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if( Auth::attempt($validated) )
        {
            return redirect()->route('items.index');
        };

        return redirect()->route('login')->withErrors(['login' => 'Ошибка входа']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');;
    }
}
