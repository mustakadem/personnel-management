<?php
 namespace App\Controllers;


 use App\Controllers\Auth\AuthController;
 use App\Controllers\Auth\RegisterController;
 use App\Models\User;

 class UserController extends BaseController {

     /**
      * Ruta [GET] user/home donde se muestra la página de inicio del usuario.
      * @return string Render para cargar la web
      */
     public function getHome(){
         return $this->render('user/homeUser.twig',[]);
     }


     /**
      * Ruta [GET] user/login donde se crea un AuthController.
      * @return string Devuelve el metodo getLogin del AuthController.
      */
     public function getLogin(){
         $auth = new AuthController();

         return $auth->getLogin();
     }
     /**
      * Ruta [POST] user/login donde se crea un AuthController.
      * @return string Devuelve el metodo postLogin del AuthController.
      */
     public function postLogin(){
         $auth = new AuthController();

         return $auth->postLogin();
     }

     /**
      * Ruta [GET] user/registro donde se crea un AuthController.
      * @return string Devuelve el metodo getRegister del AuthController.
      */
     public function getRegistro(){
         $register = new RegisterController();

         return $register->getRegister();
     }

     /**
      * Ruta [POST] user/registro donde se crea un AuthController.
      * @return string Devuelve el metodo postRegister del AuthController.
      */
     public function postRegistro(){
         $register = new RegisterController();

         return $register->postRegister();
     }

     /**
      * Ruta [GET] user/logout donde se crea un AuthController.
      * @return string Devuelve el metodo getLogout del AuthController.
      */
     public function getLogout(){
         $auth = new AuthController();

         return $auth->getLogout();
     }

     /**
      * Ruta [GET] user/conf Muestra la pagina de configuracion del usuario
      * @return string Render con la informacion de la web
      */
     public function getConf(){

         $info=[
             'subtitle' => 'Edit user configurations',
             'submit' => 'CONF'
         ];
        if ($_SESSION['userId']) {
            $user = User::find($_SESSION['userId']);
        }else{
            header('Location:'.BASE_URL);
        }


         return $this->render('user/configurations.twig',[
             'info' => $info,
             'user' => $user
         ]);
     }
 }