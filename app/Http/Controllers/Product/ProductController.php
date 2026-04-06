<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    public function showAllProducts()
    {
        $products = Product::with(['category', 'batch'])->get();
        // Adicione estas duas linhas:
        $categories = Category::where('isActive', true)->get();
        $suppliers = Supplier::where('isActive', true)->get();

        return view('product.product_stock', compact('products', 'categories', 'suppliers'));
    }

    public function showCreateProductForm()
    {
        $categories = Category::where('isActive', true)->get();
        $suppliers = Supplier::where('isActive', true)->get();

        return view('product.create_product', compact('categories', 'suppliers'));
    }

    #[OA\Post(
        path: '/create-product',
        summary: 'Cria um produto e opcionalmente fornecedor/lote',
        description: 'Registra o produto e, se solicitado, cria o fornecedor com endereço e o primeiro lote.',
        tags: ['Products'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['idCategory', 'name', 'price', 'barcode'],
                properties: [
                    // Dados do Produto
                    new OA\Property(property: 'idCategory', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Dipirona 500mg'),
                    new OA\Property(property: 'barcode', type: 'string', example: '7891234567890'),
                    new OA\Property(property: 'price', type: 'string', example: '15,50'),
                    new OA\Property(property: 'min_stock_alert', type: 'integer', example: 10),

                    // Toggle de Novo Fornecedor
                    new OA\Property(property: 'novoFornecedor', type: 'boolean', example: true),
                    new OA\Property(property: 'cnpj', type: 'string', example: '12345678000199'),

                    // Dados de Endereço (Para Novo Fornecedor)
                    new OA\Property(property: 'zip_code', type: 'string', example: '41000000'),
                    new OA\Property(property: 'street', type: 'string', example: 'Avenida Sete de Setembro'),
                    new OA\Property(property: 'number', type: 'string', example: '100'),
                    new OA\Property(property: 'neighborhood', type: 'string', example: 'Centro'),
                    new OA\Property(property: 'city', type: 'string', example: 'Salvador'),
                    new OA\Property(property: 'state', type: 'string', example: 'BA'),

                    // Dados de Lote (Batch)
                    new OA\Property(property: 'batch_code', type: 'string', example: 'LOT-2026-X'),
                    new OA\Property(property: 'quantity', type: 'integer', example: 100),
                    new OA\Property(property: 'expiration_date', type: 'string', format: 'date', example: '2028-12-31'),
                    new OA\Property(property: 'cost_price', type: 'string', example: '5,50'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Sucesso'),
            new OA\Response(response: 500, description: 'Erro Interno'),
        ]
    )]
    public function createProduct(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $supplierId = $request->idSupplier;

                if ($request->novoFornecedor && $request->filled('cnpj')) {
                    $newSupplier = Supplier::updateOrCreate(
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

                    $newSupplier->addresses()->create([
                        'zip_code' => $request->zip_code,
                        'street' => $request->street,
                        'number' => $request->number,
                        'neighborhood' => $request->neighborhood,
                        'city' => $request->city ?? 'Salvador',
                        'state' => $request->state ?? 'BA',
                    ]);

                    $supplierId = $newSupplier->id;
                }

                $product = Product::updateOrCreate(
                    ['barcode' => $request->barcode],
                    [
                        'idCategory' => $request->idCategory,
                        'name' => $request->name,
                        'description' => $request->description,
                        'active_principle' => $request->active_principle,
                        'isActive' => true,
                        'requires_prescription' => $request->requires_prescription ?? false,
                        'price' => str_replace(',', '.', $request->price),
                        'min_stock_alert' => $request->min_stock_alert,
                    ]
                );

                if ($request->filled('batch_code') && $request->filled('expiration_date')) {
                    Batch::create([
                        'idProducts' => $product->id,
                        'idSuppliers' => $supplierId, // Amarra ao fornecedor resolvido no passo 1
                        'batch_code' => $request->batch_code,
                        'manufacturing_date' => $request->manufacturing_date,
                        'expiration_date' => $request->expiration_date,
                        'quantity' => $request->quantity,
                        'quantity_now' => $request->quantity, // No início, saldo = entrada
                        'cost_price' => str_replace(',', '.', $request->cost_price),
                    ]);
                }

                return redirect()->back()->with('success', 'Produto cadastrado!');
            });
        } catch (\Exception $e) {
            Log::error('Erro ao criar produto: '.$e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Não foi possível cadastrar: '.$e->getMessage());
        }
    }

    #[OA\Put(
        path: '/product/update/{id}',
        summary: 'Atualiza produto e lote simultaneamente',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'idCategory', type: 'integer'),
                    new OA\Property(property: 'barcode', type: 'string'),
                    new OA\Property(property: 'active_principle', type: 'string'),
                    new OA\Property(property: 'price', type: 'string'),
                    new OA\Property(property: 'batch_code', type: 'string'),
                    new OA\Property(property: 'quantity_now', type: 'integer'),
                    new OA\Property(property: 'idSupplier', type: 'integer'),
                ]
            )
        ),
        responses: [new OA\Response(response: 200, description: 'Sucesso')]
    )]
    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $productData = [
                'name' => $request->name,
                'idCategory' => $request->idCategory,
                'barcode' => $request->barcode,
                'active_principle' => $request->active_principle,
                'description' => $request->description,
                'requires_prescription' => $request->has('requires_prescription'),
            ];

            if ($request->filled('min_stock_alert')) {
                $productData['min_stock_alert'] = $request->min_stock_alert;
            }

            if ($request->filled('price')) {
                $cleanPrice = str_replace(['.', ','], ['', '.'], $request->price);
                $productData['price'] = $cleanPrice;
            }

            $product->update($productData);

            if ($request->filled('idBatch')) {
                $batch = Batch::findOrFail($request->idBatch);

                $batchData = [
                    'batch_code' => $request->batch_code,
                    'expiration_date' => $request->expiration_date,
                    'idSuppliers' => $request->idSupplier,
                ];

                if ($request->filled('quantity_now')) {
                    $batchData['quantity_now'] = $request->quantity_now;
                }

                $batch->update($batchData);
            }

            return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar: '.$e->getMessage());
        }
    }

    #[OA\Patch(
        path: '/product/deactivate/{id}',
        summary: 'Inativa ou reativa um produto (Soft Delete)',
        description: 'Alterna o status do atributo isActive. Se o produto estiver ativo (true), ele passará a ser inativo (false) e vice-versa.',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID numérico do produto a ter o status alterado',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 2)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Status do produto alterado com sucesso'
            ),
            new OA\Response(
                response: 404,
                description: 'Produto não encontrado'
            ),
            new OA\Response(
                response: 500,
                description: 'Erro interno ao processar a alteração'
            )
        ]
    )]
    public function deactivateProduct($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Inverte o status atual: se 1 vira 0, se 0 vira 1
            $product->isActive = ! $product->isActive;
            $product->save();

            $status = $product->isActive ? 'reativado' : 'inativado';

            return redirect()->back()->with('success', "Produto {$status} com sucesso!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar status do produto.');
        }
    }
}
