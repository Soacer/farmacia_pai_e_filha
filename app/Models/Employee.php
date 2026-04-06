<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    // No Employee.php, adicione o relacionamento:
    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'idOccupation');
    }

    // Atualize o $fillable:
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
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    // Mutator para Telefone
    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
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
}
