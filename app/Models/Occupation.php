<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Occupation",
    title: "Ocupação/Cargo",
    description: "Modelo que define os cargos dentro da farmácia e suas exigências legais",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "f47ac10b-58cc-4372-a567-0e02b2c3d479"),
        new OA\Property(property: "name", type: "string", description: "Nome do cargo", example: "Farmacêutico RT"),
        new OA\Property(property: "requires_crf", type: "boolean", description: "Indica se o cargo exige registro no Conselho Regional de Farmácia", example: true),
        new OA\Property(property: "isActive", type: "boolean", description: "Status do cargo no sistema", example: true)
    ]
)]
class Occupation extends Model
{
    use SoftDeletes;
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name', 
        'requires_crf', 
        'isActive'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'idOccupation');
    }
}