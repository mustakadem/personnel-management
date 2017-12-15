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

     public function putConf(){
         $info=[
             'subtitle' => 'Edit user configurations',
             'submit' => 'CONF',
             'method' => 'PUT'
         ];

         if (!empty($_POST)) {
             //Validamos los errores

             //Aqui guardaremos cada valor recuperado del POST
             $form['userName'] = htmlspecialchars(trim($_POST['userName']));
             $form['userEmail'] = htmlspecialchars(trim($_POST['userEmail']));
             $form['pass1']= htmlspecialchars(trim($_POST['pass1']));
             $form['pass2'] = password_hash($_POST['pass2'], PASSWORD_DEFAULT);


             //Compruebo si tengo errores de validacion y si no los tengo entro en este if y actualizo el usuario en la BD.
            // if ($validator->validate($_POST)) {
                 $user = User::where('id',$_SESSION['userId'])->first();
                 if ($form['userName']){
                     $user = User::where('id', $_SESSION['userId'])->update([
                         'id' => $_SESSION['userId'],
                         'name' => $form['userName'],
                     ]);

                     $_SESSION['userName']=$form['userName'];
                 }
                 if ($form['userEmail']){
                     $user = User::where('id', $_SESSION['userId'])->update([
                         'id' => $_SESSION['userId'],
                         'email' => $form['userEmail'],
                     ]);
                     $_SESSION['userEmail']=$form['userEmail'];
                 }
                 if (password_verify($form['pass1'],$user->password)){
                     $user = User::where('id', $_SESSION['userId'])->update([
                     'id' => $_SESSION['userId'],
                     'password' => $form['pass2']
                 ]);
                     // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio de usuario

             }
                 header('Location: /user/home');
             }

                 $errors = $validator->getMessages();

     //    }


         return $this->render('user/configurations.twig', [
             'form' => $form,
             'errors' => $errors,
             'info' => $info
         ]);

     }
 }