<?php

namespace App\Controllers;

use App\Models\Departament;
use App\Models\Employed;
use App\Models\User;
use Sirius\Validation\Validator;

class DepartamentController extends BaseController
{

    /**
     *Ruta [GET] /departament/add muestra el formulario para añadir un nuevo departamento.
     *
     * @return string Render de la web con toda la información.
     */
    public function getAdd()
    {
        $info = [
            'title' => 'Add Departament',
            'subtitle' => 'Add New Departament',
            'submit' => 'Add Departament',
            'method' => 'POST'
        ];

        $errors = array();

        /**
         * Se crea un array asociativo sin valores
         */
        $departament = array_fill_keys(["name", "type", "plant"], "");
        /**
         * Se crea un array de los tipos de departamentos
         */
        $types = ['stewardship', 'marketing', 'accounting', 'Human Resources'];

        return $this->render('departament/formDepartament.twig', [
            'types' => $types,
            'departament' => $departament,
            'errors' => $errors,
            'info' => $info
        ]);

    }

    /**
     * Ruta [POST] /departament/add recoge y valida los datos del formulario para añadir un nuevo departamento.
     * @return string Render con la informacion de errores.
     */
    public function postAdd()
    {
        $info = [
            'title' => 'Add Departament',
            'subtitle' => 'Add New Departament',
            'submit' => 'Add Departament',
            'method' => 'POST'
        ];
        $types = ['stewardship', 'marketing', 'accounting', 'Human Resources'];
        if (!empty($_POST)) {

            //Validamos los errores

            $validator = new Validator();

            $requiredFileMessageError = "El Campo {label} es requerido";
            $validator->add('departamentName:Nombre', 'required', [], $requiredFileMessageError);
            $validator->add('departamentPlant:Plant', 'required', [], $requiredFileMessageError);
            if ($_POST['departamentType'] == "Select") {
                $validator->add('departamentType:Type', 'required', [], $requiredFileMessageError);
            }
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
                header('Location: list');
            } else {

                $errors = $validator->getMessages();
            }
        }
        return $this->render('departament/formDepartament.twig', [
            'types' => $types,
            'departament' => $departament,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    /**
     * Ruta [GET] /departament/list Muestra en una tabla todos los departamentos.
     * @return string Render de la web con toda la información.
     */
    public function getList()
    {
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

    /**
     * Ruta [GET] /departament/edit Muestra el mismo formulario que /departament/add pero con los campos rellenados con los datos
     * del departamento a editar.
     * @param $id int La funcion esta esperando el id del departamento
     * @return string Render de la web con toda la información del departamento.
     */
    public function getEdit($id)
    {
        $info = [
            'title' => 'Update',
            'subtitle' => 'Update Departament',
            'submit' => 'update',
            'method' => 'PUT'
        ];


        $errors = array();

        $departament = Departament::find($id);
        $types = ['stewardship', 'marketing', 'accounting', 'Human Resources'];

        if (!$departament) {
            header('Location: departament/list');
        }

        return $this->render('departament/formDepartament.twig', [
            'types' => $types,
            'departament' => $departament,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    /**
     * Ruta [PUT] /departament/edit Recoje los datos para actualizar el departamento y devuelve el formulario si hay errores.
     * @param $id int La funcion esta esperando el id del departamento.
     * @return string Render de la web con toda la información del departamento.
     */
    public function putEdit($id)
    {
        $info = [
            'title' => 'Update Departament',
            'subtitle' => 'Update New Departament',
            'submit' => 'Update Departament',
            'method' => 'PUT'
        ];

        $types = ['stewardship', 'marketing', 'accounting', 'Human Resources'];
        $errors = array();
        if (!empty($_POST)) {

            //Validamos los errores

            $validator = new Validator();

            $requiredFileMessageError = "El Campo {label} es requerido";
            $validator->add('departamentName:Nombre', 'required', [], $requiredFileMessageError);
            $validator->add('departamentPlant:Plant', 'required', [], $requiredFileMessageError);
            $validator->add('departamentType:Type', 'required', [], $requiredFileMessageError);


            $departament['id'] = $id;
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
                header('Location: /departament/list');
            } else {

                $errors = $validator->getMessages();
            }
        }
        return $this->render('departament/formDepartament.twig', [
            'types' => $types,
            'departament' => $departament,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    /**
     *  Ruta [GET] /departament/index/ Muestra toda la informacion en una vista detalle del departamento
     * @param $id int La funcion esta esperando el id del departamento.
     * @return string  Render de la web con toda la información del departamento.
     */
    public function getIndex($id)
    {
        $departament = Departament::find($id);

        $total = Employed::where('idDepartament', $departament['id'])->count();

        if (!$departament) {
            return $this->render('departament/listDepartament.twig', []);
        }

        return $this->render('departament/departament.twig', [
            'departament' => $departament,
            'total' => $total
        ]);
    }

    /**
     * Ruta [DELETE] /departament/dlt Borra un departamento recogiendo el id de un input hidden.
     * @return string Render de la web si el departamento contiene empleados.
     */
    public function deleteDlt()
    {
        $id = $_REQUEST['id'];
        $departament = Departament::find($id);
        /**
         * Compruebo si algun employed pertenece a un departamento y calculo el total.
         */
        $total = Employed::where('idDepartament', $departament['id'])->count();
        if ($total <= 0) {
            $departament = Departament::destroy($id);
            header("Location: /departament/list");
        } else {
            $info = [
                'error' => 'El departamento que desea borrar contiene Empleados, elimine o cambie a los empleados de departamento',
                'submitRedirect' => 'Volver a la lista de departamentos',
                'url' => 'departament/list'
            ];
           return $this->render('layout404.twig', [
                'info' => $info
            ]);
        }
    }

    /**
     * Ruta [GET] /departament/404 Esta funcion es para cargar la pagina layout404.twig
     * @return string Render de la web con la informacion del error.
     */
    public function get404()
    {
        return $this->render('layout404.twig', []);
    }


}