<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Role",
    title: "Permissão",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "roles", type: "string", example: "employee")
    ]
)]
class Role extends Model
{
    use hasFactory, Notifiable;    

    protected $hidden = [
        'roles'
    ];
}
