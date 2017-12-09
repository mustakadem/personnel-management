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
            //    if (in_array($dato, $seleccionado)) $selected = " selected";
                $salida = "<option value=\"{$value}\"{$selected}>{$valor}</option>";

            return $salida;
        }, ['is_safe' => ['html']]));

    }

    public function render($fileName, $data)
    {
        return $this->templateEngine->render($fileName, $data);
    }


}