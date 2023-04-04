<?php

namespace App\Models;

use Exception;
use App\Core\Database;
use App\Models\Media;

class Documento
{
    private $db;

    protected $mainTable = "db_documentos";
    protected $mainID = "id_doc";
    protected $id;
    public $det;
    function __construct()
    {
        $this->db = new Database();
    }
    function setID($id)
    {
        $this->id = $id;
    }
    function getID($md5 = FALSE)
    {
        $ret = null;
        if ($md5) $ret = md5($this->det[$this->mainID]);
        else $ret = $this->det[$this->mainID];
        return $ret;
    }
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    public function detParam($fiel = 1, $val = 1)
    {
        $this->det = $this->db->detRow($this->mainTable, null, $fiel, $val);
    }
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllDet()
    {
        $sql = "SELECT {$this->mainTable}.id_doc AS ID, {$this->mainTable}.nombre AS NOM,
        {$this->mainTable}.con_num AS IDC, {$this->mainTable}.pac_cod AS IDP, {$this->mainTable}.fecha AS DATE,
        CONCAT_WS(' ',db_pacientes.pac_nom, db_pacientes.pac_ape) AS PAC 
        FROM {$this->mainTable} 
        LEFT JOIN db_pacientes ON {$this->mainTable}.pac_cod=db_pacientes.pac_cod
        ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllExamFormat()
    {
        $sql = "SELECT * FROM db_examenes_format ORDER BY id DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllExamCon($idCon, $idPac)
    {
        $sql = "SELECT * FROM {$this->mainTable} 
        WHERE con_num=$idCon OR pac_cod=$idPac 
        ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllMedia()
    {
        $sql = "SELECT {$this->mediaTable}.id AS ID, db_media.file AS FILE, db_media.des AS DES 
        FROM {$this->mediaTable} 
        INNER JOIN db_media ON {$this->mediaTable}.id_med=db_media.id_med
        WHERE md5(id_exa)='{$this->id}' 
        AND db_media.estado=1
        ORDER BY id DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function insertExam(int $idp, $idc, $date, $diag, $desCir, $dateR, $desProt, $desEvo)
    {
        $sql = "INSERT INTO {$this->mainTable} (pac_cod, con_num, fecha, diagnostico, cirugiar, fechar, protocolo, evolucion) VALUES (?,?,?,?,?,?,?,?)";
        $arrayData = array($idp, $idc, $date, $diag, $desCir, $dateR, $desProt, $desEvo);
        //dep($sql);
        //dep($arrayData);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateExam(string $idr, $diag, $desCir, $dateR, $desProt, $desEvo)
    {
        $sql = "UPDATE {$this->mainTable} SET diagnostico=?, cirugiar=?, fechar=?, protocolo=?, evolucion=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($diag, $desCir, $dateR, $desProt, $desEvo, $idr);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        dep($sql);
        dep($arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteExam(string $id)
    {
        $sql = "DELETE FROM {$this->mainTable} WHERE md5({$this->mainID})='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function insertMedia(int $idc, string $file,  $des)
    {
        $mMedia = new Media;
        $idMed = $mMedia->insertMedia($file, $des);
        $sql = "INSERT INTO {$this->mediaTable} (id_cir, id_med) VALUES (?,?)";
        $arrayData = array($idc, $idMed);
        $ret = $this->db->insertSQL($sql, $arrayData);
        return $ret;
    }
    function deleteMedia(string $id)
    {
        try {
            $detMedia = $this->detMedia($id);
            $this->setID(md5($detMedia['id_cir']));
            $this->det();
            $sql = "DELETE FROM {$this->mediaTable} WHERE md5({$this->mediaID})='{$id}' LIMIT 1";
            $ret = $this->db->deleteSQLR($sql);
        } catch (Exception $e) {
            $ret = array("est" => FALSE, $ret => null, "log" => $e);
        }
        return $ret;
    }
    public function uploadMedia($files, $idCir)
    {
        $LOG = null;
        if (isset($files) && ($files['name'])) {
            $param_file['ext'] = array('.jpg', '.gif', '.png', '.jpeg', '.JPG', '.GIF', '.PNG', '.JPEG');
            $param_file['siz'] = 2097152; //en KBPS
            $param_file['pat'] = RAIZd . 'db/cir/';
            $param_file['pre'] = 'cir';
            $param_file['thumb'] = TRUE;
            $param_file['thumb-w'] = 300;
            $param_file['thumb-h'] = 300;
            $files = array();
            $fdata = $files;
            if (is_array($fdata['name'])) {
                for ($i = 0; $i < count($fdata['name']); ++$i) {
                    $files[] = array(
                        'name'    => $fdata['name'][$i],
                        'type'  => $fdata['type'][$i],
                        'tmp_name' => $fdata['tmp_name'][$i],
                        'error' => $fdata['error'][$i],
                        'size'  => $fdata['size'][$i]
                    );
                }
            } else $files[] = $fdata;
            foreach ($files as $file) {
                $upl = uploadfile($param_file, $file);
                if ($upl['EST'] == TRUE) {
                    $this->insertMedia($idCir, $upl['FILE'], "");
                }
                $LOG .= $upl['LOG'];
            }
        }
        return $LOG;
    }
}
