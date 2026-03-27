<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Category',
    title: 'Categoria de Medicamento',
    description: 'Classes e subclasses terapêuticas',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'class', type: 'string', example: 'Sistema Nervoso'),
        new OA\Property(property: 'subclass', type: 'string', example: 'Analgésicos'),
        new OA\Property(property: 'isActive', type: 'boolean', example: true),
    ]
)]
class Category extends Model
{
    use HasFactory;

    // O Laravel já entende que o plural de Category é categories,
    // mas deixamos explícito por segurança.
    protected $table = 'categories';

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
