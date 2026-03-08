<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Customer",
    title: "Cliente/Funcionário",
    description: "Estrutura de dados para cadastro de pessoas",
    properties: [
        new OA\Property(property: "idCustomers", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Maria Souza"),
        new OA\Property(property: "cpf", type: "string", example: "000.000.000-00"),
        new OA\Property(property: "phone", type: "string", example: "71999998888"),
        new OA\Property(property: "email", type: "string", example: "maria@farmacia.com"),
        new OA\Property(property: "address", type: "string", example: "Rua Principal, 123")
    ]
)]
class Customer extends Model
{
    use HasFactory;

    // Define o nome da tabela conforme a imagem
    protected $table = 'customers';

    // Como sua chave primária é 'idCustomers', precisamos avisar o Laravel
    protected $primaryKey = 'idCustomers';

    // Campos que podem ser preenchidos em massa (Mass Assignment)
    protected $fillable = [
        'name',
        'cpf',
        'phone',
        'email',
        'address',
    ];

    // O Laravel já gerencia created_at e updated_at automaticamente, 
    // então não precisamos colocá-los no $fillable.
}