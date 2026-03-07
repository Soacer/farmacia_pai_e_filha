<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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