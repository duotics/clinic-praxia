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
    if (confirm("Esta seguro?") == true) {
      $("form").submit();
    } else {
      $btn.button("reset");
    }
  });
});
