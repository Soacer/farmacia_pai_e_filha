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
use Illuminate\Support\Facades\Storage;
// Para Manipular Imagens
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(
        path: '/product/{id}',
        summary: 'Exibe os detalhes de um produto específico',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Retorna a view de detalhes do produto'),
            new OA\Response(response: 404, description: 'Produto não encontrado')
        ]
    )]
    public function showProductById($id)
    {

        $product = Product::with(['category', 'batch'])->findOrFail($id);
        $categories = Category::where('isActive', true)->get();
        $suppliers = Supplier::where('isActive', true)->get();

        return view('product.show_product', compact('product', 'categories', 'suppliers'));
    }

    #[OA\Get(
        path: '/product/all-products',
        summary: 'Lista todos os produtos com paginação e ordenação',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(name: 'per_page', in: 'query', description: 'Quantidade de itens (10, 15, 20, 25, 30)', required: false, schema: new OA\Schema(type: 'integer', default: 10)),
            new OA\Parameter(name: 'page', in: 'query', description: 'Número da página', required: false, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Retorna a view do estoque de produtos')
        ]
    )]
    public function showAllProducts(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        if (! in_array($perPage, [10, 15, 20, 25, 30])) {
            $perPage = 10;
        }

        $products = Product::query()
            ->join('categories', 'products.idCategory', '=', 'categories.id')
            ->select('products.*') // Importante para não sobrescrever o ID do produto com o da categoria
            ->with(['category', 'batch'])
            ->orderBy('categories.class', 'asc')     // 1º Ordem Alfabética da Categoria
            ->orderBy('categories.subclass', 'asc')  // 2º Ordem Alfabética da Subcategoria
            ->orderBy('products.name', 'asc')        // 3º Ordem Alfabética do Nome
            ->paginate($perPage);

        $products->appends(['per_page' => $perPage]);

        $categories = Category::where('isActive', true)->get();
        $suppliers = Supplier::where('isActive', true)->get();

        return view('product.product_stock', compact('products', 'categories', 'suppliers', 'perPage'));
    }

    #[OA\Get(
        path: '/product/create',
        summary: 'Exibe o formulário de cadastro de novo produto',
        tags: ['Products'],
        responses: [
            new OA\Response(response: 200, description: 'Retorna a view de criação')
        ]
    )]
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
        $imagePath = null;
        if ($request->hasFile('image_product')) {
            $file = $request->file('image_product');

            // Inicia o gerenciador de imagens
            $manager = new ImageManager(new Driver);

            // Lê a imagem do upload
            $image = $manager->read($file->getRealPath());

            // Redimensiona e corta para preencher 800x800 (sem distorcer)
            // Se a imagem for retangular, ele corta as sobras.
            $image->cover(800, 800);

            // Converte para WebP com 80% de qualidade
            $encoded = $image->toWebp(80);

            // Define o nome sempre com extensão .webp
            $filename = hexdec(uniqid()).'.webp';
            $path = 'products/'.$filename;

            // Salva
            Storage::disk('public')->put($path, $encoded->toString());

            $imagePath = $path;

        }
        try {
            return DB::transaction(function () use ($request, $imagePath) {
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
                        'image_path' => $imagePath,
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
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'idCategory', type: 'integer'),
                        new OA\Property(property: 'price', type: 'string'),
                        new OA\Property(property: 'image_product', type: 'string', format: 'binary'),
                        new OA\Property(property: 'quantity_now', type: 'integer'),
                        new OA\Property(property: 'idBatch', type: 'string', format: 'uuid')
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Produto atualizado com sucesso'),
            new OA\Response(response: 404, description: 'Produto não encontrado')
        ]
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

            if ($request->hasFile('image_product')) {
                if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                    Storage::disk('public')->delete($product->image_path);
                }

                $file = $request->file('image_product');
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->cover(800, 800);
                $encoded = $image->toWebp(80);

                $filename = hexdec(uniqid()).'.webp';
                $path = 'products/'.$filename;

                Storage::disk('public')->put($path, $encoded->toString());

                $productData['image_path'] = $path;
            }

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
        tags: ['Products'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Status alterado com sucesso'),
            new OA\Response(response: 404, description: 'Produto não encontrado')
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
