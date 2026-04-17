<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\HasUuid;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Address",
    title: "Endereço",
    description: "Modelo de representação de endereços para clientes, funcionários ou fornecedores",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "7c9e1234-5678-90ab-cdef-1234567890ab"),
        new OA\Property(property: "idCustomer", type: "string", format: "uuid", nullable: true, description: "ID do Cliente associado", example: "f47ac10b-58cc-4372-a567-0e02b2c3d479"),
        new OA\Property(property: "idEmployee", type: "string", format: "uuid", nullable: true, description: "ID do Funcionário associado", example: null),
        new OA\Property(property: "idSupplier", type: "string", format: "uuid", nullable: true, description: "ID do Fornecedor associado", example: null),
        new OA\Property(property: "zip_code", type: "string", description: "CEP (apenas números devido ao cast do Model)", example: "41000000"),
        new OA\Property(property: "street", type: "string", example: "Avenida Sete de Setembro"),
        new OA\Property(property: "number", type: "string", example: "100"),
        new OA\Property(property: "complement", type: "string", nullable: true, example: "Apartamento 201"),
        new OA\Property(property: "neighborhood", type: "string", example: "Centro"),
        new OA\Property(property: "city", type: "string", example: "Salvador"),
        new OA\Property(property: "state", type: "string", maxLength: 2, example: "BA")
    ]
)]
class Address extends Model
{
    use HasFactory;
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;

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
