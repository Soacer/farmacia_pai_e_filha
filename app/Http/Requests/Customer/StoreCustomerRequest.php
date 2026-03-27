<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\User\StoreUserRequest;

class StoreCustomerRequest extends StoreUserRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userRules = parent::rules(); // Recebendo as regras de User
        $customerRules = [
            'cpf' => 'required|string|max:14|unique:customers,cpf',
            'phone' => 'required|string|max:45',
            'birth_date' => 'required|date|before:today',
        ];

        return array_merge($userRules, $customerRules);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
            'phone' => preg_replace('/[^0-9]/', '', $this->phone),
        ]);
    }

    /*
    protected function prepareForValidation()
    {
        // Se o código chegar aqui, o CSRF PASSOU, mas a validação ainda não começou.
        dd('O CSRF funcionou! Cheguei no Request.', $this->all());
    }
    */
}
