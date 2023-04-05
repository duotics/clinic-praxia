<?php include('../../init.php'); ?>
<?php include(root['f'].'head.php'); ?>
<script>
$(document).ready(function() {
$('#calendar').fullCalendar('today');
$('#calendar').fullCalendar({
	header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
	},
	lang: "es",
	editable: true,
	weekends: true,
	dayClick: function(date, jsEvent, view) {
		var urlAge='form.php?datefc='+date.format();
		loadFancyBoxEvent(urlAge);
	},
	eventClick: function(calEvent, jsEvent, view) {
		var urlAge='form.php?id='+calEvent.id;
		loadFancyBoxEvent(urlAge);
	},
	eventDrop: function(calEvent, jsEvent, view) {
		setDB(calEvent.id,calEvent.start.format(),calEvent.end.format())
	},
	eventResize: function(calEvent, jsEvent, view) {
		setDB(calEvent.id,calEvent.start.format(),calEvent.end.format())
	},
	events: {
		url: 'php/get-events-php.php',
		error: function() {
			$("#logF").slideDown(200).text("Error Carga json").delay(3800).slideUp(200);
		}
	},
	selectable: true,
	selectHelper: true,
	select: function(start, end) {
		var urlAge='form.php?datefc='+start.format()+'&datefe='+end.format();
		alert (urlAge);
		loadFancyBoxEvent(urlAge);
		$('#calendar').fullCalendar('unselect');
	},
	loading: function(bool) {
		$('#loading').toggle(bool);
	}
});

function loadFancyBoxEvent(urlAge){
	//alert("OK");
	$.fancybox({
		type: 'iframe',
		href: urlAge,
		title: 'Reserva',
		preload  : true,
		autoSize : false,
		width    : "90%",
		height   : "90%",
		beforeClose: function() {
			$('#calendar').fullCalendar('refetchEvents');
   		}
	});
};

function setDB_old(id, start, end){
	//alert(campo+"-"+valor);
	$.get( "actionsJS.php", { id: id, start: start, end: end}, function( data ) {
		showLoading();
		hideLoading();
		$("#logF").slideDown(200).text(data.inf).delay(3800).slideUp(200);
	}, "json" );
	$('#calendar').fullCalendar('refetchEvents');
}	

});
</script>
<style>
	#loading {
		display: none;
		position: absolute;
		top: 10px;
		right: 10px;
	}
</style>
</head>
<body>
	<div class="container">
		<div id="logF"></div>
		<div id='loading'>loading...</div>
		<div class="well">
    		<div id='calendar'></div>
    	</div>
    </div>
</body>
</html>
