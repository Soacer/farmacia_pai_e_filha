<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function auth()
    {
        return view('login');
    }
    public function cadastro()
    {
        return view('cadastro');
    }
}
