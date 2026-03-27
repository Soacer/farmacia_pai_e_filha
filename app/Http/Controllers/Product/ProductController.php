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

#[OA\Info(title: 'Farmácia Pai e Filha API', version: '1.0.0')]
class ProductController extends Controller
{
    public function showAllProducts()
    {
        $products = Product::with(['category', 'batch'])->get();

        return view('product.product_stock', compact('products'));
    }

    public function showCreateProductForm()
    {
        $categories = Category::where('isActive', true)->get();
        $suppliers = Supplier::where('isActive', true)->get();

        return view('product.create_product', compact('categories', 'suppliers'));
    }

    #[OA\Post(
        path: '/create-product',
        summary: 'Cria ou recupera um produto/medicamento',
        description: 'Busca a categoria pelo nome da classe/subclasse e registra o produto se ele não existir (baseado no barcode).',
        tags: ['Products'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['class', 'subclass', 'name', 'price', 'barcode'],
                properties: [
                    new OA\Property(property: 'class', type: 'string', example: 'Sistema Nervoso e Dor'),
                    new OA\Property(property: 'subclass', type: 'string', example: 'Analgésicos e Antitérmicos'),
                    new OA\Property(property: 'name', type: 'string', example: 'Paracetamol 500mg'),
                    new OA\Property(property: 'description', type: 'string', example: 'Caixa com 20 comprimidos'),
                    new OA\Property(property: 'barcode', type: 'string', example: '7891234567890'),
                    new OA\Property(property: 'active_principle', type: 'string', example: 'Paracetamol'),
                    new OA\Property(property: 'requires_prescription', type: 'boolean', example: false),
                    new OA\Property(property: 'price', type: 'string', example: '15,50'),
                    new OA\Property(property: 'min_stock_alert', type: 'integer', example: 10),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Produto processado com sucesso'),
            new OA\Response(response: 400, description: 'Erro na validação ou categoria não encontrada'),
            new OA\Response(response: 500, description: 'Erro interno no servidor'),
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
    /*
    private function getCategoryId(string $class, string $subclass)
    {
        dump($class);
        dd($subclass);
        $category = Category::where('class', $class)->where('subclass', $subclass)->first();
        if (!$category) {
            throw new \Exception("Categoria '{$class} - {$subclass}' não encontrada.");
        }
        return $category->id;
    }
    */
}
