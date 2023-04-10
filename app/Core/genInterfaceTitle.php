<?php

namespace App\Core;

use Exception;
use App\Models\Componente;

class genInterfaceTitle extends genInterface
{
    private $mComp;
    protected $dComp;
    public function __construct(protected $MOD = null, protected $tip = 'card', protected $cont = NULL, protected $floatR = NULL, protected $floatL = NULL, protected $css = null, protected $tag = 'h1')
    {
        $this->mComp = new Componente();
        $this->gen_BS_header();
    }
    private function gen_BS_header()
    {
        try {
            $obj = null;
            $objMod = null;
            $MOD = array(
                "id" => $this->MOD['id'] ?? null,
                "icon" => $this->MOD['icon'] ?? $this->MOD['iconM'] ?? null,
                "nom" => $this->MOD['nom'] ?? $this->MOD['nomM'] ?? null,
                "des" => $this->MOD['des'] ?? $this->MOD['titM'] ?? null
            );
            //BEGIN OBJ CONSTRUCT
            $obj .= "<div class='obj-header-wrapper clearfix'>";
            switch ($this->tip) {
                case 'card':
                    if ($MOD["id"]) {
                        $objMod .= " <span class='badge bg-primary'>{$MOD["id"]}</span> ";
                    }
                    if ($MOD["icon"]) {
                        $objMod .= " <span class='badge bg-light'><i class='{$MOD["icon"]}'></i></span> ";
                    }
                    if ($MOD["nom"]) {
                        $objMod .= " <span >{$MOD["nom"]}</span> ";
                    }
                    if ($MOD["des"]) {
                        $objMod .= " <span class='badge bg-light'>{$MOD["des"]}</span> ";
                    }
                    $obj .= "<div class='card mt-2 mb-2 {$this->css}'>
                        <div class='card-body'>
                        <div class='btn-group float-end'>{$this->floatR}</div>
                        <{$this->tag} class='mb-0'><small> {$objMod} {$this->cont} </small></$this->tag>
                    </div></div>";
                    break;
                case 'header':
                    $objMod .= "<i class='{$MOD['icon']}'></i> {$MOD['nom']} <span class='badge bg-light'>{$MOD['des']}</span>";
                    $obj .= '<div class="border-bottom mt-3 mb-3 ' . $this->css . '">';
                    if ($this->floatL) $obj .= "<div class='float-start'>{$this->floatL}</div>";
                    if ($this->floatR) $obj .= "<div class='float-end'>{$this->floatR}</div>";
                    $obj .= "<{$this->tag}> {$objMod} {$this->cont} </{$this->tag}></div>";
                    break;
                case 'navbar':
                    $obj = "<nav class='navbar navbar-dark bg-dark {$this->css}'>
                        <div class='container-fluid'>
                        <a class='navbar-brand' href='#'> <i class='{$MOD["icon"]}'></i>
                        {$MOD['nom']} <small class='badge badge-secondary'> {$MOD["des"]} </small>
                        </a>
                        <ul class='navbar-nav mr-auto'>{$this->cont}</ul>
                        </div></nav>";
                    break;
                default:
                    $obj = '<div class="mt-2 mb-2">';
                    if (isset($MOD['idMod'])) $obj .= "<span class='badge bg-secondary'>{$MOD['idMod']}</span>";
                    $obj .= "{$MOD['nomMod']}</div>";
                    break;
            }
            $obj .= "</div>";
            $this->vP = TRUE;
            $this->obj = $obj;
        } catch (Exception $e) {
            $this->vP = FALSE;
        }
    }
}
