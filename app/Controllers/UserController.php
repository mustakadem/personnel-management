<?php
 namespace App\Controllers;
 use App\Controllers\Auth\AuthController;
 use App\Controllers\Auth\RegisterController;
 use App\Models\User;

 class UserController extends BaseController{

     public function getHome(){
         return $this->render('user/homeUser.twig',[]);
     }

     public function getLogin(){
         $auth = new AuthController();

         return $auth->getLogin();
     }

     public function postLogin(){
         $auth = new AuthController();

         return $auth->postLogin();
     }

     public function getRegistro(){
         $register = new RegisterController();

         return $register->getRegister();
     }

     public function postRegistro(){
         $register = new RegisterController();

         return $register->postRegister();
     }
 }