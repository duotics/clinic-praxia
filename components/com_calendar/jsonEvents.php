<?php include('../../init.php');
$qryJson = sprintf(
	"SELECT * FROM db_fullcalendar 
LEFT JOIN db_pacientes ON db_fullcalendar.pac_cod=db_pacientes.pac_cod 
LEFT JOIN db_types ON db_fullcalendar.typ_cod=db_types.typ_cod 
WHERE fechai>=%s AND fechaf<=%s AND est<>0",
	SSQL($_GET['start'], 'date'),
	SSQL($_GET['end'], 'date')
);
$RSjson = mysqli_query(conn, $qryJson) or die(mysqli_error(conn));
while ($row = mysqli_fetch_array($RSjson)) {
	$det_tit = NULL;
	$fstart = NULL;
	$fend = NULL;
	$color = NULL;

	if ($row['pac_cod']) {
		$det_tit .= $row['pac_nom'] . ' ' . $row['pac_ape'];
	} else {
		$det_tit = $row['obs'];
	}

	if ($row['typ_cod']) $det_tit .= ' / ' . $row['typ_val'];
	//Date Start
	$fstart .= $row['fechai'];
	if ($row['horai']) {
		$fstart .= 'T' . $row['horai'] . $row['zona'];
	}
	//Date End
	$fend .= $row['fechaf'];
	if ($row['horaf']) {
		$fend .= 'T' . $row['horaf'] . $row['zona'];
	}
	$end = $row['fechaf'];

	if ($row['fechai'] < $sdate) { //COLORES BAJOS --> PASADO
		if ($row['est'] == 2) { //Atendido
			$color = '#9cba8e';
		} else if ($row['est'] == 1) { //Pendiente
			$color = '#bbb';
		}
	} else { //COLORES ALTOS --> PRESENTE/FUTURO
		if ($row['est'] == 2) { //Atendido
			$color = '#009900';
		} else if ($row['est'] == 1) { //Pendiente
			if ($row['pac_cod']) {
				$color = '#084c8d';
			} else {
				$color = '#5174b3';
			}
		}
	}

	/*
	if($row['pac_cod']){
		$color='#2e4174';
	}else{
		$color='#73b9e6';
	}
	
	if($row['fechai']<$sdate){
		if($row['est']==2){
			$color="#CCCC99";
		}else{
			$color="#ccc";
		}
	}else{
		if($row['est']==2){
			$color="#73b9e6";
		}else{
			$color="#2e4174";
		}
	}
*/
	$datos[] = array(
		'id' => $row['id'],
		'title' => $det_tit,
		'start' => $fstart,
		'end' => $fend,
		'color' => $color,
		//'url' => "#"//$row['url']
	);
}
echo json_encode($datos);
