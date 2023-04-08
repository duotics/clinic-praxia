<?php

namespace App\Core;

use Exception;
use App\Core\TemplateEngine;
use App\Core\TemplateGenHead;
use App\Core\TemplateGenFoot;

class TemplateGen
{
    protected static $head;
    protected static $foot;
    public function __construct(protected $paramsHead = null, protected $paramsFoot = null, protected $paramAlert = "sw", protected $paramsModulesHead = [], protected $paramsModulesFoot = [])
    {
        self::$head = new TemplateGenHead($paramsHead);
        self::$foot = new TemplateGenFoot($paramsFoot);
    }
    public function renderHead()
    {
        self::$head->showInterface();
        $this->renderBodyBeg();
    }
    public function renderFoot()
    {
        $this->renderBodyEnd();
        self::$foot->showInterface();
    }
    private function renderBodyBeg()
    {
        $this->loadModules($this->paramsModulesHead);
        $this->loadAlert();
    }
    private function renderBodyEnd()
    {
        $this->loadModules($this->paramsModulesFoot);
    }
    private function loadModules($params)
    {
        if ($params) {
            foreach ($params as $value) {
                include(root['m'] . $value);
            }
        }
    }
    private function loadAlert()
    {
        if ($this->paramAlert) {
            sLOG($this->paramAlert);
        }
    }
}
