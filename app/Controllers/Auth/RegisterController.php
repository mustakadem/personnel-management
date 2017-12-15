<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\User;
use Sirius\Validation\Validator;

class RegisterController extends BaseController
{
    /**
     * Ruta [GET] user/registro Se carga el formulario del registro.
     * @return string Render con la info de la web
     */
    public function getRegister(){
        $info=[
            'method' => 'POST',
            'subtitle'=> 'Register',
            'title'=> 'Register',
            'submit' => 'Registrarse'
        ];
        return $this-> render('user/register.twig',['info'=>$info]);
    }

    /**
     * Ruta [POST] user/registro Se recoje el formulario del registro y si es correcto se crea la sesion del usuario
     * y se redirecciona a la pagina user/home.
     * @return string Render con los errores de la validacion del formulario.
     */
    public function postRegister(){
        $info=[
            'method' => 'POST',
            'subtitle'=> 'Register',
            'title'=> 'Register',
            'submit' => 'Registrarse'
        ];
        $errors = [];
        $validator = new Validator();

        $data['name']=$_POST['userName'];
        $data['email'] =$_POST['userEmail'];

        $validator->add('userName:Name', 'required', [], 'El {label} es obligatorio');
        $validator->add('userName:Nombre', 'minlength', ['min' => 5], 'El {label} debe tener al menos 5 caracteres');
        $validator->add('userEmail:Email', 'required', [], 'El {label} es obligatorio');
        $validator->add('userEmail:Email', 'email', [], 'No es un email válido');
        $validator->add('userPass:Password', 'required', [], 'La {label} es requerida');
        $validator->add('userPass:Password', 'minlength', ['min' => 8], 'La {label} debe tener al menos 8 caracteres');
        $validator->add('userPass2:Password', 'required', [], 'La {label} es requerida');
        $validator->add('userPass2:Password', 'match', 'userPass', 'Las passwords deben coincidir');

        if($validator->validate($_POST)){
            $user = new User();

            $user->name = $_POST['userName'];
            $user->email = $_POST['userEmail'];
            $user->password = password_hash($_POST['userPass'], PASSWORD_DEFAULT);

            $user->save();


            $_SESSION['userId']= $user->id;
            $_SESSION['userName']= $user->name;
            $_SESSION['userEmail']=$user->email;

            header('Location: /user/home');
        }else{
            $errors = $validator->getMessages();
        }

        return $this->render('user/register.twig', ['errors' => $errors,'info' => $info, 'data' => $data]);
    }

}