<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Occupation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class EmployeeController extends Controller
{
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
        try {
            return DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'idRoles' => 2, // Default: Funcionário
                ]);

                $salary = $request->salary ? str_replace(['.', ','], ['', '.'], $request->salary) : null;

                $employee = $user->employee()->create([
                    'idOccupation' => $request->idOccupation, // FK correta
                    'cpf' => $request->cpf,
                    'rg' => $request->rg,
                    'phone' => $request->phone,
                    'birth_date' => $request->birth_date,
                    'gender' => $request->gender,
                    'salary' => $salary,
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

            return redirect()->back()->withInput()->with('error', 'Erro técnico ao salvar funcionário.');
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

        return view('employee.employee_list', compact('employees'));
    }
}
