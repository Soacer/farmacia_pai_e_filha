<?php

namespace App\Models;

use App\Traits\HasUuid;
use OpenApi\Attributes as OA;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
#[OA\Schema(
    schema: "User",
    title: "Usuário",
    description: "Modelo de usuário para autenticação",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "7c9e1234-5678-90ab-cdef-1234567890ab"),
        new OA\Property(property: "name", type: "string", example: "Administrador"),
        new OA\Property(property: "email", type: "string", format: "email", example: "admin@admin.com"),
        new OA\Property(property: "idRoles", type: "integer", description: "ID do cargo", example: 1),
        new OA\Property(property: "isActive", type: "boolean", example: true)
    ]
)]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuid, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

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
            'password' => 'hashed',
            'isActive' => 'boolean',
        ];
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'idUsers');
    }
}
