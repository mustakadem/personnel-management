<?php

namespace App\Controllers;

use App\Models\Employed;
use App\Models\Departament;
use Sirius\Validation\Validator;

class EmployedController extends BaseController
{

    /**
     * Ruta [GET] /employed/list Muestra en una tabla todos los employeds.
     * @return string Render de la web con toda la información.
     */
    public function getList()
    {
        $employed = Employed::query()->orderBy('id', 'desc')->get();

        return $this->render('employed/listEmployed.twig', [
            'employed' => $employed
        ]);
    }

    /**
     *Ruta [GET] /employed/add muestra el formulario para añadir un nuevo employed.
     *
     * @return string Render de la web con toda la información.
     */
    public function getAdd()
    {
        $info = [
            'title' => 'Add',
            'subtitle' => 'Add New Employed',
            'submit' => 'Add Employed',
            'method' => 'POST'
        ];

        $errors = array();
        // En employed se crea un array asociativo con las siquientes keys .
        $employed = array_fill_keys(["name", "surnames", "address", "postcode", "email", "movil", "idDepartament","lasted_studies", "lasted_job", "job_position", "image","departament"], "");

        //En esta variable se guardan todos los departamentos para generar el select en la vista
        $departaments = Departament::query()->orderBy('id', 'desc')->get();

        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'departaments' => $departaments,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    /**
     * Ruta [POST] /employed/add recoge y valida los datos del formulario para añadir un nuevo employed.
     * @return string Render con la informacion de errores.
     */
    public function postAdd()
    {
        $info = [
            'title' => 'Add',
            'subtitle' => 'Add New Employed',
            'submit' => 'Add Employed',
            'method' => 'POST'
        ];
        $departaments = Departament::query()->orderBy('id', 'desc')->get();

        if (!empty($_POST)) {
            //Validamos los errores

            $validator = new Validator();

            $requiredFileMessageError = "El {label} es requerido";
            $validator->add('employedName:Nombre', 'required', [], $requiredFileMessageError);
            $validator->add('employedSurnames:Apellidos', 'required', [], $requiredFileMessageError);
            $validator->add('employedAddress:Direccion', 'required', [], $requiredFileMessageError);
            $validator->add('employedPostcode:Codigo Postal', 'required', [], $requiredFileMessageError);
            $validator->add('employedEmail:Email', 'required', [], $requiredFileMessageError);
            $validator->add('employedMovil:Movil', 'required', [], $requiredFileMessageError);
            $validator->add('employedJobPosition:Posicion de Trabajo', 'required', [], $requiredFileMessageError);
            $validator->add('selectDepartament:Departamento', 'required', [], $requiredFileMessageError);

            //Aqui guardaremos cada valor recuperado del POST
            $employed['name'] = htmlspecialchars(trim($_POST['employedName']));
            $employed['surnames'] = htmlspecialchars(trim($_POST['employedSurnames']));
            $employed['address'] = htmlspecialchars(trim($_POST['employedAddress']));
            $employed['postcode'] = htmlspecialchars(trim($_POST['employedPostcode']));
            $employed['email'] = htmlspecialchars(trim($_POST['employedEmail']));
            $employed['movil'] = htmlspecialchars(trim($_POST['employedMovil']));
            $employed['lasted_studies'] = htmlspecialchars(trim($_POST['employedLastedStudies']));
            $employed['lasted_job'] = htmlspecialchars(trim($_POST['employedLatestJob']));
            $employed['job_position'] = htmlspecialchars(trim($_POST['employedJobPosition']));
            $employed['idDepartament'] = htmlspecialchars(trim($_POST['selectDepartament']));
            $employed['image'] = htmlspecialchars(trim($_POST['employedImage']));

            $idDepartament= $employed['idDepartament'];
            $departament= Departament::find($idDepartament);

            //Compruebo si tengo errores de validacion y si no los tengo entro en este if y guardo e la BD.
            if ($validator->validate($_POST)) {

                //Guardo en la BD
                $employed = new Employed([
                    'name' => $employed['name'],
                    'surnames' => $employed['surnames'],
                    'address' => $employed['address'],
                    'postcode' => $employed['postcode'],
                    'email' => $employed['email'],
                    'movil' => $employed['movil'],
                    'idDepartament' =>   $employed['idDepartament'],
                    'lasted_studies' => $employed['lasted_studies'],
                    'lasted_job' => $employed['lasted_job'],
                    'job_position' => $employed['job_position'],
                    'image' => $employed['image'],
                    'departament' => $departament['name']
                ]);

                $employed->save();
                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: /employed/list');
            } else {

                $errors = $validator->getMessages();
            }
        }

        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'errors' => $errors,
            'departaments' => $departaments,
            'info' => $info
        ]);

    }

    /**
     * Ruta [GET] /employed/edit Muestra el mismo formulario que /employed/add pero con los campos rellenados con los datos
     * del employed a editar.
     * @param $id int La funcion esta esperando el id del employed
     * @return string Render de la web con toda la información del employed.
     */
    public function getEdit($id)
    {
        $info = [
            'title' => 'Update',
            'subtitle' => 'Update Employed',
            'submit' => 'update',
            'method' => 'PUT'
        ];
        $errors = array();

        $employed = Employed::find($id);
        $departaments = Departament::query()->orderBy('id', 'desc')->get();
        if (!$employed) {
            header('Location: employed/employedList.twig');
        }

        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'departaments' => $departaments,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    /**
     * Ruta [PUT] /employed/edit Recoje los datos para actualizar el employed y devuelve el formulario si hay errores.
     * @param $id int La funcion esta esperando el id del employed.
     * @return string Render de la web con toda la información del employed.
     */
    public function putEdit($id)
    {
        $info = [
            'title'        => 'Update',
            'subtitle' => 'Update Employed',
            'submit'    => 'update',
            'method'    => 'PUT'
        ];
        $departaments = Departament::query()->orderBy('id', 'desc')->get();


        $errors = array();

        if (!empty($_POST)) {
            //Validamos los errores

            $validator = new Validator();

            $requiredFileMessageError = "El {label} es requerido";
            $validator->add('employedName:Nombre', 'required', [], $requiredFileMessageError);
            $validator->add('employedSurnames:Apellidos', 'required', [], $requiredFileMessageError);
            $validator->add('employedAddress:Direccion', 'required', [], $requiredFileMessageError);
            $validator->add('employedPostcode:Codigo Postal', 'required', [], $requiredFileMessageError);
            $validator->add('employedEmail:Email', 'required', [], $requiredFileMessageError);
            $validator->add('employedMovil:Movil', 'required', [], $requiredFileMessageError);
            $validator->add('employedJobPosition:Posicion de Trabajo', 'required', [], $requiredFileMessageError);
            $validator->add('selectDepartament:Departamento', 'required', [], $requiredFileMessageError);

            //Aqui guardaremos cada valor recuperado del POST
            $employed['id'] = $id;
            $employed['name'] = htmlspecialchars(trim($_POST['employedName']));
            $employed['surnames'] = htmlspecialchars(trim($_POST['employedSurnames']));
            $employed['address'] = htmlspecialchars(trim($_POST['employedAddress']));
            $employed['postcode'] = htmlspecialchars(trim($_POST['employedPostcode']));
            $employed['email'] = htmlspecialchars(trim($_POST['employedEmail']));
            $employed['movil'] = htmlspecialchars(trim($_POST['employedMovil']));
            $employed['lasted_studies'] = htmlspecialchars(trim($_POST['employedLastedStudies']));
            $employed['lasted_job'] = htmlspecialchars(trim($_POST['employedLatestJob']));
            $employed['job_position'] = htmlspecialchars(trim($_POST['employedJobPosition']));
            $employed['idDepartament'] = htmlspecialchars(trim($_POST['selectDepartament']));
            $employed['image'] = htmlspecialchars(trim($_POST['employedImage']));

            $idDepartament= $employed['idDepartament'];
            $departament= Departament::find($idDepartament);

            echo 'paso 1';
            //Compruebo si tengo errores de validacion y si no los tengo entro en este if y guardo e la BD.
            if ($validator->validate($_POST)) {
                $employed = Employed::where('id', $id)->update([
                    'id' => $employed['id'],
                    'name' => $employed['name'],
                    'surnames' => $employed['surnames'],
                    'address' => $employed['address'],
                    'postcode' => $employed['postcode'],
                    'email' => $employed['email'],
                    'idDepartament' => $employed['idDepartament'],
                    'movil' => $employed['movil'],
                    'lasted_studies' => $employed['lasted_studies'],
                    'lasted_job' => $employed['lasted_job'],
                    'job_position' => $employed['job_position'],
                    'image' => $employed['image'],
                    'departament' => $departament['name']
                ]);

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: /employed/list');
            } else {

                $errors = $validator->getMessages();
            }
        }

        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'departaments' => $departaments,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    /**
     *  Ruta [GET] /employed/index/ Muestra toda la informacion en una vista detalle del employed
     * @param $id int La funcion esta esperando el id del employed.
     * @return string  Render de la web con toda la información del employed.
     */
    public function getIndex($id)
    {


        $employed = Employed::find($id);

        $nameComplet = $employed['name'] . " " . $employed['surnames'];
        $address = $employed['address'] . ",  CP " . $employed['postcode'];
        if (!$employed) {
            return $this->render('listEmployed.twig', []);
        }

        return $this->render('employed/employed.twig', [
            'employed' => $employed,
            'nameComplet' => $nameComplet,
            'address' => $address
        ]);
    }

    /**
     * Ruta [DELETE] /employed/dlt Borra un employed recogiendo el id de un input hidden.
     */
    public function deleteDlt()
    {
        $id = $_REQUEST['id'];
        $employed = Employed::destroy($id);
        header("Location: /employed/list");
    }

    /**
     * Ruta [POST] /employed/search Busca todos los empleados que cumplan con la condicion name recogido del input.
     * @return string Render de la web con la informacion de los employed encontrados o un 404 si no hay ninguno
     */
    public function postSearch(){
        $info = [
            'error' => 'El usuario no existe',
            'submitRedirect' => 'Volver a la lista de empleados',
            'url' => 'employed/list'
        ];

        $name= $_REQUEST['userNameSearch'];

        $employed = Employed::where('name',$name)->get();


         if (isset($employed)){
             return $this->render('layout404.twig',['info' =>  $info]);
         }

         return $this->render('employed/listEmployed.twig',[
             'employed' => $employed
         ]);
    }

}
