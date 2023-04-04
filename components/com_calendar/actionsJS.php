<?php include('../../init.php');
$id = $_REQUEST['id'];
$fi = $_REQUEST['start'];
$ff = $_REQUEST['end'];

$fi = explode('T', $fi);
$ff = explode('T', $ff);
$fi_fec = $fi[0];
$fi_hor = $fi[1];
$ff_fec = $ff[0];
$ff_hor = $ff[1];

$qryUpd = sprintf(
	'UPDATE db_fullcalendar SET fechai=%s, fechaf=%s, horai=%s, horaf=%s WHERE id=%s',
	SSQL($fi_fec, 'date'),
	SSQL($ff_fec, 'date'),
	SSQL($fi_hor, 'text'),
	SSQL($ff_hor, 'text'),
	SSQL($id, 'int')
);
if (mysqli_query(conn, $qryUpd)) {
	$LOG .= 'Calendario Actualizado';
	$res = TRUE;
} else {
	$LOG .= 'ERROR Actualizar Calendario';
	$LOG .= mysqli_error(conn);
	$res = FALSE;
}
echo json_encode(array("cod" => $id, "res" => $res, "inf" => $LOG));
