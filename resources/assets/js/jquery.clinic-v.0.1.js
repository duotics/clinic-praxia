// JavaScript Document
$(document).ready(function () {
  // Add event listeners to the form controls
  $(".setDB").on("change blur", function () {
    handleFormControlEvents($(this));
  });

  $(".setTab").on("click", function () {
    var val = $(this).data("val");
    var com = $(this).data("rel");
    $.get(
      RAIZp + "js.setTab.php",
      {
        val: val,
        com: com,
      },
      function (data) {},
      "json"
    )
      .done(function (data) {
        if (data.status === true) {
          console.log("Tab set: " + data.data);
        } else {
          console.log("Tab not set: " + data.log);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log(
          "Ha ocurrido un error en la solicitud: " + jqXHR.responseText
        );
      });
  });

  /* 
  OLD CODE 
  */

  $("#loaderFrame")
    .on("load", function () {
      var w = this.contentWindow || this.contentDocument.defaultView;
      w.print();
      //setTimeout("closePrintView()", 3000);
      setTimeout(function () {
        w.close();
        parent.location.reload();
        //alert('cerrado');
      }, 500);
    })
    .on("error", function () {
      // código que se ejecuta si hay un error al cargar el iframe
      console.log("error");
    });

  //$("#loaderFrame").load(function () {});

  $("#diags").autocomplete({
    source: RAIZc + "com_pacientes/json.php", //availableTags,
    select: function (event, ui) {
      //alert(ui.item.code);
      openDetCli(ui.item.code);
    },
    /*focus: function (event, ui) {
			console.log(ui.item.code);
			//showDetCli(ui.item.code);
		}*/
  });

  $(".printerButton").click(function () {
    var id = $(this).attr("data-id");
    var src = $(this).attr("data-rel");
    var val = $(this).attr("data-val");
    $("#loaderFrame").attr("src", src + "?id=" + id + "&val=" + val);
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  //TOOLTIPS BS
  $(".tooltips").tooltip({ html: true });
  var contlog = $("#log");
  contlog.hide().delay(200).slideDown(250).delay(1000).slideUp(300);
});
/*
END DOCUMENT READY
*/

//FUNCTIONS

function closePrintView() {
  //document.location.href = 'somewhere.html';
  parent.location.reload();
}

function handleFormControlEvents(control) {
  // Get the form control values
  var campo = control.attr("name");
  var valor = control.val();
  var cod = control.data("id");
  var tbl = control.data("rel");
  var acc = control.data("acc");

  // Handle input (keyup) event
  if (control.is('input[type="text"]')) {
    // Add any additional logic to handle the input value here
  }

  // Handle checkbox (change) event
  if (control.is('input[type="checkbox"]')) {
    valor = control.is(":checked") ? "1" : "0";
    // Add any additional logic to handle the checkbox value here
  }

  // Handle select (change) event
  if (control.is("select")) {
    // Add any additional logic to handle the select value here
  }

  // Call the AJAX function to send the form data
  sendFormData(campo, valor, cod, tbl, acc);
}

// Define a function to send the form data via AJAX
function sendFormData(campo, valor, cod, tbl, acc = null) {
  $.post(
    RAIZp + "json.actions.php",
    {
      campo: campo,
      valor: valor,
      cod: cod,
      tbl: tbl,
      acc: acc,
    },
    function (data) {},
    "json"
  )
    .done(function (data) {
      //showLoading();
      console.log("SetDB done. " + data.inf);
      $("#logF").show().text(data.inf);
      //hideLoading();
    })
    .fail(function (data) {
      console.log("SetDB fail. " + data.inf);
    });
}

// JavaScript Document
function getDataVal(id, val, acc, res) {
  console.log("getDataVal() - " + id);
  $.get(
    RAIZp + "json.helper.php",
    { id: id, val: val, acc: acc, res: res },
    function (data) {
      $("#" + res).html(data.ret);
    },
    "json"
  );
}

var ansclose = false;
window.onbeforeunload = ansout;
function ansout() {
  if (ansclose) return "Precaución de Cierre!";
}

function getRow(table, fiel, param, ford, pord) {
  $.ajax({
    method: "POST",
    url: url,
    data: { table: "db_examenes_format", field: "id", param: valSel },
    dataType: "json",
  }).done(function (msg) {
    alert("Data Saved: " + msg.log);
  });
}
