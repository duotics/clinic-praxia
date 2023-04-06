// JavaScript Document
$(function () {
  var loading = $("#loading");
  var web = RAIZc + "com_pacientes/pacientes_detail.php";
  var urlBus = $("#locUrl").data("url");
  var paramBus = $("#locUrl").data("param");

  $("#tags").autocomplete({
    source: RAIZp + "json.pacientes.php", //availableTags,
    select: function (event, ui) {
      if (paramBus) {
        webForm = urlBus + "?" + paramBus + "=" + ui.item.code;
      } else {
        webForm = urlBus + ui.item.code;
      }

      console.log(webForm);
      //$(location).attr('href', webForm);
    },
    /*focus: function (event, ui) {
			console.log(ui.item.code);
			//showDetCli(ui.item.code);
		}*/
  });

  function showDetCli(codCli) {
    showLoading();
    if (codCli > 0) {
      $("#cont_cli").load(web, { cli_sel_find: codCli, acc: "2" }, hideLoading);
    } else {
      alert("Seleccione Un Cliente");
    }
  }
  //show loading bar
  function showLoading() {
    loading.css({ visibility: "visible" }).css({ opacity: "1" });
  }
  //hide loading bar
  function hideLoading() {
    loading.fadeTo(200, 0);
  }
});
