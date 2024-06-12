<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
    //public $timestamps = false;

    protected $casts = [ 'estado_matricula' => 'integer', 'estado_aprobacion' => 'integer' ];

    public function getKeyName(){
        return 'cod_matricula';
    }

    public function Curso()
    {
        return $this->hasOne(Curso::class, "cod_curso", "cod_curso");
    }
}
