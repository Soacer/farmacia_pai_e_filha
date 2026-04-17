<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Supplier",
    title: "Fornecedor",
    description: "Modelo de representação de fornecedores de medicamentos e insumos",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "3f9e4567-e89b-12d3-a456-426614174000"),
        new OA\Property(property: "company_name", type: "string", description: "Razão Social da empresa", example: "Distribuidora de Medicamentos Bahia Ltda"),
        new OA\Property(property: "trade_name", type: "string", description: "Nome Fantasia", example: "Dismed Salvador"),
        new OA\Property(property: "cnpj", type: "string", description: "CNPJ (apenas números)", example: "12345678000199"),
        new OA\Property(property: "contact_name", type: "string", description: "Nome da pessoa de contato no fornecedor", example: "Ricardo Oliveira"),
        new OA\Property(property: "phone", type: "string", description: "Telefone comercial (apenas números)", example: "7133445566"),
        new OA\Property(property: "state_registration", type: "string", description: "Inscrição Estadual", example: "123456789"),
        new OA\Property(property: "email", type: "string", format: "email", example: "contato@dismedsalvador.com.br"),
        new OA\Property(property: "isActive", type: "boolean", example: true)
    ]
)]
class Supplier extends Model
{
    use SoftDeletes;
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'company_name', 'trade_name', 'cnpj', 'contact_name', 
        'phone', 'state_registration', 'email', 'isActive'
    ];

    // Mutator para CNPJ (Limpa pontos, barras e traços)
    protected function cnpj(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    // Mutator para Telefone
    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    public function addresses()
    {
        // Retorna uma coleção (array) de endereços
        return $this->hasMany(Address::class, 'idSupplier');
    }
}