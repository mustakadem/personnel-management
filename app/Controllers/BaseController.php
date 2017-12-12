<?php

namespace App\Controllers;


class BaseController
{
    public $templateEngine;

    public function __construct()
    {
// Inicializar motor de template
        $loader = new \Twig_Loader_Filesystem('../views');
        $this->templateEngine = new \Twig_Environment($loader, [
            'debug' => true,
            'cache' => false
        ]);


        $this->templateEngine->addGlobal('session', $_SESSION);
        // Extender Twig
        // Filtros: toman una cadena y la modifican
        $this->templateEngine->addFilter(new \Twig_SimpleFilter('url', function ($path) {
            return BASE_URL . $path;
        }));

        /**
         * codigo que genera select de Departamentos
         *
         */
        $this->templateEngine->addFunction(new \Twig_Function('generateSelectDepartament', function ($valor, $seleccionado,$value) {

                $selected = "";
               if ($valor === $seleccionado) $selected = " selected";
                $salida = "<option value=\"{$value}\"{$selected}>{$valor}</option>";

            return $salida;
        }, ['is_safe' => ['html']]));


        // Función que genera el código de los alerts
        $this->templateEngine->addFunction(new \Twig_Function('generateAlert', function ($errors, $field){
            // Si hay errores en ese campo:
            if( isset($errors[$field]) ){
                // Se crea un string con la lista de errores
                $errorList = '';
                foreach ($errors[$field] as $error) {
                    $errorList .= "{$error}<br>";
                }

                // Y se inserta dicha lista en un bloque alert (ver documentación bootstrap 3.3.7)
                // El alert se carga con sintaxis nowdoc. Para más info:
                // http://php.net/manual/es/language.types.string.php#language.types.string.syntax.nowdoc
                $alert = <<<ALERT
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{$errorList}</strong>
                </div>
ALERT;
            }else{
                $alert = null;
            }

            return $alert;
        }, ['is_safe' => ['html']]));
    }

    public function render($fileName, $data)
    {
        return $this->templateEngine->render($fileName, $data);
    }


}