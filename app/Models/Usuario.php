<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    const SALT = 'ClaveSegura';

    use HasFactory;

    public function getKeyName(){
        return 'cod_usuario';
    }

    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }

    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }
}
