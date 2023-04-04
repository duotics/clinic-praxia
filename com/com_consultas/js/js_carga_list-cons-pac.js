// JavaScript Document
$(function(){
	$("#box_cont_btn").click(function(event) {
		event.preventDefault();
		$("#box_cont").slideToggle();
		$("#box_cont").load("consultas_pac_list_cons.php",{idp:$("#idplh").val()});
	});
	//Mouseleave oculta panel historial
	$( "#box_cont" ).mouseleave(function(event) {
		event.preventDefault();
		$("#box_cont").slideUp();
	});
});