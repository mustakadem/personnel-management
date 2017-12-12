<?php
namespace App\Controllers;


class HomeController extends BaseController {
    /**
     * Ruta / donde se muestra la página de inicio del proyecto.
     *
     * @return string Render de la página
     */
    public function getIndex(){
        return $this->render('home.twig',[]);
    }

}
