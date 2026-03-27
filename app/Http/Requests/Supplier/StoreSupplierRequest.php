<?php

namespace App\Http\Requests\Supplier; // Verifique se o 'Supplier' está aqui

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Limpa os dados antes da validação (essencial para Salvador!)
    protected function prepareForValidation()
    {
        $this->merge([
            'cnpj'  => preg_replace('/[^0-9]/', '', $this->cnpj),
            'phone' => preg_replace('/[^0-9]/', '', $this->phone),
        ]);
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'trade_name'   => 'nullable|string|max:255',
            'cnpj'         => 'required|string|size:14|unique:suppliers,cnpj',
            'email'        => 'required|email|unique:suppliers,email',
            'phone'        => 'required|string|between:10,11',
            'state_registration' => 'nullable|string|max:20',
            'contact_name' => 'nullable|string|max:100',
        ];
    }
}