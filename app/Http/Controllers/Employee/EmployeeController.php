<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Occupation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class EmployeeController extends Controller
{
    
    #[OA\Put(
        path: '/employees/{id}',
        summary: 'Atualiza os dados de um funcionário',
        tags: ['Funcionários'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID (UUID) do funcionário',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'idOccupation', type: 'integer', example: 1),
                    new OA\Property(property: 'cpf', type: 'string', example: '123.456.789-01'),
                    new OA\Property(property: 'phone', type: 'string', example: '71988887777'),
                    new OA\Property(property: 'salary', type: 'number', format: 'float', example: 2500.50),
                    new OA\Property(property: 'isActive', type: 'boolean', example: true),
                    new OA\Property(property: 'hire_date', type: 'string', format: 'date'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Atualizado com sucesso'),
            new OA\Response(response: 404, description: 'Funcionário não encontrado')
        ]
    )]
    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $employeeData = [
                'idUsers' => $employee->idUsers,
                'idOccupations' => $request->idOccupation,
                'cpf' => $request->cpf,
                'rg' => $request->rg,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'salary' => $request->salary,
                'hire_date' => $request->hire_date,
                'resignation_date' => $request->resignation_date,
                'pis' => $request->pis,
                'ctps' => $request->ctps,
                'crf' => $request->crf,
                'isActive' => $request->isActive,
            ];

            $employee->update($employeeData);

            return redirect()->back()->with('success', 'Funcionário atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar: '.$e->getMessage());
        }
    }

    #[OA\Patch(
        path: '/employees/{id}/deactivate',
        summary: 'Ativa ou desativa um funcionário (Toggle status)',
        description: 'Inverte o status atual do funcionário.',
        tags: ['Funcionários'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID (UUID) do funcionário',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid')
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Status alterado com sucesso'),
            new OA\Response(response: 404, description: 'Funcionário não encontrado'),
            new OA\Response(response: 500, description: 'Erro interno')
        ]
    )]
    public function deactivateEmployee($id)
    {
        try {
            $employee = Employee::findOrFail($id);

            // Inverte o status atual: se 1 vira 0, se 0 vira 1
            $employee->isActive = ! $employee->isActive;
            $employee->save();

            $status = $employee->isActive ? 'reativado' : 'inativado';

            return redirect()->back()->with('success', "Funcionário {$status} com sucesso!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar status do funcionário.');
        }
    }

    #[OA\Get(
        path: '/employee/create',
        summary: 'Exibe o formulário de cadastro de funcionários',
        tags: ['Funcionários'],
        responses: [new OA\Response(response: 200, description: 'Retorna a View HTML')]
    )]
    public function showCreateForm()
    {
        $occupations = Occupation::where('isActive', true)->get();

        return view('employee.create_employee', compact('occupations'));
    }

    #[OA\Post(
        path: '/employee/store',
        summary: 'Cadastra um novo funcionário completo',
        description: 'Cria User (Role 2), Employee e Address em uma transação única.',
        tags: ['Funcionários'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'cpf', 'idOccupation'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'João Silva'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'joao@farmacia.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password'),
                    new OA\Property(property: 'idOccupation', type: 'integer', example: 1),
                    new OA\Property(property: 'cpf', type: 'string', example: '000.000.000-00'),
                    new OA\Property(property: 'zip_code', type: 'string', example: '41000-000'),
                    new OA\Property(property: 'street', type: 'string', example: 'Rua Exemplo'),
                    new OA\Property(property: 'number', type: 'string', example: '123')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Criado com sucesso'),
            new OA\Response(response: 422, description: 'Erro de validação')
        ]
    )]
    public function store(StoreEmployeeRequest $request)
    {
        // dd($request->all());
        try {
            return DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'idRoles' => 2, // Default: Funcionário
                ]);

                $employee = $user->employee()->create([
                    'idOccupations' => $request->idOccupation, // FK correta
                    'cpf' => $request->cpf,
                    'rg' => $request->rg,
                    'phone' => $request->phone,
                    'birth_date' => $request->birth_date,
                    'gender' => $request->gender,
                    'salary' => $request->salary,
                    'hire_date' => $request->hire_date,
                    'pis' => $request->pis,
                    'ctps' => $request->ctps,
                    'crf' => $request->crf,
                    'isActive' => true,
                ]);

                $employee->address()->create($request->only([
                    'zip_code', 'street', 'number', 'complement', 'neighborhood', 'city', 'state',
                ]));

                return redirect()->route('all_employees')->with('success', 'Funcionário cadastrado com sucesso!');
            });
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar funcionário: '.$e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Erro técnico ao salvar funcionário: '.$e->getMessage());
        }
    }

    #[OA\Get(
        path: '/employee/list',
        summary: 'Lista todos os funcionários cadastrados',
        tags: ['Funcionários'],
        responses: [
            new OA\Response(
                response: 200, 
                description: 'Retorna a view com a listagem completa'
            )
        ]
    )]
    public function showAllEmployees()
    {
        $employees = Employee::with(['user', 'address'])->get();
        $occupations = Occupation::where('isActive', true)->get();
        return view('employee.employee_list', compact('employees', 'occupations'));
    }
}
