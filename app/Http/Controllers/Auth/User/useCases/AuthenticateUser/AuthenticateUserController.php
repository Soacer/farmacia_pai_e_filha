<?php

namespace App\Http\Controllers\Auth\User\useCases\AuthenticateUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticateUserController extends Controller
{
    //
    public function authenticateUser(Request $req, AuthenticateUserUseCase $AuthenticateUserUseCase)
    {
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            $autenticado = $AuthenticateUserUseCase->execute($credentials);
            if ($autenticado) {
                return redirect()->intended(route('dashboard'));
            }
            return back()->withErrors(
                ['email' => 'As credenciais fornecidas estão incorretas.']
            );
        } catch (\Exception $e) {
            return back()->withErrors(
                ['error' => 'Ocorreu um erro ao tentar autenticar. Por favor, tente novamente.']
            );
        }
    }
}
