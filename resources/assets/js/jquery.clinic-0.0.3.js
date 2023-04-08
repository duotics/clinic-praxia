// JavaScript Document
$(document).ready(function () {
  $(".setDB").on("keyup change", function () {
    console.log("setDB2 v2");
    //var temp=$(this).val();
    var campo = $(this).attr("name");
    var valor = $(this).val();
    var cod = $(this).attr("data-id");
    var tbl = $(this).attr("data-rel");
    setDB(campo, valor, cod, tbl);
  });

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
  function closePrintView() {
    //document.location.href = 'somewhere.html';
    parent.location.reload();
  }

  $(window).bind("keydown", function (event) {
    if (event.ctrlKey || event.metaKey) {
      switch (String.fromCharCode(event.which).toLowerCase()) {
        case "s":
          event.preventDefault();
          if ($("#vAcc").length > 0) {
            $("#vAcc").click();
          } else {
            alert("No Existe Boton de Accion");
          }
          break;
        /* case 'f': event.preventDefault(); alert('ctrl-f'); break;
				case 'g': event.preventDefault(); alert('ctrl-g'); break; */
      }
    }
  });
  //Verify Acction SAVE Buttons DATABASE
  $("#vAcc").on("click", function () {
    var $btn = $(this).button("loading");
    if (confirm("Esta seguro?") == true) {
      $("form").submit();
    } else {
      $btn.button("reset");
    }
  });

  //Verifi Action of button, submit in a List interface (table tr td list)
  $(".vAccTM").on("click", function (e) {
    var $btn = $(this).button("loading");
    var paramTit = $(this).attr("data-title");
    var paramText = $(this).attr("data-text");

    var r = confirm(paramTit);
    if (r == true) {
      $("form").submit();
    } else {
      e.preventDefault();
      $btn.button("reset");
    }
  });
  $(".vAccL").on("click", function (e) {
    var link = this;
    var paramTit = $(this).attr("data-title");
    var paramText = $(this).attr("data-text");
    if (paramText == "" || paramText == null) paramText = "Esta seguro?";
    e.preventDefault();
    $("<div>" + paramText + "</div>").dialog({
      title: paramTit,
      buttons: {
        Aceptar: function () {
          $(this).dialog("close");
          window.location = link.href;
        },
        Cancelar: function () {
          $(this).dialog("close");
        },
      },
      show: { effect: "blind", duration: 400 },
      minWidth: 350,
    });
  });
  $(".vAccT").on("click", function (e) {
    var link = this;
    var paramTit = $(this).attr("data-title");
    var paramText = $(this).attr("data-text");
    e.preventDefault();
    $("<div>" + paramText + "</div>").dialog({
      title: paramTit,
      buttons: {
        Aceptar: function () {
          $(this).dialog("close");
          $("form").submit();
        },
        Cancelar: function () {
          $(this).dialog("close");
        },
      },
      show: { effect: "blind", duration: 400 },
      minWidth: 350,
    });
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  //TOOLTIPS BS
  $(".tooltips").tooltip({ html: true });
  var contlog = $("#log");
  contlog.delay(3800).slideUp(200);
  //FANCYBOX
  var loading = $("#loading");
  /*
  $(".fancybox").fancybox();
  $(".fancyreload").fancybox({
    autoSize: false,
    width: "95%",
    height: "95%",
    beforeClose: function () {
      location.reload();
    },
  });
  $(".fancyMed").fancybox({
    autoSize: false,
    width: "60%",
    height: "90%",
    beforeClose: function () {
      location.reload();
    },
  });
  $(".fancyclose").fancybox({
    autoSize: true,
    beforeClose: function () {
      location.reload();
    },
  });
  */
  //
});

// JavaScript Document
function getDataVal(id, val, acc, res) {
  $.get(
    RAIZ + "system/fnc/gen.php",
    { id: id, val: val, acc: acc, res: res },
    function (data) {
      $("#" + res).html(data.val);
    },
    "json"
  );
}

function setDB(campo, valor, cod, tbl, acc = null) {
  $.get(
    RAIZc + "com_comun/actionsJS.php",
    {
      campo: campo,
      valor: valor,
      cod: String(cod),
      tbl: tbl,
      acc: acc,
    },
    function (data) {},
    "json"
  )
    .done(function (data) {
      showLoading();
      console.log("SetDB done. " + data.inf);
      $("#logF").show(100).text(data.inf).delay(3000).hide(200);
      hideLoading();
    })
    .fail(function (data) {
      console.log("SetDB fail. " + data.inf);
    });
}

//Tiny MCE
tinymce.init({
  selector: "textarea.tinymce",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table contextmenu paste",
  ],
  toolbar:
    "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
});
tinymce.init({
  selector: "textarea.tinymcemin",
  menubar: false,
});

tinymce.init({
  selector: "textarea.tmceExam",
  menubar: false,
  plugins: "autoresize",
});

tinymce.init({
  selector: "textarea.tmceExamE",
  menubar: false,
  plugins: ["autoresize", "code"],
  toolbar1: " code",
});

tinymce.init({
  selector: "textarea.tmceDB",
  menubar: false,
  toolbar:
    "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
  setup: function (ed) {
    ed.on("keyup", function (e) {
      var field = ed.id;
      var id = $(".tmceDB").attr("data-id");
      var cont = ed.getContent();
      setDB(field, cont, id);
    });
  },
});

//imprimir seleccion -->
function imprSelec(nombre) {
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(" ", "popimpr");
  ventimp.document.write(ficha.innerHTML);
  ventimp.document.close();
  ventimp.print();
  ventimp.close();
}
function showLoading() {
  $("#loading").css({ visibility: "visible" }).css({ opacity: "1" });
}
//hide loading bar
function hideLoading() {
  $("#loading").fadeTo(200, 0);
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
