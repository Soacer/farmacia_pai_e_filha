<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Models\Supplier;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class SupplierController extends Controller
{
    //
    #[OA\Get(
        path: '/supplier/supplier-form',
        summary: 'Exibe o formulário de cadastro de fornecedores',
        tags: ['Fornecedores'],
        responses: [
            new OA\Response(response: 200, description: 'Visualização do formulário carregada'),
        ]
    )]
    public function showCreateSupplierForm()
    {

        return view('supplier.create_supplier');
    }

    #[OA\Post(
        path: '/supplier/store-supplier', // URL exata: prefixo + rota
        summary: 'Cadastra ou atualiza um fornecedor',
        description: 'Utiliza o CNPJ como chave única. Se o CNPJ já existir, os dados serão atualizados via updateOrCreate.',
        tags: ['Fornecedores'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['company_name', 'cnpj', 'email', 'phone'],
                properties: [
                    new OA\Property(property: 'company_name', type: 'string', example: 'Distribuidora de Medicamentos Bahia LTDA'),
                    new OA\Property(property: 'trade_name', type: 'string', example: 'Farma Distribuidora'),
                    new OA\Property(property: 'cnpj', type: 'string', example: '12.345.678/0001-99'),
                    new OA\Property(property: 'contact_name', type: 'string', example: 'Sr. João Silva'),
                    new OA\Property(property: 'phone', type: 'string', example: '7133221100'),
                    new OA\Property(property: 'state_registration', type: 'string', example: '123456789'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'contato@farmadistribuidora.com'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 302, description: 'Sucesso: Redireciona de volta com mensagem'),
            new OA\Response(response: 422, description: 'Erro: Validação falhou (StoreSupplierRequest)'),
            new OA\Response(response: 500, description: 'Erro: Falha interna no banco de dados')
        ]
    )]
    public function createSupplier(StoreSupplierRequest $request)
    {
        try {
            Supplier::updateOrCreate(
                ['cnpj' => $request->cnpj],
                [
                    'company_name' => $request->company_name,
                    'trade_name' => $request->trade_name,
                    'contact_name' => $request->contact_name,
                    'phone' => $request->phone,
                    'state_registration' => $request->state_registration,
                    'email' => $request->email,
                    'isActive' => true,
                ]
            );

            return redirect()->back()->with('success', 'Fornecedor cadastrado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar fornecedor: '.$e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Erro ao salvar fornecedor.');
        }
    }
}
