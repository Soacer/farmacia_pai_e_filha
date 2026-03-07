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
        parameters: [
            new OA\Parameter(
                name: 'name',
                in: 'query',
                description: 'Nome do usuário',
                required: true,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'email',
                in: 'query',
                description: 'Email do usuário',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'email')
            ),
            new OA\Parameter(
                name: 'password',
                in: 'query',
                description: 'Senha do usuário',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'password')
            ),
            new OA\Parameter(
                name: 'idRoles',
                in: 'query',
                description: 'Role do usuário',
                required: true,
                schema: new OA\Schema(type: 'foreignId', format: 'number')
            )
        ],
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
