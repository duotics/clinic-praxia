<?php include('../../init.php');
$Auth->vLogin('CALENDAR');
$css['body']='bgcal';
include(RAIZf.'head.php'); ?>
<script src="js/js_calendar_1.0.js"></script>
<?php sLOG('g') ?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
	<div class="container-fluid">
		<h1 id='loading'>loading...</h1>
		<div class="well" style="background:#fff">
    		<div id='calendar'></div>
    	</div>
    </div>
<?php include(RAIZf."footer.php");?>