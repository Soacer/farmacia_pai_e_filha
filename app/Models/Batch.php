<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasUuid;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Batch",
    title: "Lote",
    description: "Representa a entrada física de um produto no estoque, controlando validade e preço de custo",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "7c9e1234-5678-90ab-cdef-1234567890ab"),
        new OA\Property(property: "idProducts", type: "string", format: "uuid", description: "ID do produto vinculado a este lote", example: "550e8400-e29b-41d4-a716-446655440000"),
        new OA\Property(property: "idSuppliers", type: "string", format: "uuid", description: "ID do fornecedor que entregou este lote", example: "f47ac10b-58cc-4372-a567-0e02b2c3d479"),
        new OA\Property(property: "batch_code", type: "string", description: "Código de identificação do lote (impresso na embalagem)", example: "LOT-2026-X12"),
        new OA\Property(property: "manufacturing_date", type: "string", format: "date", nullable: true, example: "2025-01-20"),
        new OA\Property(property: "expiration_date", type: "string", format: "date", description: "Data de validade do lote", example: "2028-12-31"),
        new OA\Property(property: "quantity", type: "integer", description: "Quantidade total que entrou no estoque", example: 100),
        new OA\Property(property: "quantity_now", type: "integer", description: "Quantidade que ainda resta disponível para venda", example: 85),
        new OA\Property(property: "cost_price", type: "number", format: "float", description: "Preço de custo unitário do item no momento da entrada", example: 5.50)
    ]
)]
class Batch extends Model
{
    use SoftDeletes;
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'idProducts',
        'idSuppliers',
        'batch_code',
        'manufacturing_date',
        'expiration_date',
        'quantity',
        'quantity_now',
        'cost_price'
    ];

    /**
     * Relação com o Produto
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'idProducts');
    }

    /**
     * Relação com o Fornecedor
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'idSuppliers');
    }
}