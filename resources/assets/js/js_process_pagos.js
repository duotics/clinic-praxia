// JavaScript Document
// $(document).ready(function() {      -->    Necesita JQUERY
$(document).ready(function() {
	var web_pag_norm = "pagos_norm_act_save.php"//Pagina donde se enviará el Valor del Pago y el ID Paciente
	
	var sec_det_pag = $("#sec_det_pag");//Combobox Lista de pagos
	
	var lis_tip_pag = $("#lis_tip_pag");//Combobox Lista de pagos
	var btn_action = $("#btn_cobrar");//Boton Cobrar
	var det_pag = $("#det_pag");//Div_carga_detalle_pago
	var deuda = $("#deuda").attr("value");//Campo Hidden con valor de la Deuda
	var idp = $("#pac_sel_pag").attr("value");//Campo Hidden con ID_Cliente

	btn_action.click(function(){
		if((deuda=="")||(deuda==0))
			alert("Paciente No Tiene Deudas Pendientes");
		else
		{
			var tip_pag = lis_tip_pag.attr("value");
			
			if(tip_pag==1)
			{
				//BEGIN TIPO DE PAGO CONTADO
				var valor=prompt("Ingrese la Cantidad a pagar:","1");
				if(valor<"1")
					alert("El Pago debe ser mayor a 1 USD");
				else
				{
					if(valor>deuda)
					{
						alert("Valor Superior a la Deuda"+'\n'+"Se Cobra solo: "+deuda);
						valor=deuda;
					}
					if (confirm("Confirmar Pago: "+valor+".  Del Paciente: "+idp))
					{
						load_det_pag(valor,idp);
						//alert("Pago Relizado Exitosamente");

					}else
						alert("No Se Realiza el Pago");

					
				}
				//END TIPO DE PAGO CONTADO
			}
			else{
				alert("Solo Disponible PAGO DE CONTADO");
			}
			
		}
	});

	function load_det_pag(valor_send,idp_send){
	Shadowbox.open({
			content:    web_pag_norm+'?valor='+valor_send+'&idp='+idp_send,
			player:     "iframe",
			title:      "<strong>DETALLE PAGO***</strong>",
			width:		550,
			options: 	{relOnClose:true}
		});
	}

});
