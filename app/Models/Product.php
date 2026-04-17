<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use OpenApi\Attributes as OA;
use App\Traits\HasUuid;
#[OA\Schema(
    schema: 'Product',
    title: 'Produto',
    description: 'Modelo de representação de um medicamento ou item de conveniência',
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "f47ac10b-58cc-4372-a567-0e02b2c3d479"),
        new OA\Property(property: 'idCategory', type: "string", format: "uuid", example: "f47ac10b-58cc-4372-a567-0e02b2c3d479"),
        new OA\Property(property: 'name', type: 'string', example: 'Paracetamol 500mg'),
        new OA\Property(property: 'description', type: 'string', example: 'Analgésico e antitérmico para dores leves'),
        new OA\Property(property: 'barcode', type: 'string', example: '7891234567890'),
        new OA\Property(property: 'active_principle', type: 'string', example: 'Paracetamol'),
        new OA\Property(property: 'isActive', type: 'boolean', example: false),
        new OA\Property(property: 'requires_prescription', type: 'boolean', example: false),
        new OA\Property(property: 'price', type: 'number', format: 'float', example: 15.50),
        new OA\Property(property: 'min_stock_alert', type: 'integer', example: 10),
    ]
)]
class Product extends Model
{
    use HasFactory, SoftDeletes;
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'products';

    protected $fillable = [
        'idCategory',
        'name',
        'description',
        'barcode',
        'active_principle',
        'price',
        'min_stock_alert',
        'isActive',
        'requires_prescription',
        'image_path',
    ];

    protected function imageUrl()
    {
        return Attribute::make(
            get: fn () => $this->image_path
                ? asset('storage/'.$this->image_path)
                : asset('images/placeholder-product.png'),
        );
    }

    /**
     * Casts para garantir que os dados venham nos tipos corretos no PHP
     */
    protected function casts(): array
    {
        return [
            'requires_prescription' => 'boolean',
            'isActive' => 'boolean',
            'price' => 'decimal:2',
            'min_stock_alert' => 'integer',
        ];
    }

    /**
     * Relacionamento: O Produto pertence a uma Categoria
     * (N-1)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'idCategory', 'id');
    }

    public function batch()
    {
        return $this->hasMany(Batch::class, 'idProducts');
    }
}
