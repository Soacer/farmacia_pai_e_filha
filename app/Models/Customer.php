<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;
use App\Traits\HasUuid;
#[OA\Schema(
    schema: 'Customer',
    title: 'Cliente/Funcionário',
    description: 'Estrutura de dados para cadastro de pessoas',
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "7c9e1234-5678-90ab-cdef-1234567890ab"),
        new OA\Property(property: 'name', type: 'string', example: 'Maria Souza'),
        new OA\Property(property: 'cpf', type: 'string', example: '000.000.000-00'),
        new OA\Property(property: 'phone', type: 'string', example: '71999998888'),
        new OA\Property(property: 'email', type: 'string', example: 'maria@farmacia.com'),
        new OA\Property(property: 'address', type: 'string', example: 'Rua Principal, 123'),
    ]
)]
class Customer extends Model
{
    use HasFactory;
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'customers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'cpf',
        'phone',
        'birth_date',
        'idUsers',
    ];

    protected function cpf(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    // O Laravel já gerencia created_at e updated_at automaticamente,
    // então não precisamos colocá-los no $fillable.
    public function addresses()
    {
        // Retorna uma coleção (array) de endereços
        return $this->hasMany(Address::class, 'idCustomer');
    }
}
