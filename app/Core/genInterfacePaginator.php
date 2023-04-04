<?php 
namespace App\Core;

class genInterfacePaginator extends genInterface{
    protected $vP;
    protected $log;
    
    public function __construct(protected $TR, protected $dp, protected $dipp){
        $obj=$this->gen_BS_paginator();
        $this->obj = $obj;
    }
    
    private function gen_BS_paginator(){
        $this->vP=true;
        $obj=null;
        if($this->TR){
            $obj.="<div class='card card-light mt-3 mb-3'>
            <div class='card-body'>
            <div class='row'>
                <div class='col-md-2'><span class='badge bg-light'><strong> $this->TR </strong> Resultados</span></div>
                <div class='col-md-8'>
                    <ul class='pagination pagination-sm justify-content-center m-0'> ".$this->dp." </ul>
                </div>
                <div class='col-md-2'>".$this->dipp."</div>
            </div>
            </div>
            </div>";
        }else $this->vP=false;
        $ret=array("est"=>$this->vP ?? null, "val"=>$obj ?? null, "log"=>$this->log ?? null);
        return $ret;
    }
}