<?php

namespace App\Actions\Auth;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    /**
     * Create a new class instance.
     */
    public function execute($credentials)
    {
        //
        return Auth::attempt($credentials);
    }
}
