// JavaScript Document
var web=RAIZ+"com/com_empleados/empleados_detail.php";

$(document).ready(function() {
	var loading = $("#loading");
	var cont_emp = $("#cont_emp");
	var btn_cons_emp = $(".btn_cons_emp");
	var btn_list_emp = $(".btn_list_emp");
	var id_find_emp = $(".id_find_emp");
	var id_list_emp = $(".id_list_emp2");

	//Manage click events
	btn_cons_emp.click(function(){
		//show the loading bar
		showLoading();
		//load selected section
		var id_emp = id_find_emp.attr("value");
		if (id_emp>0){
				cont_emp.slideUp();
				cont_emp.load(web,{emp_sel_find:id_emp, acc:"2"}, hideLoading);
				cont_emp.slideDown();
		}else{
			hideLoading();
			alert("Seleccione Un Cliente");
		}
	});
	
	//show loading bar
	function showLoading(){
		loading
			.css({visibility:"visible"})
			.css({opacity:"1"})
			.css({display:"block"})
		;
	}

	//hide loading bar
	function hideLoading(){
		loading.fadeTo(200, 0);
	};
});
function show_det_emp_list(id_emp){
	
	var loading = $("#loading");
	var cont_emp = $("#cont_emp");
	
	showLoading();
	//load selected section
	cont_emp.slideUp();
	cont_emp.load(web,{emp_sel_find:id_emp}, hideLoading);
	cont_emp.slideDown();
	hideLoading();

	//show loading bar
	function showLoading(){
		loading
			.css({visibility:"visible"})
			.css({opacity:"1"})
			.css({display:"block"})
		;
	}

	//hide loading bar
	function hideLoading(){
		loading.fadeTo(200, 0);
	};
};