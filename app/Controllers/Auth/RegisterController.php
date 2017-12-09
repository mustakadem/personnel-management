<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\User;
use Sirius\Validation\Validator;

class RegisterController extends BaseController
{

    public function getRegister(){
        $info=[
            'method' => 'POST',
            'subtitle'=> 'Register',
            'title'=> 'Register',
            'submit' => 'Registrarse'
        ];
        return $this-> render('user/register.twig',['info'=>$info]);
    }

    public function postRegister(){
        $errors = [];
        $validator = new Validator();

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

            header('Location: login');
        }else{
            $errors = $validator->getMessages();
        }

        return $this->render('user/register.twig', ['errors' => $errors]);
    }

}