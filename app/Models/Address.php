<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'idCustomer',
        'idEmployee',
        'idSupplier',
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    /**
     * Relacionamento: O endereço pertence a um Cliente
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'idCustomer');
    }

    /**
     * Relacionamento: O endereço pertence a um Funcionário
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'idEmployee');
    }

    /**
     * Relacionamento: O endereço pertence a um Cliente
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'idSupplier');
    }

    /**
     * Accessor: Retorna o endereço formatado de forma legível
     * Exemplo de uso: $address->full_address
     */
    public function getFullAddressAttribute(): string
    {
        $comp = $this->complement ? " - {$this->complement}" : '';

        return "{$this->street}, {$this->number}{$comp}, {$this->neighborhood}, {$this->city}/{$this->state}";
    }

    protected function zipCode(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }
}
