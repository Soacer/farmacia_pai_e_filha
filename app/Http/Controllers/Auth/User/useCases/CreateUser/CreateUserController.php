<?php

namespace App\Http\Controllers\Auth\User\useCases\CreateUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CreateUserController extends Controller
{
    #[OA\Post(
        path: '/users/create-user',
        summary: 'Cadastrar novo usuário',
        tags: ['users'],
        responses: [
            new OA\Response(
                response: 201, 
                description: 'Usuário criado com sucesso'
            ),
            new OA\Response(
                response: 422, 
                description: 'Dados inválidos'
            )
        ]
    )]
    public function createUser(Request $req)
    {
        echo 'entrou no createUserController';
    }

    private function insert(Request $req) {

    }
}
