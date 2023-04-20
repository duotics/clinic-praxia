$(document).ready(function () {
  $(".datatable").DataTable({
    order: [],
    stateSave: true,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json",
      decimal: ",",
      thousands: ".",
    },
  }); //Datatable.js basic initialitation

  //TOAS INITIALIZATION
  $(".toast").toast("show");

  Fancybox.bind("[data-fancybox]", {
    //
  });

  Fancybox.bind('[data-fancybox="form"]', {
    on: {
      destroy: (fancybox, slide) => {
        parent.location.reload(true);
      },
    },
  });

  Fancybox.bind('[data-fancybox="reload"]', {
    on: {
      destroy: (fancybox, slide) => {
        parent.location.reload(true);
      },
    },
  });

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

  tinymce.init({
    selector: "textarea.tmcem",
    body_class: "contProdDes cero",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor",
    ],
    toolbar1:
      "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor emoticons | code",
    //toolbar2: " preview media | forecolor backcolor emoticons",
    image_advtab: true,
    convert_urls: false,
    extended_valid_elements: "i[class],strong/b",
    invalid_elements: "",
    content_css: [
      RAIZ + "vendor/twbs/bootstrap/dist/css/bootstrap.min.css",
      RAIZ + "vendor/fortawesome/font-awesome/css/all.css",
    ],
  });

  tinymce.init({
    selector: "textarea.tmcef",
    body_class: "contProdDes",
    plugins: [
      "lists",
      "advlist",
      "autolink",
      "link",
      "image",
      "charmap",
      "preview",
      "pagebreak",
      "searchreplace",
      "wordcount",
      "visualblocks",
      "visualchars",
      "code",
      "fullscreen",
      "insertdatetime",
      "media",
      "nonbreaking",
      "save",
      "table",
      "directionality",
      "emoticons",
      "template",
      "code",
      "fullscreen",
    ],
    toolbar1:
      "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | visualblocks visualchars wordcount | searchreplace",
    toolbar2:
      " code fullscreen preview | forecolor backcolor emoticons  | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
    image_advtab: true,
    convert_urls: false,
    verify_html: false,
    extended_valid_elements: "i[*],strong/b",
    invalid_elements: "",
    content_css: [
      RAIZ + "node_modules/bootstrap/dist/css/bootstrap.min.css",
      RAIZ + "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
    ],
    height: "480",
  });

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
  //Verify Acction SAVE Buttons DATABASE - original
  $("#vAcc").on("click", function () {
    var $btn = $(this).button("loading");
    if (confirm("Esta seguro ?") == true) {
      $("form").submit(function (evt) {
        if (!$("form").validate()) {
          evt.preventDefault();
        }
      });
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
    if (!paramTit) paramTit = "Esta seguro ?";
    if (!paramText) paramText = "Precaución!";
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

  $(".vAccF").on("click", function (e) {
    var link = this;
    var paramTit = $(this).attr("data-title");
    var paramText = $(this).attr("data-text");
    if (!paramTit) paramTit = "Are you sure ?";
    if (!paramText) paramText = "Danger";
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
});

// JavaScript Document
//Personal FUnctions

//show loading bar
function showLoading() {
  $("#logF").css({ visibility: "visible" }).css({ opacity: "1" });
}
//hide loading bar
function hideLoading() {
  $("#logF").fadeTo(500, 0);
}
//COPY TO CLIPBOARD
function copyTextToClipboard(text) {
  var textArea = document.createElement("textarea");
  // *** This styling is an extra step which is likely not required. ***
  // Why is it here? To ensure:
  // 1. the element is able to have focus and selection.
  // 2. if element was to flash render it has minimal visual impact.
  // 3. less flakyness with selection and copying which **might** occur if the textarea element is not visible.
  // The likelihood is the element won't even render, not even a flash, so some of these are just precautions. However in IE the element  visible whilst the popup box asking the user for permission for the web page to copy to the clipboard.
  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = "fixed";
  textArea.style.top = 0;
  textArea.style.left = 0;
  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = "2em";
  textArea.style.height = "2em";
  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;
  // Clean up any borders.
  textArea.style.border = "none";
  textArea.style.outline = "none";
  textArea.style.boxShadow = "none";
  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = "transparent";
  textArea.value = text;
  document.body.appendChild(textArea);
  textArea.select();
  try {
    var successful = document.execCommand("copy");
    var msg = successful ? "successful" : "unsuccessful";
    console.log("Copying text command was " + msg);
  } catch (err) {
    console.log("Oops, unable to copy");
  }
  document.body.removeChild(textArea);
}

//imprimir seleccion -->
function imprSelec(nombre) {
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(" ", "popimpr");
  ventimp.document.write(ficha.innerHTML);
  ventimp.document.close();
  ventimp.print();
  ventimp.close();
}
