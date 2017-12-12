<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\User;
use Sirius\Validation\Validator;

class AuthController extends BaseController{

    public function getLogin(){
        $info=[
            'method' => 'POST',
            'subtitle'=> 'Login',
            'title'=> 'Login',
            'submit' => 'Entrar'
        ];

        return $this->render('user/login.twig',['info'=> $info]);
    }

    public function postLogin(){
        $info=[
            'method' => 'POST',
            'subtitle'=> 'Login',
            'title'=> 'Login',
            'submit' => 'Entrar'
        ];

        $passInput= htmlspecialchars(trim($_POST['userPass']));
        echo "paso 1";
        $validador = new Validator();

        $validador->add('userEmail','required',[],'El campo Email es Requerido');
        $validador->add('userEmail','email',[],'No es un email correcto');
        $validador->add('userPass','required',[],'El campo Password es Requerido');

        if ($validador->validate($_POST)){
            echo "paso 2";
            $user = User::where('email',$_POST['userEmail'])->first();
            if (password_verify($passInput,$user->password)){
                echo "paso 3";
                $_SESSION['userId']= $user->id;
                $_SESSION['userName']= $user->name;
                $_SESSION['userEmail']=$user->email;

                header('Location: home');
            }

            $validador->addMessage('authError','Los datos son incorrectos');
        }

        $errors= $validador->getMessages();

        return $this->render('user/login.twig',[
            'info' => $info,
            'errors' => $errors
        ]);

    }

    public function getLogout(){

        unset($_SESSION['userId']);
        unset($_SESSION['userName']);
        unset($_SESSION['userEmail']);

        header("Location: ". BASE_URL);
    }


}