<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employed
 * @package App\Models  para hacer referencia a la tabla employed y permitir manipular solo los datos que necesitamos
 */
class Employed extends Model
{
    protected $table = 'employed';
    protected $fillable = ['idDepartament','name','surnames','address','postcode','email','movil','image','lasted_job','lasted_studies','job_position','departament'];
}