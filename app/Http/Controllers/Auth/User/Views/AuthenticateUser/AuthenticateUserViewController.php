<?php

namespace App\Http\Controllers\Auth\User\Views\AuthenticateUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticateUserViewController extends Controller
{
    //
    public function auth()
    {
        //
        return view('login');
    }

    public function cadastro()
    {
        return view('cadastro');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
