<?php

namespace App\Core;

use Exception;
use App\Core\TemplateEngine;

class TemplateGenHead extends genInterface
{
    private $nameTemplate = "head.tpl";
    protected $title;
    protected $css;
    public function __construct($params)
    {
        $this->title = $params['title'] ?? null;
        $this->css = $params['css'] ?? null;
        if (!isset($this->title)) {
            $this->title = $_ENV["APP_NAME"];
        }
        $this->gen_head();
    }
    private function gen_head()
    {
        try {
            // Crear una instancia de la clase TemplateEngine
            $smarty = new TemplateEngine();
            // Asignar variables a Smarty
            $smartyData = [
                'title' => $this->title,
                'author' => $_ENV["APP_AUTHOR"],
                'description' => $_ENV["APP_DESC"],
                'favicon' => route['n'] . 'favicon.ico',
                'route' => route,
                'styles' => $this->loadStyles(),
                'scripts' => $this->loadScripts(),
                'bodyClass' => $this->css['body'] ?? null,
                'bodyBg' => isset($this->css['body-bg']) ? (route['i'] . $this->css['body-bg']) : null,
            ];
            // Procesar la plantilla de Smarty
            $obj = $smarty->render($this->nameTemplate, $smartyData);
            $this->vP = TRUE;
            $this->obj = $obj;
        } catch (Exception $e) {
            $this->vP = FALSE;
        }
    }
    public function loadStyles()
    {
        $ret = null;
        $theme = getBSTheme();
        $listFiles = [
            [route['n'], "bootstrap/dist/css/bootstrap.min.css"],
            [route['n'], "bootswatch/dist/$theme/bootstrap.min.css"],
            [route['n'], "@fortawesome/fontawesome-free/css/all.min.css"],
            [route['n'], "jquery-ui/dist/themes/base/jquery-ui.min.css"],
            [route['n'], "jquery-ui/dist/themes/ui-lightness/jquery-ui.min.css"],
            [route['n'], "datatables.net-bs5/css/dataTables.bootstrap5.min.css"],
            [route['n'], "select2/dist/css/select2.min.css"],
            [route['n'], "select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css"],
            [route['n'], "@fancyapps/ui/dist/fancybox/fancybox.css"],
            [route['n'], "sweetalert2/dist/sweetalert2.min.css"],
            [route['n'], "animate.css/animate.css"],
            [route['n'], "leaflet/dist/leaflet.css"],
            [route['a'], "css/custom-v01.css"]
        ];
        foreach ($listFiles as $file) {
            $ret .= "<link rel='stylesheet' type='text/css' href='{$file[0]}{$file[1]}' />";
        }
        return $ret;
    }
    public function loadScripts()
    {
        $ret = null;
        $ret .= "<script> 
        const RAIZ = '{$_ENV['APP_URL']}';
        const RAIZ0 = '{$_ENV['APP_URLR']}';
        const RAIZp = '" . route['p'] . "';
        const RAIZc = '" . route['c'] . "';
        </script>
        ";
        $listFiles = [
            [route['n'], "jquery/dist/jquery.min.js"],
            [route['n'], "jquery-ui/dist/jquery-ui.min.js"],
            [route['n'], "@popperjs/core/dist/umd/popper.min.js"],
            [route['n'], "bootstrap/dist/js/bootstrap.min.js"],
            [route['n'], "@fancyapps/ui/dist/fancybox/fancybox.umd.js"],
            [route['n'], "chart.js/dist/chart.umd.js"],
            [route['n'], "datatables.net/js/jquery.dataTables.min.js"],
            [route['n'], "datatables.net-bs5/js/dataTables.bootstrap5.min.js"],
            [route['n'], "select2/dist/js/select2.min.js"],
            [route['n'], "select2/dist/js/i18n/es.js"],
            [route['n'], "@fullcalendar/core/index.global.js"],
            [route['n'], "leaflet/dist/leaflet.js"],
            [route['n'], "tinymce/tinymce.min.js"],
            [route['n'], "sweetalert2/dist/sweetalert2.all.min.js"],
            [route['n'], "wow.js/dist/wow.min.js"],
            [route['a'], "js/custom-v01.js"],
            [route['a'], "js/jquery.clinic-0.0.3.js"]
        ];
        foreach ($listFiles as $file) {
            $ret .= "<script type='text/javascript' src='{$file[0]}{$file[1]}'></script>";
        }
        return $ret;
    }
}
