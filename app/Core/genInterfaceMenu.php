<?php

namespace App\Core;

use App\Models\Menu;
use Exception;

/*
For generate navbar in BS-5.2
*/

class genInterfaceMenu extends genInterface
{
    private $mMenu;
    protected $dMenu;
    public function __construct(protected $refMC, protected $css = NULL, protected $vrfUL = TRUE)
    {
        $this->mMenu = new Menu();
        $this->mMenu->detParam($this->mMenu->getmainRefName(), $this->refMC);
        $this->dMenu = $this->mMenu->det;
        $this->gen_BS_navbar();
    }
    //BEG GENERACION MENU
    public function gen_BS_navbar()
    {
        try {
            $obj = null;
            $LOG = null;
            $datasys = array($_SESSION['dU']['USER'] => "{username}");
            //verifico si el menu existe
            if ($this->dMenu) {
                $RSmp = $this->mMenu->getAllMenuItems_LevelAccess($this->refMC);
                $tRSmp = count($RSmp ?? 0);
                if ($tRSmp > 0) { //$LOGd.='Si hay menus padres------<br>';
                    foreach ($RSmp as $dRSmp) {
                        $RSmi = $this->mMenu->getAllMenuItems_LevelAccess(null, $dRSmp['id']);
                        $tRSmi = count($RSmi ?? 0);
                        //CSS para establecer la propiedad css dropdown
                        $cssSM = null;
                        if ($tRSmi > 0) $cssSM = "dropdown"; //Si hay menus hijos se establece el css 'dropdown'
                        //variable para establecer si el link se obtiene de la base o se deja default #
                        $link = ($valLink = $this->genLinkMenu($dRSmp['link'], $dRSmp['linkt'])) ? $valLink : "#";
                        //$link = route['c'] . $dRSmp['link'];
                        //Verifico si hay precodigo
                        if ($dRSmp['pre']) $obj .= $dRSmp['pre'];
                        $obj .= '<li class="nav-item ' . $cssSM . ' ' . $dRSmp['css'] . '" style="' . $dRSmp['sty'] . '">';
                        $newVal = array_search($dRSmp['tit'], $datasys);
                        if ($newVal) {
                            $dRSmp['tit'] = $newVal;
                        }
                        //
                        if ($tRSmi > 0) { //SI HAY SUBMENUS
                            $obj .= '<a href="' . $link . '" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">';
                            if (isset($dRSmp['ico'])) $obj .= '<i class="' . $dRSmp['ico'] . '"></i> ';
                            if (isset($dRSmp['tit'])) $obj .= $dRSmp['tit'];
                            $obj .= '</a>';
                            //BEG DROPDOWN MENU ITEMS DEPLOY
                            $obj .= "<ul class='dropdown-menu {$dRSmp['cssl']}' aria-labelledby='navbarDropdown'>";
                            foreach ($RSmi as $dRSmi) {
                                $link = ($valLink = $this->genLinkMenu($dRSmi['link'], $dRSmi['linkt'])) ? $valLink : "#";
                                if ($dRSmi['pre']) $obj .= $dRSmi['pre'];
                                $obj .= '<li><a class="dropdown-item ' . $dRSmi['css'] . '" href="' . $link . '">';
                                if ($dRSmi['ico']) $obj .= '<i class="' . $dRSmi['ico'] . '"></i> ';
                                if (!isset($dRSmi['titv'])) $dRSmi['titv'] = $dRSmi['tit'];
                                $obj .= $dRSmi['titv'] . '</a></li>';
                                if ($dRSmi['pos']) $obj .= $dRSmi['pos'];
                            }
                            $obj .= '</ul>';
                            //END DROPDOWN MENU ITEMS DEPLOY
                        } else { //NO HAY SUBMENUS
                            $obj .= '<a href="' . $link . '" class="nav-link">';
                            if ($dRSmp['ico']) $obj .= '<i class="' . $dRSmp['ico'] . '"></i> ';
                            $obj .= $dRSmp['tit'] . '</a>';
                        }
                        $obj .= '</li>';
                        if ($dRSmp['pos']) $obj .= $dRSmp['pos'];
                    }
                } else {
                    $LOG = "No items in menu";
                    $obj .= '<li class="nav-item">No items in menu <strong>' . $this->refMC . '</strong></li>';
                }
            } else {
                $LOG = "No menu exist";
                $obj .= '<li>No existe menu <strong>' . $this->refMC . '</strong></li>';
            }

            if ($this->vrfUL) $obj = '<ul class="' . $this->css . '">' . $obj . '</ul>'; //Verifica si solicito UL, si no devolveria solo LI

            $this->vP = true;
            $this->obj = $obj;
        } catch (Exception $e) {
            $this->vP = false;
        }
    }
    private function genLinkMenu($link, $type)
    {
        try {
            if ($link) {
                $result = match ($type) {
                    "c" => route['c'] . $link,
                    "i" => routeM . $link,
                    "e" => $link,
                };
                return $result;
            } else {
                throw new Exception("No hay link");
            }
        } catch (Exception $e) {
            //dep($e->getMessage(), "genInterfaceMenu->genLink()");
            return null;
        }
    }
}
