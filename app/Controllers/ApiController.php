<?php
namespace App\Controllers;

use App\Models\Employed;

class ApiController{


    public function getEmployed($id = null){
        if (is_null($id)) {
            $employed = Employed::all();

            header('Content-Type: application/json');
            return json_encode($employed);
        } else {
            $employed = Employed::find($id);

            header('Content-Type: application/json');
            return json_encode($employed);
        }
    }
}