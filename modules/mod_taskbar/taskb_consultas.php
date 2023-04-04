<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-7">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">CONSULTAS</a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-7">
    	<a href="<?php echo $RAIZc ?>com_calendar/reserva_lista.php" class="btn btn-primary navbar-btn fancybox.iframe fancyreload">
        <span class="glyphicon glyphicon-plus-sign"></span> Consultas Reservadas</a>
        
        <a href="?sBr=+" class="btn btn-primary navbar-btn navbar-right">Total Pacientes <span class="badge"><?php echo fnc_totpac();?></span></a>
        <a href="<?php echo $RAIZc ?>com_consultas/consultas_list.php" class="btn btn-primary navbar-btn navbar-right">Total Consultas <span class="badge"><?php echo fnc_totCons();?></span></a>
	</div>
</nav>