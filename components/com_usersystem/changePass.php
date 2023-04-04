<?php require('../../init.php');
include(RAIZf.'head.php');
?>
<script type="text/javascript" src="js.js"></script>
<link rel="stylesheet" type="text/css" href="css.css">

<body class="cero">
<div class="container-fluid">
<?php sLOG('g');?>
<form method="post" action="actions.php">
<input type="hidden" name="form" value="formPass">
<div class="panel panel-primary">
	<div class="panel-heading">Cambio de Contraseña</div>
	<div class="panel-body">
	<fieldset class="form-horizontal">
	<div class="form-group">
		<label for="formPassAnt" class="col-sm-4 control-label">Contraseña Anterior</label>
		<div class="col-sm-6">
			<input name="formPassAnt" type="password" class="form-control" placeholder="Contraseña Anterior" autocomplete="off" required>
		</div>
	</div>
    <div class="form-group">
		<label for="formPassNew1" class="col-sm-4 control-label">Contraseña Nueva</label>
		<div class="col-sm-6">
			<input name="formPassNew1" id="formPassNew1" type="password" class="form-control" placeholder="Contraseña Nueva" onkeyup="passwordStrength(this.value)" autocomplete="off" required>
		</div>
	</div>
    <div class="form-group">
		<label for="formPassNew2" class="col-sm-4 control-label">Confirmar Contraseña</label>
		<div class="col-sm-6">
			<input name="formPassNew2" id="formPassNew2" type="password" class="form-control" placeholder="Confirmar Contraseña" autocomplete="off" required>
		</div>
	</div>
    
    <div class="form-group">
    	<label for="passwordStrength" class="col-sm-4 control-label">Fuerza de la Contraseña</label>
        <div class="col-sm-6">
		<div id="passwordDescription">Sin Contraseña</div>
		<div id="passwordStrength" class="strength0"></div>
        </div>
	</div>
    
    </fieldset>
    </div>
	<div class="panel-footer text-center">
    <button type="submit" class="btn btn-primary">MODIFICAR CONTRASEÑA</button>
    </div>
</div>
</form>
</div>
</body>
</html>