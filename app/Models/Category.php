<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;
use App\Traits\HasUuid;
#[OA\Schema(
    schema: 'Category',
    title: 'Categoria de Medicamento',
    description: 'Classes e subclasses terapêuticas',
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "7c9e1234-5678-90ab-cdef-1234567890ab"),
        new OA\Property(property: 'class', type: 'string', example: 'Sistema Nervoso'),
        new OA\Property(property: 'subclass', type: 'string', example: 'Analgésicos'),
        new OA\Property(property: 'isActive', type: 'boolean', example: true),
    ]
)]
class Category extends Model
{
    use HasFactory;
    use HasUuid; // Adicione isso

    protected $keyType = 'string'; // Importante
    public $incrementing = false;  // Importante

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'class',
        'subclass',
        'isActive',
    ];

    /**
     * Garantimos que o isActive sempre retorne true/false no PHP
     */
    protected function casts(): array
    {
        return [
            'isActive' => 'boolean',
        ];
    }
}
