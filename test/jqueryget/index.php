<?php include('../../init.php');
include(root['f'].'head.php');
?>
<script type="text/javascript">
$.get( "json.php", { name: "nombre", time: "hora" }, function( data ) {
  alert(data.name+"***"+data.time)
}, "json" );
</script>