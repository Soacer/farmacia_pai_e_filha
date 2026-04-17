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
                description: 'ID do funcionário',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Atualizado com sucesso'),
            new OA\Response(response: 404, description: 'Funcionário não encontrado')
        ]
    )]
    public function update(Request $request, $id)
    {
        try {
            //dd($request->all());
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
        description: 'Inverte o status atual do funcionário: se estiver ativo, torna-o inativo e vice-versa.',
        tags: ['Funcionários'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID do funcionário',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Status alterado com sucesso'
            ),
            new OA\Response(
                response: 404,
                description: 'Funcionário não encontrado'
            ),
            new OA\Response(
                response: 500,
                description: 'Erro interno ao processar a alteração'
            ),
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
        responses: [new OA\Response(response: 200, description: 'OK')]
    )]
    public function showCreateForm()
    {
        $occupations = Occupation::where('isActive', true)->get();

        return view('employee.create_employee', compact('occupations'));
    }

    #[OA\Post(
        path: '/employee/store',
        summary: 'Cadastra um novo funcionário completo (User, Employee, Address)',
        tags: ['Funcionários'],
        responses: [new OA\Response(response: 201, description: 'Criado com sucesso')]
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
        summary: 'Lista todos os funcionários',
        tags: ['Funcionários'],
        responses: [new OA\Response(response: 200, description: 'Lista carregada')]
    )]
    public function showAllEmployees()
    {
        $employees = Employee::with(['user', 'address'])->get();
        $occupations = Occupation::where('isActive', true)->get();
        return view('employee.employee_list', compact('employees', 'occupations'));
    }
}
