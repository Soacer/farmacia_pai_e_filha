<?php

namespace App\Http\Requests\Batch;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            // Limpa o preço caso venha com vírgula para manter o padrão decimal
            'cost_price' => str_replace(',', '.', $this->cost_price),
            // Define a quantidade atual igual à inicial no momento da criação
            'quantity_now' => $this->quantity,
        ]);
    }

    public function rules(): array
    {
        return [
            'idProducts'         => 'required|exists:products,id',
            'idSuppliers'        => 'required|exists:suppliers,id',
            'batch_code'         => 'required|string|max:50',
            'manufacturing_date' => 'nullable|date',
            'expiration_date'    => 'required|date|after:manufacturing_date',
            'quantity'           => 'required|integer|min:1',
            'cost_price'         => 'required|numeric|min:0',
        ];
    }
}