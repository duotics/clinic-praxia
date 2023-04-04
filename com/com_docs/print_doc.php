<?php require('../../init.php');
$idd = $_GET['idd'] ?? $_POST['idd'] ?? null;
$detdoc = fnc_datadoc($idd);
include(RAIZf . 'head.php');
?>

<body class="cero">
	<div class="container">
		<div class="well" style="background:#FFF">
			<?php echo $detdoc['contenido'] ?>
		</div>
	</div>
</body>

</html>