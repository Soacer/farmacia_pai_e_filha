<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Employee",
    title: "Funcionário",
    description: "Modelo de representação detalhada de um funcionário da farmácia",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "7c9e1234-5678-90ab-cdef-1234567890ab"),
        new OA\Property(property: "idUsers", type: "string", format: "uuid", description: "ID do usuário vinculado para login", example: "550e8400-e29b-41d4-a716-446655440000"),
        new OA\Property(property: "idOccupations", type: "string", format: "uuid", description: "ID do cargo/ocupação", example: "f47ac10b-58cc-4372-a567-0e02b2c3d479"),
        new OA\Property(property: "cpf", type: "string", description: "CPF (apenas números)", example: "12345678901"),
        new OA\Property(property: "rg", type: "string", description: "RG (apenas números)", example: "123456789"),
        new OA\Property(property: "phone", type: "string", description: "Telefone com DDD", example: "71988887777"),
        new OA\Property(property: "birth_date", type: "string", format: "date", example: "1998-03-14"),
        new OA\Property(property: "gender", type: "string", description: "Gênero (M, F, Outro)", example: "M"),
        new OA\Property(property: "salary", type: "number", format: "float", example: 3500.50),
        new OA\Property(property: "hire_date", type: "string", format: "date", example: "2026-01-02"),
        new OA\Property(property: "resignation_date", type: "string", format: "date", nullable: true, example: null),
        new OA\Property(property: "pis", type: "string", description: "Número do PIS", example: "12012345678"),
        new OA\Property(property: "ctps", type: "string", description: "Carteira de Trabalho", example: "12345670001"),
        new OA\Property(property: "crf", type: "string", nullable: true, description: "Conselho Regional de Farmácia (obrigatório para farmacêuticos)", example: "12345/BA"),
        new OA\Property(property: "isActive", type: "boolean", example: true)
    ]
)]
class Employee extends Model
{
    use SoftDeletes;
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'idUsers',
        'idOccupations',
        'cpf',
        'rg',
        'phone',
        'birth_date',
        'gender',
        'salary',
        'hire_date',
        'resignation_date',
        'pis',
        'ctps',
        'crf',
        'isActive',
    ];

    // Mutator para CPF
    protected function cpf(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value ? preg_replace('/[^0-9]/', '', $value) : null,
        );
    }

    // Mutator para Telefone
    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value ? preg_replace('/[^0-9]/', '', $value) : null,
        );
    }

    // Mutator para PIS
    protected function pis(): Attribute
    {
        return Attribute::make(
            // Adicione a "?" antes de string e verifique se existe valor antes do preg_replace
            set: fn (?string $value) => $value ? preg_replace('/[^0-9]/', '', $value) : null,
        );
    }

    // Mutator para rg
    protected function rg(): Attribute
    {
        return Attribute::make(
            // Adicione a "?" antes de string e verifique se existe valor antes do preg_replace
            set: fn (?string $value) => $value ? preg_replace('/[^0-9]/', '', $value) : null,
        );
    }

    // Mutator para ctps
    protected function ctps(): Attribute
    {
        return Attribute::make(
            // Adicione a "?" antes de string e verifique se existe valor antes do preg_replace
            set: fn (?string $value) => $value ? preg_replace('/[^0-9]/', '', $value) : null,
        );
    }

    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class, 'idUsers');
    }

    public function address()
    {
        // Retorna apenas um objeto de endereço
        return $this->hasOne(Address::class, 'idEmployee');
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'idOccupations');
    }
}
