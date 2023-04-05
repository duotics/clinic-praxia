// JavaScript Document
var web="sesion_detail.php";
function show_det_ses(id_ses, id_ter){
	var loading = $("#loading");
	var cont_ses = $("#cont_ses");
	showLoading();
	//load selected section
	cont_ses.slideToggle();
	cont_ses.load(web,{ses_sel_find:id_ses, ter_sel_find:id_ter}, hideLoading);
	cont_ses.slideToggle();
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