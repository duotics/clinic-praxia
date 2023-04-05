// JavaScript Document
function getDataVal(id,val,acc,res){
	$.get( RAIZ+"system/fnc/gen.php", { id: id, val: val, acc:acc, res:res}, function( data ) {
		$("#"+res).html(data.val);
	}, "json" );
}