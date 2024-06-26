<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $casts = [ 'cupo' => 'integer', 'visualizar' => 'integer' ];

    public function getKeyName(){
        return 'cod_curso';
    }
}
