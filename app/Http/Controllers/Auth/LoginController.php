<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthenticateUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Auth;

#[OA\Tag(name: 'Autenticação', description: 'Endpoints de acesso')]
class LoginController extends Controller
{
    #[OA\Get(
        path: '/login/auth',
        summary: 'Exibe o formulário de login',
        tags: ['Autenticação'],
        responses: [new OA\Response(response: 200, description: 'OK')]
    )]
    public function showLoginForm(){
        return view('login');
    }

    #[OA\Get(
        path: '/user/dashboard',
        summary: 'Exibe o Dashboard',
        tags: ['Painel'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Dados do Dashboard carregados',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
        ]
    )]
    public function showDashboard(){
        return view('dashboard');
    }

    #[OA\Post(
        path: '/login/auth',
        summary: 'Realiza a autenticação',
        tags: ['Autenticação'],
        responses: [new OA\Response(response: 302, description: 'Redirecionamento')]
    )]
    public function authenticate(Request $request, AuthenticateUser $action){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($action->execute($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->idRoles == 3) {
                return redirect('/');
            }
            
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'As credenciais estão incorretas.']);
    }

    #[OA\Post(
        path: '/logout',
        summary: 'Encerra a sessão do usuário e invalida o token',
        tags: ['Autenticação'],
        responses: [
            new OA\Response(
                response: 302, 
                description: 'Logout realizado com sucesso, redireciona para a home'
            )
        ]
    )]
    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();

        return redirect('/');
    }
}
