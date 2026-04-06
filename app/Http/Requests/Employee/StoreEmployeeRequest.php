<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

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
            'pis' => 'nullable|string|max:11',
            'job_title' => 'required|string|max:100',
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