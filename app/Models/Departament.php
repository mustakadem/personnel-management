<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Departament
 * @package App\Models para hacer referencia a la tabla departament y permitir manipular solo los datos que necesitamos
 */
class Departament extends Model{
    protected $table = 'departament';
    protected $fillable = ['name','type','plant'];
}