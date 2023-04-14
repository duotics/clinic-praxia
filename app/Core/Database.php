<?php

namespace App\Core;

use Exception;
use PDO;
use PDOException;

class Database
{
    public $dbh;
    private $strQuery;
    private $arrValues;

    function __construct()
    {
        $this->dbh = Conexion::getInstance()->dbh;
    }
    /*
    BEGIN TRANSACTION FUNCTIONS
    */
    public function startTransaction()
    {
        $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        $this->dbh->rollBack();
    }
    /*
    CRUD FUNCTIONS
    */
    //SELECT
    public function selectSQL(string $sql)
    {
        try {
            $qry = $this->dbh->prepare($sql);
            $qry->execute();
            $data = $qry->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            $LOG = $e->getMessage();
            dep($LOG, __FUNCTION__ . "({$sql})");
            return null;
        }
    }
    public function selectSQLR(string $sql)
    {
        try {
            $qry = $this->dbh->prepare($sql);
            $qry->execute();
            $ret = $qry->fetch(PDO::FETCH_ASSOC);
            $vP = TRUE;
        } catch (PDOException $e) {
            $LOG = $e->getMessage();
            $vP = FALSE;
        }
        return (array("est" => $vP, "ret" => $ret ?? null, "log" => $LOG ?? null));
    }
    //SELECT ALL
    public function selectAllSQL(string $sql)
    {
        try {
            $qry = $this->dbh->prepare($sql);
            $qry->execute();
            $ret = $qry->fetchAll(PDO::FETCH_ASSOC);
            return $ret;
        } catch (PDOException $e) {
            $LOG = $e->getMessage();
            dep($LOG, __FUNCTION__ . "({$sql})");
            return null;
        }
    }
    public function selectAllSQLR(string $qry)
    {
        try {
            $this->strQuery = $qry;
            $qry = $this->dbh->prepare($this->strQuery);
            $qry->execute();
            $ret = $qry->fetchAll(PDO::FETCH_ASSOC);
            $vP = TRUE;
        } catch (PDOException $e) {
            $LOG = $e->getMessage();
            $vP = FALSE;
        }
        return (array("est" => $vP, "ret" => $ret, "log" => $LOG ?? null));
    }
    /*
    INSERT
    */
    public function insertSQL(string $sql, array $values)
    {
        try {
            $qry = $this->dbh->prepare($sql);
            $qry->execute($values);
            $id = $this->dbh->lastInsertId() ?? null;
            return $id;
        } catch (PDOException $e) {
            $LOG = $e->getMessage();
            dep($LOG, __FUNCTION__ . "({$sql})");
            return null;
        }
    }
    public function insertSQLR(string $qry, array $values)
    {
        $this->strQuery = $qry;
        $this->arrValues = $values;
        try {
            $qry = $this->dbh->prepare($this->strQuery);
            //Asign Null to Empty Params
            foreach ($this->arrValues as $key => $value) {
                if (empty($value)) {
                    $this->arrValues[$key] = null;
                }
            }
            $qry->execute($this->arrValues);
            $id = $this->dbh->lastInsertId() ?? null;
            $ret = $id;
            $vP = TRUE;
            $LOG = cfg['p']['ins-true'];
        } catch (PDOException $e) {
            $LOG = cfg['p']['ins-false'] . $e->getMessage();
            //dep($LOG, "insertSQLR({$qry})");
        }
        return (array("est" => $vP, "val" => $ret, "log" => $LOG));
    }
    /*
    UPDATE
    */
    public function updateSQL(string $qry, array $values)
    {
        $this->strQuery = $qry;
        $this->arrValues = $values;
        $qry = $this->dbh->prepare($this->strQuery);
        $qry->execute($this->arrValues);
        return $qry;
    }
    public function updateSQLR(string $qry, array $values)
    {
        $vP = FALSE;
        $ret = null;
        $this->strQuery = $qry;
        $this->arrValues = $values;
        try {
            $qry = $this->dbh->prepare($this->strQuery);
            //Asign Null to Empty Params
            foreach ($this->arrValues as $key => $value) {
                if (empty($value)) {
                    $this->arrValues[$key] = null;
                }
            }
            $qry->execute($this->arrValues);
            $vP = TRUE;
            $LOG = cfg['p']['upd-truet'];
        } catch (PDOException $e) {
            $LOG = cfg['p']['upd-falset'] . $e->getMessage();
        }
        return (array("est" => $vP, "log" => $LOG));
    }
    /*
    DELETE
    */
    public function deleteSQL(string $qry)
    {
        $this->strQuery = $qry;
        $qry = $this->dbh->prepare($this->strQuery);
        $res = $qry->execute();
        return $res;
    }

    public function deleteSQLR(string $qry)
    {
        $vP = FALSE;
        $ret = null;
        try {
            $this->strQuery = $qry;
            $qry = $this->dbh->prepare($this->strQuery);
            $qry->execute();
            $vP = TRUE;
            $LOG = cfg['p']['del-true'];
        } catch (PDOException $e) {
            $LOG = cfg['p']['del-false'] . $e;
            //dep($LOG, "deleteSQLR
        }
        return (array("est" => $vP, "log" => $LOG));
    }


    /////////////////////////////

    public function detRow($table, $select, $field, $param, $foN = NULL, $foF = 'ASC')
    { //duotics_lib -> php8
        try {
            if (!$select) $select = "*";
            if ($foN) $paramOrd = 'ORDER BY ' . $foN . ' ' . $foF;
            else $paramOrd = "";
            $sql = sprintf(
                "SELECT %s FROM %s WHERE %s = :param %s LIMIT 1",
                htmlentities($select),
                htmlentities($table),
                htmlentities($field),
                htmlentities($paramOrd)
            );
            $RS = $this->dbh->prepare($sql);
            $RS->bindValue("param", $param);
            $RS->setFetchMode(PDO::FETCH_ASSOC);
            $RS->execute();
            $dRS = $RS->fetch();
            //$RS->closeCursor();
            //dep($dRS,"detRow");
            return $dRS;
        } catch (PDOException $e) {
            dep($e->getMessage(), "Database->detRow({$table})");
        }
    }
    public function detRowL($table, $field, $param, $lim = 1, $foN = NULL, $foF = 'ASC')
    { //duotics_lib -> php8
        if ($foN) $paramOrd = 'ORDER BY ' . $foN . ' ' . $foF;
        else $paramOrd = "";
        //LIMIT
        $limit = "";
        if ($lim != 0) {
            if (($lim <= 0) || (!$lim)) $lim = 1;
            $limit = " LIMIT " . $lim;
        }
        //QRY
        $sql = sprintf(
            "SELECT * FROM %s WHERE %s = :param %s %s",
            htmlentities($table),
            htmlentities($field),
            htmlentities($paramOrd),
            htmlentities($limit)
        );
        $RS = $this->dbh->prepare($sql);
        $RS->bindValue("param", $param);
        $RS->setFetchMode(PDO::FETCH_ASSOC);
        $RS->execute();
        $tRS = $RS->rowCount();
        if ((($tRS > 1) && ($lim == 0)) || (($tRS > 1) && ($lim > 0))) $ret = $RS;
        else $ret = ($RS->fetch());
        return $ret;
        ////$RS->closeCursor();
    }
    public function detRowNP($table, $select, $params, $lim = 1, $foN = NULL, $foF = 'ASC')
    {
        try {
            $lP = null;
            $ret = null;
            if (!$select) $select = "*";

            if ($foN) $paramOrd = 'ORDER BY ' . $foN . ' ' . $foF;
            else $paramOrd = "";

            $limit = "";
            if ($lim != 0) {
                if (($lim <= 0) || (!$lim)) $lim = 1;
                $limit = " LIMIT " . $lim;
            }
            $contParams = 0;
            if ($params) {
                foreach ($params as $x) {
                    foreach ($x as $y) {
                        $lP .= $y['cond'] . ' ' . $y['field'] . ' ' . $y['comp'] . ' ? ';
                        $contParams++;
                    }
                }
            }
            $sql = sprintf(
                "SELECT %s FROM %s WHERE 1=1 %s %s %s",
                htmlentities($select),
                htmlentities($table),
                ($lP),
                htmlentities($paramOrd),
                htmlentities($limit)
            );
            $RS = $this->dbh->prepare($sql);
            $contParams = 1;
            if ($params) {
                foreach ($params as $x) {
                    foreach ($x as $y) {
                        $RS->bindValue($contParams, $y['val']);
                        $contParams++;
                    }
                }
            }
            $RS->setFetchMode(PDO::FETCH_ASSOC);
            $RS->execute();
            $tRS = $RS->rowCount();
            if ((($tRS > 1) && ($lim == 0)) || (($tRS > 1) && ($lim > 0))) $ret = $RS;
            else $ret = ($RS->fetch());
            return $ret;
        } catch (Exception $e) {
            dep($e->getMessage(), "Database->detRowNP()");
        }
    }
    /************************************************************************************************************
        FUNCIONES DATOS (seleccionados), para seleccionarlos dento del Generar Select
     ************************************************************************************************************/
    public function detRowSel($table, $fielID, $field, $param)
    {
        $qry = sprintf(
            "SELECT %s as sID FROM %s WHERE :%s='%s'",
            htmlentities($fielID),
            htmlentities($table),
            htmlentities($field),
            htmlentities($param)
        );
        $RS = $this->dbh->prepare($qry);
        $RS->bindValue(":" . $field, $param);
        $RS->execute();
        return ($RS);
        //$RS->closeCursor();
    }
    public function detRowSelA($table, $fieldID, $field, $param)
    { //duotics_lib-> php8 v0.1
        $qry = sprintf(
            "SELECT %s as sID FROM %s WHERE %s=?",
            htmlentities($fieldID),
            htmlentities($table),
            htmlentities($field),
            htmlentities($field)
        );
        $RS = $this->dbh->prepare($qry);
        $RS->bindValue(1, $param);
        $RS->execute();
        $data = $RS->fetchAll(PDO::FETCH_COLUMN);
        return ($data);
    }

    public function detRowGSel($table, $fieldID, $fieldVal, $field = null, $param = null, $ord = FALSE, $valOrd = NULL, $ascdes = 'ASC')
    { //duotics_lib-> php8 v0.1
        $orderBy = ""; //Param for ordering SQL rows
        $paramWhere = "";
        if ($ord) {
            if (!($valOrd)) $orderBy = 'ORDER BY ' . ' sVAL ' . $ascdes;
            else $orderBy = 'ORDER BY ' . $valOrd . ' ' . $ascdes;
        }
        if ($field) {
            $paramWhere = sprintf(" WHERE %s=? ", htmlentities($field));
        }
        $qry = sprintf(
            'SELECT %s as sVAL, %s AS sID FROM %s %s %s',
            ($fieldVal),
            htmlentities($fieldID),
            htmlentities($table),
            htmlentities($paramWhere),
            htmlentities($orderBy)
        );
        $RS = $this->dbh->prepare($qry);
        if ($paramWhere) $RS->bindValue(1, $param);
        $RS->execute();
        //dep($RS);
        return ($RS);

        //$RS->closeCursor();
    }

    public function detRowGSelA($table, $fieldID, $fieldVal, $field = 1, $param = 1, $ord = FALSE, $valOrd = NULL, $ascdes = 'ASC')
    { //duotics_lib-> php8 v0.1
        $orderBy = ""; //Param for ordering SQL rows
        if ($ord) {
            if (!($valOrd)) $orderBy = 'ORDER BY ' . ' sVAL ' . $ascdes;
            else $orderBy = 'ORDER BY ' . $valOrd . ' ' . $ascdes;
        }
        $qry = sprintf(
            'SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=:%s %s',
            htmlentities($fieldVal),
            htmlentities($fieldID),
            htmlentities($table),
            htmlentities($field),
            htmlentities($field),
            htmlentities($orderBy)
        );
        $RS = $this->dbh->prepare($qry);
        $RS->bindValue(":" . $field, $param);
        $RS->execute();
        $data = $RS->fetchAll(PDO::FETCH_ASSOC);
        return ($data);
    }

    public function detRowGSelNP($table, $fieldID, $fieldVal, $params, $lim = 100, $foN = NULL, $foF = 'ASC')
    { //duotics_lib -> php8
        $lP = null;
        $ret = null;
        if ($foN) $paramOrd = 'ORDER BY ' . $foN . ' ' . $foF;
        else $paramOrd = "";

        $limit = "";
        /*
        if($lim!=0){
            if(($lim<=0)||(!$lim)) $lim=1;
            $limit=" LIMIT ".$lim;
        }*/
        $contParams = 0;
        if ($params) {
            foreach ($params as $x) {
                foreach ($x as $y) {
                    $lP .= $y['cond'] . ' ' . $y['field'] . ' ' . $y['comp'] . ' :' . $contParams . $y['field'] . ' ';
                    $contParams++;
                }
            }
        }
        $sql = sprintf(
            "SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 %s %s %s",
            htmlentities($fieldID),
            htmlentities($fieldVal),
            htmlentities($table),
            ($lP),
            htmlentities($paramOrd),
            htmlentities($limit)
        );
        $RS = $this->dbh->prepare($sql);
        $contParams = 0;
        if ($params) {
            foreach ($params as $x) {
                foreach ($x as $y) {
                    $RS->bindValue($contParams . $y['field'], $y['val']);
                    $contParams++;
                }
            }
        }
        $RS->setFetchMode(PDO::FETCH_ASSOC);
        $RS->execute();
        $tRS = $RS->rowCount();
        if ((($tRS > 1) && ($lim == 0)) || (($tRS > 1) && ($lim > 0))) $ret = $RS;
        else $ret = ($RS->fetch());
        ////$RS->closeCursor();
        return $ret;
    }

    //TOT ROWS

    public function totRowsTab($table, $field = 1, $param = 1, $cond = '=')
    { //duotics_lib-> php8 v.0.1 * GIT
        try {
            $qryCond = null;
            if ((isset($field)) && (isset($param))) $qryCond = sprintf(' WHERE %s %s ?', htmlentities($field), ($cond));
            $qry = sprintf('SELECT COUNT(*) AS TR FROM %s ' . $qryCond, htmlentities($table));
            $RS = $this->dbh->prepare($qry);
            $RS->bindValue(1, $param);
            $RS->setFetchMode(PDO::FETCH_ASSOC);
            $RS->execute();
            $dRS = $RS->fetch();
            return ($dRS['TR']);
        } catch (PDOException $e) {
            $LOG = $e->getMessage();
            dep($LOG, "totRowsTab({$table})");
            return null;
        }
    }

    function totRowsTabP($table, $param = null, $aux = null)
    { //duotics_lib->v.3.0
        //dep($aux, "function totRowsTabP aux");
        $sql = "SELECT COUNT(*) AS TR FROM {$table} {$aux} WHERE 1=1 {$param}";
        //dep($sql, "function totRowsTabP");
        $RS = $this->dbh->prepare($sql);
        $RS->setFetchMode(PDO::FETCH_ASSOC);
        $RS->execute();
        $tRS = $RS->rowCount();
        return $tRS;
    }

    public function totRowsTabNP($table, $params)
    {
        try {
            $lP = null;
            $contParams = 0;
            if ($params) {
                foreach ($params as $x) {
                    foreach ($x as $y) {
                        $lP .= $y['cond'] . ' ' . $y['field'] . ' ' . $y['comp'] . ' ? ';
                        $contParams++;
                    }
                }
            }
            $sql = sprintf("SELECT COUNT(*) AS TR FROM %s WHERE 1=1 %s", htmlentities($table), ($lP));
            //dep($sql);
            $RS = $this->dbh->prepare($sql);
            $contParams = 1;
            if ($params) {
                foreach ($params as $x) {
                    foreach ($x as $y) {
                        $RS->bindValue($contParams, $y['val']);
                        $contParams++;
                    }
                }
            }
            $RS->setFetchMode(PDO::FETCH_ASSOC);
            $RS->execute();
            $dRS = $RS->fetch();
            return ($dRS['TR']);
        } catch (Exception $e) {
            dep($e, "totRowsTabNP()");
        }
    }
    function genSelectA(
        $data,
        $nom = NULL,
        $sel = NULL,
        $class = NULL,
        $opt = NULL,
        $id = NULL,
        $showIni = TRUE,
        $valIni = null,
        $nomIni = "- Seleccione -",
        $placeHolder = NULL
    ) { //duotics_lib-> php8 v.0.1
        $dRS = null;
        $grpAct = null;
        $grpSel = null;
        $banG = false;
        $ret = null;
        if ($data) {
            if (empty($class)) $class = "form-select";
            $tRS = count($data);
            if (!isset($id)) $id = $nom;
            if (!$nom) $nom = "select";
            $ret .= "<select name='$nom' id='$id' class='$class' data-placeholder='$placeHolder' $opt >";
            //Show Ini Value
            if ($showIni == TRUE) {
                $ret .= "<option value='$valIni'";
                if (!$sel) $ret .= "selected='selected'";
                $ret .= ">$nomIni</option>";
            }
            if ($tRS) {
                foreach ($data as $dRS) {
                    if (isset($dRS['sGRUP'])) $grpAct = $dRS['sGRUP'];
                    if (($grpSel != $grpAct) && (isset($grpAct))) {
                        if ($banG == true) $ret .= "</optgroup>";
                        $ret .= "<optgroup label='$dRS[sGRUP]'>";
                        $grpSel = $grpAct;
                        $banG = true;
                    }
                    $ret .= "<option value='$dRS[sID]'";
                    if (is_array($sel)) {
                        if (in_array($dRS['sID'], $sel)) {
                            $ret .= "selected='selected'";
                        }
                    } else {
                        if (isset($sel)) {
                            if (isset($sel) && !(strcmp($dRS['sID'], $sel))) {
                                $ret .= "selected='selected'";
                            }
                        }
                    }
                    $ret .= ">$dRS[sVAL]</option>";
                } //END WHILE
                if ($banG == true) $ret .= "</optgroup>";
            }
            $ret .= '</select>';
        } else {
            $ret .= '<span class="label label-danger">Error genSelect : ' . $nom . '</span>';
        }
        return $ret;
    }
    function detRowInsRow($table/*db_pacientes_hc*/, $fieldSel/*pac_cod*/, $valSel/*890857086 -> md5*/, $fieldID/*id_hc -> ID from $table selected*/)
    {
        global $LOG;
        $vP = false;
        $id = null;
        $ids = null;
        $dRS = null;
        if ($valSel) {
            $dRS = $this->detRow($table, null, $fieldSel, $valSel);
            if ($dRS) { //SELECT ROW
                $id = $dRS[$fieldID];
                if ($id) {
                    $ids = md5($id);
                    $vP = true;
                } else $LOG .= "No se encuentra campo ID<br>";
            } else { //INSERT ROW
                $array = array($fieldSel => $valSel);
                $id = $this->insRow($table, $array)[$fieldID];
                if ($id) {
                    $ids = md5($id);
                    $vP = true;
                } else $LOG .= "No se pudo generar registro<br>";
            }
        } else {
            $LOG .= "Parametro de consulta no definido<br>";
        }
        return array("est" => $vP, "ids" => $ids, "log" => $LOG, "RS" => $dRS);
    }

    function insRow($table, $params)
    { //duoticLibs php8 v.0.1
        try {
            $pIndex = implode(',', array_keys($params));
            $pValue = implode(',', array_values($params));
            $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (:param)",
                htmlentities($table),
                htmlentities($pIndex),
                htmlentities($pIndex)
            );
            $this->dbh->beginTransaction();
            $RS = $this->dbh->prepare($sql);
            //echo $sql;
            $RS->bindValue("param", $pValue);
            $RS->execute();
            $this->dbh->commit();

            $ret['est'] = TRUE;
            $ret['id'] = $this->dbh->lastInsertId();
            $ret['log'] = 'Creado correctamente';
        } catch (Exception $e) {
            $ret['est'] = FALSE;
            $ret['log'] = 'Error. ' . $e->getMessage();
            $this->dbh->rollback();
        }
        return ($ret);
    }
    function updRow($table, $params, $cond, $limit = 1)
    { //duoticLibs php8 v.0.1
        $LOG = null;
        $vP = false;
        $id = null;
        try {
            if (is_array($params)) { //BEG IF Verify if params is array format
                if (count($params)) { //BEG IF Verify if params count exist
                    $sqlIndex = implode(',', array_keys($params));
                    $arrayIndex = array_keys($params);
                    $arrayVals = array_values($params);
                    $arrayParams = [];
                    foreach ($arrayIndex as $fields) {
                        $arrayParams[$fields] = $fields . "=:" . $fields;
                    }
                    $sqlParams = implode(",", $arrayParams);
                    $sqlCond = sprintf('%s %s "%s"', $cond[0], $cond[1], $cond[2]);
                    $sql = sprintf(
                        "UPDATE %s SET %s WHERE %s",
                        htmlentities($table),
                        htmlentities($sqlParams),
                        ($sqlCond),
                        (int)$limit
                    );
                    $this->dbh->beginTransaction();
                    $RS = $this->dbh->prepare($sql);
                    $PDOopt = null;
                    foreach ($arrayIndex as $fields) {
                        $RS->bindValue(":" . $fields, $params[$fields] === '' ? null : $params[$fields], PDO::PARAM_STR);
                        /*
                        if(($params[$fields] == null)||(($params[$fields] == "null"))){
                            $RS->bindValue(":".$fields,null,PDO::PARAM_NULL);
                            $LOG.="val. $params[$fields] -> null * ";
                        }else{
                            $RS->bindValue(":".$fields,$params[$fields],PDO::PARAM_STR);
                            $LOG.="val. $params[$fields] -> STR * ";
                        }
                        */
                    }
                    $RS->execute();
                    $this->dbh->commit();
                    $LOG .= cfg['p']['upd-truet'];
                    $vP = TRUE;
                } else $LOG .= "No hay campos para actualizar";
            } else $LOG .= "No hay data";
        } catch (Exception $e) {
            $vP = FALSE;
            $LOG .= 'Error. ' . $e->getMessage();
            $this->dbh->rollback();
        }
        $ret = array('est' => $vP, 'id' => $id, 'log' => $LOG);
        return ($ret);
    }
}
