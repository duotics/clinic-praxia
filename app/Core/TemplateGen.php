<?php

namespace App\Core;

use App\Core\TemplateGenHead;
use App\Core\TemplateGenFoot;

class TemplateGen
{
    protected static $head;
    protected static $foot;
    public function __construct(
        protected $paramsHead = null,
        protected $paramsFoot = null,
        protected $paramAlert = null,
        protected $paramsModulesHead = [],
        protected $paramsModulesFoot = [],
        protected $paramsBreadcrumb = [],
        protected $paramsTitle = []
    ) {
        self::$head = new TemplateGenHead($paramsHead);
        self::$foot = new TemplateGenFoot($paramsFoot);
    }
    public function renderHead()
    {
        self::$head->render();
        $this->renderBodyBeg();
    }
    public function renderTop()
    {
        $this->generateBreadcrumb();
        $this->generateTitle();
    }
    public function renderFoot()
    {
        $this->renderBodyEnd();
        self::$foot->render();
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
        sLOG($this->paramAlert);
    }
    private function generateBreadcrumb()
    {
        if ($this->paramsBreadcrumb) {
            $objBrc = new genInterfaceBreadc(
                $this->paramsBreadcrumb[0] ?? null,
                $this->paramsBreadcrumb[1] ?? TRUE,
                $this->paramsBreadcrumb[2] ?? null
            );
            $objBrc->render();
        }
    }
    private function generateTitle()
    {
        if ($this->paramsTitle) {
            $obj = new genInterfaceTitle(
                $this->paramsTitle[0] ?? null,
                $this->paramsTitle[1] ?? null,
                $this->paramsTitle[2] ?? null,
                $this->paramsTitle[3] ?? null,
                $this->paramsTitle[4] ?? null,
                $this->paramsTitle[5] ?? null,
                $this->paramsTitle[6] ?? null
            );
            $obj->render();
        }
    }
}
