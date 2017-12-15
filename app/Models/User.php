<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models  para hacer referencia a la tabla user y permitir manipular solo los datos que necesitamos
 */
class User extends Model{
    protected $table="user";
    protected $fillable=['name','email','password'];
}