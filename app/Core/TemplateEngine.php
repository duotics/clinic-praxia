<?php

namespace App\Core;

use Smarty;
use Exception;

class TemplateEngine extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        // Configuración de Smarty
        $this->setTemplateDir(root['t']);
        $this->setCompileDir(root['t'] . 'compiled');
        $this->setCacheDir(root['t'] . 'cache/');
        $this->setConfigDir(root['t'] . 'configs/');

        // Desactivar la caché de plantillas si es necesario
        $this->caching = false;
    }

    public function render($template, $data)
    {
        try {
            // Asignar datos a las variables de Smarty
            foreach ($data as $key => $value) {
                $this->assign($key, $value);
            }

            // Procesar la plantilla con Smarty
            return $this->fetch($template);
        } catch (Exception $e) {
            dep($e->getMessage());
        }
    }
}
