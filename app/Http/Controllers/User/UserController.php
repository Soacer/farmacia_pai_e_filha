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
        description: 'Cria simultaneamente um registro na tabela Users e na tabela Customers dentro de uma transação.',
        tags: ['Autenticação'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'password_confirmation', 'cpf', 'phone', 'birth_date'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Alisson Rodrigo'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'alisson@email.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: '12345678'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: '12345678'),
                    new OA\Property(property: 'cpf', type: 'string', example: '123.456.789-00'),
                    new OA\Property(property: 'phone', type: 'string', example: '71988887777'),
                    new OA\Property(property: 'birth_date', type: 'string', format: 'date', example: '1998-03-14'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 302, description: 'Usuário criado e redirecionado para o login'),
            new OA\Response(response: 422, description: 'Erro de validação (CPF duplicado, e-mail inválido, etc.)'),
            new OA\Response(response: 500, description: 'Erro interno ao processar a transação no banco')
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
                $customer = Customer::create([
                    'name' => $request->name,
                    'cpf' => $request->cpf,
                    'phone' => $request->phone,
                    'birth_date' => $request->birth_date,
                    'idUsers' => $user->id,
                ]);

                $customer->addresses()->create([
                    'zip_code'     => $request->zip_code,
                    'street'       => $request->street,
                    'number'       => $request->number,
                    'complement'   => $request->complement,
                    'neighborhood' => $request->neighborhood,
                    'city'         => $request->city ?? 'Salvador',
                    'state'        => $request->state ?? 'BA',
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
        return view('create_customer');
    }
}
