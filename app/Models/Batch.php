<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Batch extends Model
{
    use SoftDeletes;

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