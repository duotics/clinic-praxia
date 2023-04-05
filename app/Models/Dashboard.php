<?php

namespace App\Models;

use App\Core\Database;

class Dashboard
{
    private $db;

    function __construct()
    {
        $this->db = new Database();
    }
    public function getAllIndicators()
    {

        $link=null;
        $TR=null;

        $indicadores = array(
            array("name"=>"Paciente", "link"=>null, "table"=>"db_pacientes"),
            array("name"=>"Consultas", "link"=>null, "table"=>"db_consultas"),
            array("name"=>"Tratamientos", "link"=>null, "table"=>"db_tratamientos"),
            array("name"=>"Examenes", "link"=>null, "table"=>"db_examenes"),
            array("name"=>"Documentos", "link"=>null, "table"=>"db_documentos"),
            array("name"=>"Cirugias", "link"=>null, "table"=>"db_cirugias"),
            array("name"=>"Signos Vitales", "link"=>null, "table"=>"db_signos"),
            array("name"=>"Medicamentos", "link"=>null, "table"=>"db_medicamentos"),
            array("name"=>"Indicaciones", "link"=>null, "table"=>"db_indicaciones"),
            array("name"=>"Diagnósticos", "link"=>null, "table"=>"db_diagnosticos")
        );
        
        foreach($indicadores as $ind){
            
            $TR = $this->db->totRowsTab($ind["table"], '1', '1');
            if(is_null($ind['link'])){
                $link="#";
            }else{
                $link=routeM;
            }
            $ret[]=array(
                "name"=>$ind['name'],
                "link"=>$link,
                "TR"=>$TR
            );
        }
        return $ret;
    }
}
