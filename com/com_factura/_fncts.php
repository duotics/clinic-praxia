<?php 
if ($_POST['mod'] == 'cancelar')
{ 
session_start();
$num1 = $_POST['num1'];
$det1 = $_POST['det1'];
$val1 = $_POST['val1'];
$fec1 = $_POST['fec1'];
$_SESSION['c'] = NULL;
if(count($_SESSION['b'])>0)
{	foreach($_SESSION['b'] as $l)
	{	if(($l["num"]==$num1) && ($l["det"]==$det1)){}
		else
		{	$ind1 =	$l["ind"];
			$lr[$ind1]["num"] = $l["num"];
			$lr[$ind1]["det"] = $l["det"];
			$lr[$ind1]["val"] = $l["val"];
			$lr[$ind1]["fec"] = $l["fec"];
			$lr[$ind1]["ind"] = $l["ind"];
			if ($l["val"]==$l["val_fac"])
				$lr[$ind1]["val_fac"]= $l["val"];
			else
				$lr[$ind1]["val_fac"]= $l["val_fac"];	
			$_SESSION['c'] = $lr;	
		}
	}
};
$_SESSION['b'] = $_SESSION['c'];
$insertGoTo = 'factura_form.php';
header(sprintf("Location: %s", $insertGoTo));	
}
if ($_POST['mod'] == 'sumar')
{
	session_start(); 
	$ind_s = $_POST['ind_sum'];
	$val_2 = $_POST['val2'];
	$_SESSION['d'] = NULL;
	if(count($_SESSION['b'])>0)
	{	foreach($_SESSION['b'] as $v)
		{	$ind1 =	$v["ind"];
			$lrd[$ind1]["num"] = $v["num"];
			$lrd[$ind1]["det"] = $v["det"];
			$lrd[$ind1]["val"] = $v["val"];
			$lrd[$ind1]["fec"] = $v["fec"];
			$lrd[$ind1]["ind"] = $v["ind"];
			if ($v["ind"]==$ind_s)
			{$lrd[$ind1]["val_fac"]= $val_2;}
			else	
			{	if ($v["val"]==$v["val_fac"])
					$lrd[$ind1]["val_fac"]= $v["val"];
				else
					$lrd[$ind1]["val_fac"]= $v["val_fac"];	
			}
		}
	}
	$_SESSION['d'] = $lrd;
	$_SESSION['b'] = $_SESSION['d'];
	$insertGoTo = 'factura_form.php';
	header(sprintf("Location: %s", $insertGoTo));
	}
?>


