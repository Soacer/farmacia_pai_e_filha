<?php

namespace App\Models;

use OpenApi\Attributes as OA;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[OA\Schema(
    schema: "User",
    title: "Usuário",
    description: "Modelo de usuário para autenticação",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Administrador"),
        new OA\Property(property: "email", type: "string", format: "email", example: "admin@admin.com"),
        new OA\Property(property: "idRoles", type: "integer", description: "ID do cargo", example: 1),
        new OA\Property(property: "isActive", type: "boolean", example: true)
    ]
)]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'idRoles',
        'isActive'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }
}
