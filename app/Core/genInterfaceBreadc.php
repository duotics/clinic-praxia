<?php

namespace App\Core;

use Exception;

class genInterfaceBreadc extends genInterface
{
    protected $vP;
    protected $log;

    public function __construct(protected $items, protected $home = true, protected $css = null, protected $divider = '>')
    {
        $this->gen_BS_breadcrumb();
    }

    private function gen_BS_breadcrumb()
    {
        try {
            $obj = null;
            if ($this->items) {
                $obj .= "<nav style='--bs-breadcrumb-divider: \"$this->divider\";' aria-label='breadcrumb'>";
                $obj .= "<ol class='breadcrumb mb-0 {$this->css}'>";
                if ($this->home) {
                    $routeDir = route['c'] . cfg['brd']['homedir'];
                    $routeTit = cfg['brd']['hometit'];
                    $obj .= "<li class='breadcrumb-item'><a href='" . $routeDir . "'>$routeTit</a></li>";
                }
                foreach ($this->items as $item) {
                    foreach ($item as $vars) {
                        $varv = array(
                            "css" => $vars['css'] ?? null,
                            "link" => $vars['link'] ?? null,
                            "name" => $vars['name'] ?? null,
                        );
                        if (isset($vars['link'])) $obj .= "<li class='breadcrumb-item $varv[css]'><a href='$varv[link]'>$varv[name]</a></li>";
                        else $obj .= "<li class='breadcrumb-item $varv[css]'>$varv[name]</li>";
                    }
                }
                $obj .= "</ol>";
                $obj .= "</nav>";
            }
            $this->vP = true;
            $this->obj = $obj;
        } catch (Exception $e) {
            $this->vP = false;
            $this->log = $e->getMessage();
        }
    }
}
