<div class="row">
	<div class="col-sm-12 col-lg-9">
		<div class="card mb-3">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<h4 class="border-bottom pb-3 mb-3">
							<i class="fa fa-user-md fa-lg"></i> Diagnosticos
							<a href="<?php echo route['c'] ?>com_comun/gest_diag.php" class="btn btn-info btn-sm float-end" data-fancybox="reload" data-type="iframe">
								<i class="fa-solid fa-folder-open"></i> Gestionar
							</a>
							<div class="clearfix"></div>
						</h4>

						<fieldset>
							<div class="mb-3">
								<select class="selDiag" data-val="<?php echo $idsCon ?>" style="width: 100%;">
								</select>
							</div>
							<div class="mb-3">
								<input type="text" class="form-control" name="diagD" id="diagD" placeholder="Otros Diagnósticos">
							</div>
							<div class="mb-3">
								<button type="button" class="setConDiagOtro btn btn-info btn-xs" data-val="<?php echo $idsCon ?>">AGREGAR</button>
							</div>
						</fieldset>
					</div>
					<div class="col-sm-12 col-md-6">
						<div id="consDiagDet">
							<?php include('consultaDetDiagSel.php') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-lg-3">
		<?php
		$lConDiagHist = $objCon->ConsultaInterfaz_ListDiagHist(); ?>
		<div class="card">
			<div class="card-header">Historial Diagnósticos</div>
			<?php echo $lConDiagHist ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#tableConDiag').DataTable({
			"ajax": {
				"url": RAIZp + "json.consulta.diagnosticos.php",
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
						return '<span class="delConDiag btn btn-danger btn-sm" data-id="' + row.ID + '"><i class="fa-solid fa-trash"></i></span>';
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

		// Initialize select2
		$('.selDiag').select2({
			ajax: {
				url: RAIZp + 'json.diagnosticos.php',
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