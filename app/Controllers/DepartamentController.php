<?php

namespace App\Controllers;

use App\Models\Departament;
use Sirius\Validation\Validator;

class DepartamentController extends BaseController
{

    public function getAdd()
    {
        $info = [
            'title' => 'Add Departament',
            'subtitle' => 'Add New Departament',
            'submit' => 'Add Departament',
            'method' => 'POST'
        ];

        $errors = array();

        $departament = array_fill_keys(["name", "type", "plant"], "");

        return $this->render('departament/formDepartament.twig', [
            'departament' => $departament,
            'errors' => $errors,
            'info' => $info
        ]);

    }

    public function postAdd()
    {
        $info = [
            'title' => 'Add Departament',
            'subtitle' => 'Add New Departament',
            'submit' => 'Add Departament',
            'method' => 'POST'
        ];

        if (!empty($_POST)) {

            //Validamos los errores

            $validator = new Validator();

            $requiredFileMessageError = "El Campo {label} es requerido";
            $validator->add('departamentName:Nombre', 'required', [], $requiredFileMessageError);
            $validator->add('departamentPlant:Plant', 'required', [], $requiredFileMessageError);
            $validator->add('departamentType:Type', 'required', [], $requiredFileMessageError);

            $departament['name'] = htmlspecialchars(trim($_POST['departamentName']));
            $departament['plant'] = htmlspecialchars(trim($_POST['departamentPlant']));
            $departament['type'] = htmlspecialchars(trim($_POST['departamentType']));

            if ($validator->validate($_POST)) {
                $departament = new Departament([
                    'name' => $departament['name'],
                    'plant' => $departament['plant'],
                    'type' => $departament['type']
                ]);
                //Guardo en la BD
                $departament->save();

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: '. BASE_URL);
            } else {

                $errors = $validator->getMessages();
            }
        }
         return $this->render('departament/formDepartament.twig',[
             'departament' => $departament,
             'errors' => $errors,
             'info' => $info
         ]);
    }

    public function getList(){
        $info = [
            'title' => 'List Departaments',
            'subtitle' => 'List Departaments',
            'submit' => 'List',
            'method' => 'GET'
        ];

        $departaments = Departament::query()->orderBy('id', 'desc')->get();

        return $this->render('departament/listDepartament.twig', [
            'departaments' => $departaments,
            'info' => $info
        ]);
    }

    public function getEdit($id){
        $info = [
            'title' => 'Update',
            'subtitle' => 'Update Departament',
            'submit' => 'update',
            'method' => 'POST'
        ];
        $errors = array();

        $departament = Departament::find($id);

        if (!$departament) {
            header('Location: listDepartament.twig');
        }

        return $this->render('departament/formDepartament.twig', [
            'departament' => $departament,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    public function putEdit($id){
        $info = [
            'title' => 'Update Departament',
            'subtitle' => 'Update New Departament',
            'submit' => 'Update Departament',
            'method' => 'PUT'
        ];

        if (!empty($_POST)) {

            //Validamos los errores

            $validator = new Validator();

            $requiredFileMessageError = "El Campo {label} es requerido";
            $validator->add('departamentName:Nombre', 'required', [], $requiredFileMessageError);
            $validator->add('departamentPlant:Plant', 'required', [], $requiredFileMessageError);
            $validator->add('departamentType:Type', 'required', [], $requiredFileMessageError);

            $departament['id'] =$id;
            $departament['name'] = htmlspecialchars(trim($_POST['departamentName']));
            $departament['plant'] = htmlspecialchars(trim($_POST['departamentPlant']));
            $departament['type'] = htmlspecialchars(trim($_POST['departamentType']));

            if ($validator->validate($_POST)) {
                $departament = Departament::where('id', $id)->update([
                    'id' => $departament['id'],
                    'name' => $departament['name'],
                    'plant' => $departament['plant'],
                    'type' => $departament['type']
                ]);

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: '. BASE_URL);
            } else {

                $errors = $validator->getMessages();
            }
        }
        return $this->render('departament/formDepartament.twig',[
            'departament' => $departament,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    public function getIndex($id){
        $departament = Departament::find($id);

        if (!$departament) {
            return $this->render('departament/listDepartament.twig', []);
        }

        return $this->render('departament/departament.twig', [
            'departament' => $departament,
        ]);
    }

    public function deleteDlt($id){
        $departament = Departament::destroy($id);
        header("Location: " . BASE_URL);
    }


}