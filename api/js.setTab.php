<?php require('../init.php');
$Auth->vLogin();
$val = $_GET['val'] ?? null;
$com = $_GET['com'] ?? null;
$vP = false;
$log = null;
try {
    if ($com && $val) {
        $_SESSION['tab'][$com] = $val;
        $log = "Tab: {$com} - {$val}";
        $vP = true;
    } else throw new Exception("No hay parametros");
} catch (Exception $e) {
    $log = $e->getMessage();
}
echo json_encode(array("status" => $vP, "log" => $log,  "data" => $val));
