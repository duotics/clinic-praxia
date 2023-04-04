<!--LIBS JS-->
<script type="text/javascript" src="<?php echo $RAIZn ?>jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZn ?>jquery-ui/dist/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZn ?>bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo route['n'] ?>select2/dist/js/select2.min.js"></script>

<script type="text/javascript" src="<?php echo $RAIZv ?>mottie/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
<!-- Load TinyMCE -->
<script type="text/javascript" src="<?php echo $RAIZn ?>tinymce/tinymce.min.js"></script>
<!-- Add fancyBox JS -->
<script type="text/javascript" src="<?php echo $RAIZv ?>fancyapps/fancybox/source/jquery.fancybox.js"></script>
<!-- GRITTER -->
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery.gritter.min.js"></script>
<!--FULL CALENDAR-->
<script src='<?php echo $RAIZa ?>plugins/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo $RAIZa ?>plugins/fullcalendar/fullcalendar.min.js'></script>
<script src='<?php echo $RAIZa ?>plugins/fullcalendar/lang-all.js'></script>
<!--Chart.js-->
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/chart.js-3.4.1/package/dist/chart.min.js"></script>
<!-- Datatables -->
<script type="text/javascript" src="<?php echo $RAIZv ?>components/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZn ?>datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZn ?>datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<!--Personal Libs -->
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery.clinic-0.0.3.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datatable").DataTable({
            "order": [],
            stateSave: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json",
                decimal: ",",
                thousands: ".",
            }
        }); //Datatable.js basic initialitation
    });
</script>