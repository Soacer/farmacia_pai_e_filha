<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use OpenApi\Attributes as OA;
use App\Traits\HasUuid;
#[OA\Schema(
    schema: "Role",
    title: "Permissão",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "f47ac10b-58cc-4372-a567-0e02b2c3d479"),
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
