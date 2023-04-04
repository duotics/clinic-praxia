// JavaScript Document
$(document).ready(function(){
	//$('#con_diagd').chosen({});	
	//var contlog = $("#log"); contlog.delay(3800).slideUp(200);
});

function setDB_old(campo, valor, cod, tbl){
	$.get( RAIZc+"com_comun/actionsJS.php", { campo: campo, valor: valor, cod: cod, tbl: tbl}, function( data ) {
		showLoading();
		$("#logF").show(100).text(data.inf).delay(3000).hide(200);
		hideLoading();
	}, "json" );
}
function getDataVal(id,val,acc,res){
	$.get( RAIZ+"system/fnc/gen.php", { id: id, val: val, acc:acc, res:res}, function( data ) {
		$("#"+res).html(data.val);
	}, "json" );
}