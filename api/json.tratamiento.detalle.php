<?php include("../init.php");
$Auth->vLogin();

use App\Models\Tratamiento;

$mTrat = new Tratamiento();
try {
    $idt = isset($_GET['idt']) ? $_GET['idt'] : null;
    if ($idt) {
        $mTrat->setID($idt);
        $res = $mTrat->listTratamientosDetalleForm();
    } else {
        throw new Exception('No ID Tratamiento');
    }
} catch (Exception $e) {
    $LOG = $e->getMessage();
}
echo json_encode($res);
