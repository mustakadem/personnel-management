<?php

namespace App\Controllers;

use App\Models\Employed;
use Sirius\Validation\Validator;

class EmployedController extends BaseController
{


    public function getHome()
    {
        return $this->render('user/homeUser.twig', []);
    }

    public function getList()
    {
        $employed = Employed::query()->orderBy('id', 'desc')->get();

        return $this->render('employed/listEmployed.twig', [
            'employed' => $employed
        ]);
    }


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
        $employed = array_fill_keys(["name", "surnames", "address", "postcode", "email", "movil", "lasted_studies", "lasted_job", "job_position", "time", "image"], "");
        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    public function postAdd()
    {
        $info = [
            'title' => 'Add',
            'subtitle' => 'Add New Employed',
            'submit' => 'Add Employed',
            'method' => 'POST'
        ];
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
            $validator->add('employedDepartament:Departamento', 'required', [], $requiredFileMessageError);
            $validator->add('employedTime:Turno', 'required', [], $requiredFileMessageError);

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
            $employed['departament'] = htmlspecialchars(trim($_POST['employedDepartament']));
            $employed['time'] = htmlspecialchars(trim($_POST['employedTime']));
            $employed['image'] = htmlspecialchars(trim($_POST['employedImage']));

            //Compruebo si tengo errores de validacion y si no los tengo entro en este if y guardo e la BD.

            if ($validator->validate($_POST)) {
                $employed = new Employed([
                    'name' => $employed['name'],
                    'surnames' => $employed['surnames'],
                    'address' => $employed['address'],
                    'postcode' => $employed['postcode'],
                    'email' => $employed['email'],
                    'movil' => $employed['movil'],
                    'lasted_studies' => $employed['lasted_studies'],
                    'lasted_job' => $employed['lasted_job'],
                    'job_position' => $employed['job_position'],
                    'time' => $employed['time'],
                    'image' => $employed['image'],
                ]);
                //Guardo en la BD
                $employed->save();

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: homeUser.twig');
            } else {

                $errors = $validator->getMessages();
            }
        }

        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'errors' => $errors,
            'info' => $info
        ]);

    }

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

        if (!$employed) {
            header('Location: homeUser.twig');
        }

        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'errors' => $errors,
            'info' => $info
        ]);
    }

    public function putEdit($id)
    {
        $info = [
            'title'        => 'Update',
            'subtitle' => 'Update Employed',
            'submit'    => 'update',
            'method'    => 'PUT'
        ];

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
            $validator->add('employedDepartament:Departamento', 'required', [], $requiredFileMessageError);
            $validator->add('employedTime:Turno', 'required', [], $requiredFileMessageError);

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
            $employed['departament'] = htmlspecialchars(trim($_POST['employedDepartament']));
            $employed['time'] = htmlspecialchars(trim($_POST['employedTime']));
            $employed['image'] = htmlspecialchars(trim($_POST['employedImage']));

            //Compruebo si tengo errores de validacion y si no los tengo entro en este if y guardo e la BD.

            if ($validator->validate($_POST)) {
                $employed = Employed::where('id', $id)->update([
                    'id' => $employed['id'],
                    'name' => $employed['name'],
                    'surnames' => $employed['surnames'],
                    'address' => $employed['address'],
                    'postcode' => $employed['postcode'],
                    'email' => $employed['email'],
                    'movil' => $employed['movil'],
                    'lasted_studies' => $employed['lasted_studies'],
                    'lasted_job' => $employed['lasted_job'],
                    'job_position' => $employed['job_position'],
                    'time' => $employed['time'],
                    'image' => $employed['image'],
                ]);

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: '. BASE_URL);
            } else {

                $errors = $validator->getMessages();
            }
        }

        return $this->render('employed/formEmployed.twig', [
            'employed' => $employed,
            'errors' => $errors,
            'info' => $info
        ]);
    }


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

    public function deleteDlt()
    {
        $id = $_REQUEST['id'];


        $employed = Employed::destroy($id);

        header("Location: " . BASE_URL);
    }

    public function postSearch(){

        $name= $_REQUEST['userNameSearch'];

        $employed = Employed::where('name',$name)->get();


         if (!$employed){
             return $this->render('employed/listEmployed.twig',[]);
         }

         return $this->render('employed/listEmployed.twig',[
             'employed' => $employed
         ]);
    }

}
