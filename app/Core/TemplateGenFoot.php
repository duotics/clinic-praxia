<?php

namespace App\Core;

use Exception;
use App\Core\TemplateEngine;

class TemplateGenFoot extends genInterface
{
    private $nameTemplate = "foot.tpl";
    protected $showBottom;
    public function __construct($params)
    {
        $this->showBottom = $params['showBottom'] ?? true;
        $this->gen_foot();
    }
    private function gen_foot()
    {

        try {
            $smarty = new TemplateEngine();
            $theme = getBSTheme();
            $smartyData = [
                'APP_COPY' => $_ENV['APP_COPY'],
                'APP_ENV' => $_ENV['APP_ENV'],
                'bsTheme' => $theme,
                'showBottom' => $this->showBottom,
                'valBottom' => root['f'] . 'bottom.php'
            ];
            $obj = $smarty->fetch($this->nameTemplate, $smartyData);

            $this->vP = TRUE;
            $this->obj = $obj;
        } catch (Exception $e) {
            $this->vP = FALSE;
        }
    }
}
