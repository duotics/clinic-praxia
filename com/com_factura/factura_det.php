<?php 
session_start(); 
$num = $_POST['num'];
$det = $_POST['det'];
$val = $_POST['val'];
$fec = $_POST['fec'];
$ind = $_POST['ind'];
$li = $_SESSION['b'];
$li[$ind]["num"] = $num;
$li[$ind]["det"] = $det;
$li[$ind]["val"] = $val;
$li[$ind]["val_fac"] = $val;
$li[$ind]["fec"] = $fec;
$li[$ind]["ind"] = $ind;
$_SESSION['b'] = $li;
?>
<script type="text/javascript">
	parent.Shadowbox.close();
</script>