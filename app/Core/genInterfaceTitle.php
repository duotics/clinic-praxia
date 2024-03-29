<?php

namespace App\Core;

use Exception;
use App\Models\Componente;

class genInterfaceTitle extends genInterface
{
    private $mComp;
    protected $dComp;
    public function __construct(
        protected $MOD = null,
        protected $tip = 'card',
        protected $cont = NULL,
        protected $floatR = NULL,
        protected $floatL = NULL,
        protected $css = null,
        protected $tag = 'h1'
    ) {
        $this->tag = (!empty($this->tag)) ? removeSpecialChars($this->tag) : 'h1';
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
                    $objMod .= $MOD["id"] ? " <span class='badge bg-primary'>{$MOD["id"]}</span> " : null;
                    $objMod .= $MOD["icon"] ? " <span class='badge bg-light'><i class='{$MOD["icon"]}'></i></span> " : null;
                    $objMod .= $MOD["nom"] ? " <span >{$MOD["nom"]}</span> " : null;
                    $objMod .= $MOD["des"] ? " <span class='badge bg-light'>{$MOD["des"]}</span> " : null;
                    $obj .= "<div class='card mt-2 mb-2 {$this->css}'>
                        <div class='card-body'>
                        <div class='btn-group float-end'>{$this->floatR}</div>
                        <{$this->tag} class='mb-0'><small> {$objMod} {$this->cont} </small></$this->tag>
                    </div></div>";
                    break;
                case 'header':
                    $objLeft = (!empty($this->floatL)) ? "<div class='float-start'>{$this->floatL}</div>" : null;
                    $objRight = (!empty($this->floatR)) ? "<div class='float-end'>{$this->floatR}</div>" : null;

                    $obj .= "<div class='border-bottom mt-3 mb-3 {$this->css}'>
                        <{$this->tag}>
                            {$objLeft}
                            <i class='{$MOD['icon']}'></i> {$MOD['nom']} <span class='badge bg-light'>{$MOD['des']}</span>
                            {$this->cont}
                            {$objRight}
                            <div class='clearfix'></div>
                        </{$this->tag}>
                    </div>";
                    break;
                case 'navbar':
                    $obj .= "<nav class='navbar navbar-dark bg-dark {$this->css}'>
                        <div class='container-fluid'>
                        <a class='navbar-brand' href='#'> <i class='{$MOD["icon"]}'></i>
                        {$MOD['nom']} <small class='badge badge-secondary'> {$MOD["des"]} </small>
                        </a>
                        <ul class='navbar-nav mr-auto'>{$this->cont}</ul>
                        </div>
                        </nav>";
                    break;
                default:
                    $obj = '<div class="mt-2 mb-2">';
                    if (isset($MOD['id'])) $obj .= "<span class='badge bg-secondary'>{$MOD['id']}</span>";
                    $obj .= "<{$this->tag}>{$MOD['nom']}</{$this->tag}>";
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
