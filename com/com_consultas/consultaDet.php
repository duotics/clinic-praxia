<?php include_once('../../init.php');

use App\Models\Diagnostico;

$mDiag = new Diagnostico;
if (!isset($vVT)) {
	$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
	$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
}
$detCon = detRow('db_consultas', 'con_num', $idc);
?>
<?php if ($idc) { ?>
	<div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tabCA" aria-controls="home" role="tab" data-toggle="tab">Datos de la Consulta</a></li>
			<li role="presentation"><a href="#tabCB" aria-controls="profile" role="tab" data-toggle="tab">Examen Físico</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="tabCA">
				<?php include('consultaDetMot.php') ?>
				<?php include('consultaDetDiag.php') ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="tabCB">
				<?php include('consultaDetExamFis.php') ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			// Initialize select2
			$('.selDiag').select2({
				ajax: {
					url: 'json.diagnosticos.php',
					dataType: 'json',
					delay: 500,
					data: function(params) {
						return {
							q: params.term
						};
					},
					processResults: function(data) {
						return {
							results: data
						};
					},
					cache: true
				}
			});

			// Add event listener for opening and closing details
			$('.selDiag').on('select2:select', function(e) {
				$(this).val('').trigger('change');
				var data = e.params.data;
				var idc = $(this).data('val'); // Get the selected value from the input list
				var dataAjax = {
					idc: idc,
					idd: data.id,
					acc: "insConsDiag"
				}; // Create an object with the data to be sent to the server
				var url = '_accConDiag.php';
				$.ajax({
					url: url,
					method: 'GET',
					data: dataAjax,
					success: function(response) {
						console.log('Data saved successfully: ' + response);
						table.ajax.reload();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log('Error saving data: ' + textStatus + ' - ' + errorThrown);
					}
				});
			});
			var table = $('#tableConDiag').DataTable({
				"ajax": {
					"url": "json.consulta.diagnosticos.php",
					dataSrc: "",
					"data": {
						"ids": $('#tableConDiag').data('val')
					}
				},
				"columns": [{
						"data": "ID",
						visible: false,
					},
					{
						"data": "COD"
					},
					{
						"data": "NOM"
					},
					{
						data: null,
						render: function(data, type, row) {
							return '<span class="delConDiag btn btn-danger btn-xs" data-id="' + row.ID + '">Eliminar</span>';
						}
					}
				],
				"language": {
					"emptyTable": "No se encontraron registros",
					"info": "",
					"infoEmpty": ""
				},
				"paging": false,
				"searching": false
			});

			$('#tableConDiag tbody').on('click', '.delConDiag', function() {
				var row = $(this).closest('tr');
				var rowData = table.row(row).data();
				$.ajax({
					url: '_accConDiag.php',
					type: 'GET',
					data: {
						id: rowData.ID,
						acc: "delConDiag"
					},
					success: function() {
						table.ajax.reload();
					},
					error: function() {
						alert('Error deleting row');
					}
				});
			});

			// Reload data from the server and redraw the table

			$('.setConDiagOtro').on('click', function() {
				var idc = $(this).attr("data-val");
				var name = $('#diagD').val();
				console.log(idc + name);
				var dataAjax = {
					idc: idc,
					data: name,
					acc: "insConsDiagOther"
				}; // Create an object with the data to be sent to the server
				var url = '_accConDiag.php';
				$.ajax({
					url: url,
					method: 'GET',
					data: dataAjax,
					success: function(response) {
						console.log('Data saved successfully: ' + response);
						table.ajax.reload();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log('Error saving data: ' + textStatus + ' - ' + errorThrown);
					}
				});
				$('#diagD').val('');
				table.ajax.reload();
			});
		});
	</script>
<?php } else { ?>
	<div class="alert alert-warning">
		<h4>Primero Guarde la Consulta</h4><?php echo $btn_action_form ?? null ?>
	</div>
<?php } ?>