<?php

namespace App\Core;

use App\Models\Menu;

class genInterfaceMenu extends genInterface
{
    private $mMenu;
    public function __construct(protected $refMC, protected $css = NULL, protected $vrfUL = TRUE)
    {
        $this->mMenu = new Menu();
        $obj = $this->gen_BS_navbar();
        $this->obj = $obj;
    }
    //BEG GENERACION MENU
    public function gen_BS_navbar()
    {
        $this->vP = true;
        $ret = null;
        $obj = null;
        $objMod = null;
        //Consulta para Menus Principales
        $RSmp = $this->mMenu->getAllMenuParent($this->refMC);
        if ($RSmp) {
            foreach ($RSmp as $dRSmp) {
                //Consulta para Submenus
                $qry2 = sprintf(
                    "SELECT * FROM tbl_menus_items 
			INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
			WHERE tbl_menus_items.men_padre = %s AND tbl_menu_usuario.usr_id = %s AND tbl_menus_items.men_stat = %s 
			ORDER BY men_orden ASC",
                    SSQL($dRSmp['men_id'], 'int'),
                    SSQL($_SESSION['dU']['ID'], 'int'),
                    SSQL(1, 'int')
                );
                $RSmi = mysqli_query(conn, $qry2) or die(mysqli_error(conn));
                $dRSmi = mysqli_fetch_assoc($RSmi);
                $tRSmi = mysqli_num_rows($RSmi);
                if ($tRSmi > 0) $cssSM = "dropdown";
                else $cssSM = "";
                if ($dRSmp['men_link']) $link = $GLOBALS['RAIZc'] . $dRSmp['men_link'];
                else $link = "#";
                if ($dRSmp['men_precode']) $obj .= $dRSmp['men_precode'];
                $obj .= '<li class="' . $cssSM . '">';
                if ($tRSmi > 0) {
                    $obj .= '<a href="' . $link . '" class="dropdown-toggle"';
                    if ($tRSmi > 0) {
                        $obj .= 'data-toggle="dropdown"';
                    }
                    $obj .= '>';
                    if ($dRSmp['men_icon']) $obj .= '<i class="' . $dRSmp['men_icon'] . '"></i> ';
                    $obj .= $dRSmp['men_tit'];
                    if ($tRSmi > 0) {
                        $obj .= ' <b class="caret"></b>';
                    }
                    $obj .= '</a>';
                    $obj .= '<ul class="dropdown-menu">';
                    do {
                        if ($dRSmi['men_link']) {
                            $link = $GLOBALS['RAIZc'] . $dRSmi['men_link'];
                        } else {
                            $link = "#";
                        }
                        if ($dRSmi['men_precode']) $obj .= $dRSmi['men_precode'];
                        $obj .= '<li><a href="' . $link . '">';
                        if ($dRSmi['men_icon']) $obj .= '<i class="' . $dRSmi['men_icon'] . '"></i> ';
                        $obj .= $dRSmi['men_tit'] . '</a></li>';
                        if ($dRSmi['men_postcode']) $obj .= $dRSmi['men_postcode'];
                    } while ($dRSmi = mysqli_fetch_assoc($RSmi));
                    mysqli_free_result($RSmi);
                    $obj .= '</ul>';
                } else {

                    $obj .= '<a href="' . $link . '">';
                    if ($dRSmp['men_icon']) $obj .= '<i class="' . $dRSmp['men_icon'] . '"></i> ';
                    $obj .= $dRSmp['men_tit'] . '</a>';
                }
                $obj .= '</li>';
                if ($dRSmp['men_postcode']) $obj .= $dRSmp['men_postcode'];
            }
            mysqli_free_result($RSmp);
        } else {
            $obj .= null; //No existen menus para <strong>'.$refMC.'</strong>';
        }
        //Verifica si solicito UL, si no devolveria solo LI
        if ($this->vrfUL) $obj = '<ul class="' . $this->css . '">' . $obj . '</ul>';

        $ret = array("est" => $this->vP ?? null, "val" => $obj ?? null, "log" => $this->log ?? null);
        return $ret;
    }
    //END GENERACION MENU
}
