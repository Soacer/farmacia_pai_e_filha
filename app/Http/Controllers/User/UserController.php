<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    //
    #[OA\Post(
        path: '/login/cadastro',
        summary: 'Registra um novo cliente no sistema',
        tags: ['Autenticação'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'password_confirmation'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Alisson Rodrigo'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'alisson@email.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: '12345678'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: '12345678'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 302, description: 'Usuário criado e redirecionado para a home'),
            new OA\Response(response: 422, description: 'Erro de validação nos dados enviados'),
        ]
    )]
    public function createUser(StoreCustomerRequest $request)
    {
        try {
            //dd($request);
            // Garante que as duas tabelas sejam preenchidas
            return DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'isActive' => 1,
                    'idRoles' => 3, //Forçado como Cliente (Customer)
                ]);
                Customer::create([
                    'name' => $request->name,
                    'cpf' => $request->cpf,
                    'phone' => $request->phone,
                    'idUsers' => $user->id,
                ]);

                return redirect()->route('login')->with('success', 'Conta criada com sucesso!');
            });
        } catch (\Exception $e) {
            // Mostra o erro
            dd($e);
            Log::error('Erro ao criar cliente: '.$e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Ops! Ocorreu um erro interno ao salvar.'); // Mantém o que o usuário digitou no form
        }
    }

    #[OA\Get(
        path: '/user/cadastro',
        summary: 'Exibe a página de cadastro de novos clientes',
        description: 'Retorna a interface HTML do formulário de registro para clientes (IdRoles = 3).',
        operationId: 'showRegistrationForm',
        tags: ['Público / Autenticação'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Página de cadastro carregada com sucesso.',
                content: new OA\MediaType(
                    mediaType: 'text/html'
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Erro interno no servidor ao carregar a view.'
            )
        ]
    )]
    public function showRegistrationForm()
    {
        return view('cadastro');
    }
}
