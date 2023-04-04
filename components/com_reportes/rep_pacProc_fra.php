<div class="row">
	<div class="col-md-4">
    <h4>Seleccione Rango de Fechas</h4>
	</div>
    <div class="col-md-8">
    	<div id="cont_cli">
        <form class="form-inline" method="get">
    		<div class="form-group"><label for="exampleInputEmail2">Fecha Inicial</label>  
                <input name="FI" type="date" class="form-control" id="FI" value="<?php echo $_GET['FI'] ?>" /></div>
            <div class="form-group"><label for="exampleInputEmail2">Fecha Final</label> 
                <input name="FF" type="date" class="form-control" id="FF" value="<?php echo $_GET['FF'] ?>" /></div>
            <button type="submit" class="btn btn-primary">Consultar</button>
            
		</form>
        </div>
    </div>
</div>