<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Models\Supplier;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class SupplierController extends Controller
{
    #[OA\Get(
        path: '/supplier/supplier-form',
        summary: 'Exibe o formulário de cadastro de fornecedores',
        tags: ['Fornecedores'],
        responses: [
            new OA\Response(response: 200, description: 'Visualização HTML carregada')
        ]
    )]
    public function showCreateSupplierForm()
    {
        return view('supplier.create_supplier');
    }

    #[OA\Get(
        path: '/suppliers/list',
        summary: 'Lista todos os fornecedores cadastrados',
        description: 'Retorna a view com a listagem de fornecedores ordenada por nome e com endereços carregados.',
        tags: ['Fornecedores'],
        responses: [
            new OA\Response(response: 200, description: 'Lista carregada com sucesso')
        ]
    )]
    public function showAllSuppliers()
    {
        $suppliers = Supplier::with('addresses')->orderBy('company_name', 'asc')->get();
        return view('supplier.supplier_list', compact('suppliers'));
    }

    #[OA\Post(
        path: '/supplier/store-supplier',
        summary: 'Cadastra um fornecedor e seu endereço',
        description: 'Cria o registro do fornecedor e o endereço vinculado em uma transação única.',
        tags: ['Fornecedores'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['cnpj', 'company_name', 'phone', 'zip_code', 'street', 'number'],
                properties: [
                    // Fornecedor
                    new OA\Property(property: 'cnpj', type: 'string', example: '12.345.678/0001-99'),
                    new OA\Property(property: 'company_name', type: 'string', example: 'Distribuidora Exemplo LTDA'),
                    new OA\Property(property: 'trade_name', type: 'string', example: 'Farma Distribuidora'),
                    new OA\Property(property: 'contact_name', type: 'string', example: 'Carlos Silva'),
                    new OA\Property(property: 'phone', type: 'string', example: '71988887777'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'vendas@exemplo.com'),
                    new OA\Property(property: 'state_registration', type: 'string', example: '123456789'),
                    // Endereço
                    new OA\Property(property: 'zip_code', type: 'string', example: '41000-000'),
                    new OA\Property(property: 'street', type: 'string', example: 'Avenida Sete de Setembro'),
                    new OA\Property(property: 'number', type: 'string', example: '100'),
                    new OA\Property(property: 'neighborhood', type: 'string', example: 'Centro'),
                    new OA\Property(property: 'city', type: 'string', example: 'Salvador'),
                    new OA\Property(property: 'state', type: 'string', example: 'BA')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Fornecedor criado com sucesso'),
            new OA\Response(response: 422, description: 'Erro de validação nos dados enviados')
        ]
    )]
    public function createSupplier(StoreSupplierRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $supplier = Supplier::updateOrCreate(
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

                $supplier->addresses()->create($request->only([
                    'zip_code', 'street', 'number', 'complement', 'neighborhood', 'city', 'state'
                ]));

                return redirect()->route('all_suppliers')->with('success', 'Fornecedor cadastrado com sucesso!');
            });
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar fornecedor: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Erro ao salvar.');
        }
    }

    #[OA\Put(
        path: '/supplier/update/{id}',
        summary: 'Atualiza dados cadastrais e endereço do fornecedor',
        tags: ['Fornecedores'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID (UUID) do fornecedor',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'company_name', type: 'string'),
                    new OA\Property(property: 'phone', type: 'string'),
                    new OA\Property(property: 'idAddress', type: 'string', format: 'uuid', description: 'ID do endereço para atualização'),
                    new OA\Property(property: 'street', type: 'string'),
                    new OA\Property(property: 'city', type: 'string')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Dados atualizados com sucesso'),
            new OA\Response(response: 404, description: 'Fornecedor não encontrado')
        ]
    )]
    public function updateSupplier(Request $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $supplier = Supplier::findOrFail($id);
                
                // Atualiza Fornecedor
                $supplier->update($request->only([
                    'company_name', 'trade_name', 'email', 'phone', 'contact_name', 'state_registration'
                ]));

                // Atualiza Endereço vinculado
                if ($request->filled('idAddress')) {
                    $address = Address::findOrFail($request->idAddress);
                    $address->update($request->only([
                        'zip_code', 'street', 'number', 'complement', 'neighborhood', 'city', 'state'
                    ]));
                }

                return redirect()->back()->with('success', 'Fornecedor atualizado com sucesso!');
            });
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar fornecedor: '.$e->getMessage());
            return redirect()->back()->with('error', 'Erro ao processar atualização.');
        }
    }

    #[OA\Patch(
        path: '/supplier/deactivate/{id}',
        summary: 'Inativa ou reativa um fornecedor (Soft Delete)',
        description: 'Alterna o status isActive do fornecedor entre ativo e inativo.',
        tags: ['Fornecedores'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID (UUID) do fornecedor',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Status alterado com sucesso'),
            new OA\Response(response: 404, description: 'Fornecedor não encontrado')
        ]
    )]
    public function deactivateSupplier($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->isActive = !$supplier->isActive;
            $supplier->save();

            $msg = $supplier->isActive ? 'reativado' : 'inativado';
            return redirect()->back()->with('success', "Fornecedor {$msg} com sucesso!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar status.');
        }
    }
}