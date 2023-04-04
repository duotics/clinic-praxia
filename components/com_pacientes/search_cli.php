<?php include('../../init.php');
$val=$_GET['idsearch'];
$query_RScli = "SELECT * FROM db_pacientes";
$RScli = mysqli_query(conn,$query_RScli) or die(mysqli_error(conn));
$row_RScli = mysqli_fetch_assoc($RScli);
$totalRows_RScli = mysqli_num_rows($RScli);
$q = strtolower($_GET["q"]);
if (!$q) return;
do{
	if($val=='find_nom') $find_cad=$row_RScli['pac_nom'].' '.$row_RScli['pac_ape'];
	if($val=='find_ape') $find_cad=$row_RScli['pac_ape'].' '.$row_RScli['pac_nom'];
	if($val=='find_dir') $find_cad=$row_RScli['pac_dir'].' - '.$row_RScli['pac_nom'].' '.$row_RScli['pac_ape'];
	if($val=='find_tel') $find_cad=$row_RScli['pac_tel1'].' - '.$row_RScli['pac_tel2'].' _ '.$row_RScli['pac_nom'].' '.$row_RScli['pac_ape'];
	if($val=='find_ciu') $find_cad=$row_RScli['pac_ciu'].' - '.$row_RScli['pac_nom'].' '.$row_RScli['pac_ape'];
	$items [$find_cad]=$row_RScli['pac_cod'];
} while ($row_RScli = mysqli_fetch_assoc($RScli));
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) echo "$key|$value\n";
}
?>