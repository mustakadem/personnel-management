<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employed extends Model
{
    protected $table = 'employed';
    protected $fillable = ['idDepartament','name','surnames','address','postcode','email','movil','image','lasted_job','lasted_studies','job_position','departament'];
}