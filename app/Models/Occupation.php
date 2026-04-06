<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'requires_crf', 'isActive'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'idOccupation');
    }
}