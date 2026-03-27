<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'idUsers', 
        'cpf', 
        'phone', 
        'birth_date', 
        'salary', 
        'hire_date', 
        'pis', 
        'job_title', 
        'isActive'
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
}