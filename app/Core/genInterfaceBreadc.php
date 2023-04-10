<?php

namespace App\Core;

use Exception;

class genInterfaceBreadc extends genInterface
{
    protected $vP;
    protected $log;

    public function __construct(protected $items, protected $home = true, protected $css = null, protected $divider = '>')
    {
        if (empty($this->home)) $this->home = true;
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
                /*
                array items
                [0]=name
                [1]=link
                [2]=active
                */
                foreach ($this->items as $item) {
                    $itemFinal = [$item[0] ?? null, $item[1] ?? null, $item[2] ?? null];
                    if ($itemFinal[2]) $cssItem = "active";
                    else $cssItem = null;
                    if (isset($itemFinal[1])) {
                        $obj .= "<li class='breadcrumb-item {$cssItem}'><a href='$itemFinal[1]'>$itemFinal[0]</a></li>";
                    } else {
                        $obj .= "<li class='breadcrumb-item {$cssItem}'>$itemFinal[0]</li>";
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
