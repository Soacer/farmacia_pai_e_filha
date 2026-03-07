<?php

namespace App\Http\Controllers\Auth\User\useCases\AuthenticateUser;

use Illuminate\Support\Facades\Auth;

class AuthenticateUserUseCase
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
