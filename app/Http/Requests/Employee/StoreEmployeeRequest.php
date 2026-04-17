<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation()
    {
        $this->merge([
            'cpf'    => preg_replace('/[^0-9]/', '', $this->cpf),
            'phone'  => preg_replace('/[^0-9]/', '', $this->phone),
            'pis'    => preg_replace('/[^0-9]/', '', $this->pis),
            'ctps'   => preg_replace('/[^0-9]/', '', $this->ctps),
            'rg'     => preg_replace('/[^0-9]/', '', $this->rg),
            'zip_code' => preg_replace('/[^0-9]/', '', $this->zip_code),
            // Limpa o salário para o formato decimal (ex: 1.500,00 -> 1500.00)
            'salary' => $this->salary ? str_replace(['.', ','], ['', '.'], $this->salary) : null,
        ]);
    }
    
    public function rules(): array
    {
        return [
            // User
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            // Employee
            'cpf' => 'required|string|unique:employees,cpf',
            'phone' => 'required|string',
            'birth_date' => 'required|date',
            'salary' => 'nullable|string', // Trataremos a vírgula no Controller
            'hire_date' => 'nullable|date',
            'pis' => 'nullable|string',
            'idOccupation' => 'required|exists:occupations,id',
            'gender' => 'required|in:M,F,Outro',
            // Address
            'zip_code' => 'required|string',
            'street' => 'required|string',
            'number' => 'required|string',
            'neighborhood' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string|max:2',
        ];
    }
}