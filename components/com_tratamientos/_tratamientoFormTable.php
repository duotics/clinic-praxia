<div class="card mb-2">
	<div class="card-body bg-primary bg-opacity-25">
		<div class="row">
			<div class="col-sm-6">
				<select name="listMed" id="listMed" class="form-select" data-val="<?php echo $idsTrat ?>"></select>
			</div>
			<div class="col-sm-6">
				<select name="listInd" id="listInd" class="form-select" data-val="<?php echo $idsTrat ?>"></select>
			</div>
		</div>
	</div>
</div>

<table class="table table-sm table-list table-bordered" id="tableTratDet" data-val="<?php echo $idsTrat ?>">
	<thead>
		<tr class="table-info">
			<th>GENERICO</th>
			<th>COMERCIAL</th>
			<th>PRESENT.</th>
			<th>DOSIS</th>
			<th>#</th>
			<th>PRES.</th>
			<th></th>
		</tr>
	</thead>
</table>

<script type="text/javascript">
	$(document).ready(function() {

		$('#listMed').select2({
			ajax: {
				url: RAIZp + 'json.medicamentos.php',
				dataType: 'json',
				delay: 400,
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
			},
			placeholder: 'Lista Medicamentos'
		});

		$('#listInd').select2({
			ajax: {
				url: RAIZp + 'json.indicaciones.php',
				dataType: 'json',
				delay: 400,
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								id: item.ID,
								text: item.IND
							};
						})
					};
				},
				cache: true
			},
			placeholder: 'Lista Indicaciones',
		});

		// Add event listener for opening and closing details
		$('#listMed').on('select2:select', function(e) {
			$(this).val('').trigger('change');
			var data = e.params.data;
			var idTrat = $(this).data('val'); // Get the selected value from the input list
			var dataAjax = {
				idt: idTrat,
				idMed: data.id,
				acc: "insTratDet"
			}; // Create an object with the data to be sent to the server
			console.log(dataAjax);
			sendDataAcc(dataAjax);
		});

		$('#listInd').on('select2:select', function(e) {
			$(this).val('').trigger('change');
			var data = e.params.data;
			var idTrat = $(this).data('val'); // Get the selected value from the input list
			var dataAjax = {
				idt: idTrat,
				idInd: data.id,
				acc: "insTratDet"
			}; // Create an object with the data to be sent to the server
			console.log(dataAjax);
			sendDataAcc(dataAjax);
		});



		function sendDataAcc(dataAjax) {
			var url = '_accTratDet.php';
			$.ajax({
				url: url,
				method: 'GET',
				data: dataAjax,
				success: function(response) {
					Toast.fire({
						icon: 'success',
						title: "Proceso correcto"
					});
					table.ajax.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					Toast.fire({
						icon: 'error',
						title: 'Error saving data: ' + textStatus + ' - ' + errorThrown
					})
				}
			});
		}


		var table = $('#tableTratDet').DataTable({
			ajax: {
				url: RAIZp + "json.tratamiento.detalle.php",
				dataSrc: "",
				data: {
					idt: $('#tableTratDet').data('val')
				}
			},
			ordering: false,
			createdRow: function(row, data, dataIndex) {
				if (data.TIPO === 'I') {
					// Add COLSPAN attribute
					$('td:eq(0)', row).attr('colspan', 6);

					// Center horizontally

					// Hide required number of columns
					// next to the cell with COLSPAN attribute
					$('td:eq(1)', row).css('display', 'none');
					$('td:eq(2)', row).css('display', 'none');
					$('td:eq(3)', row).css('display', 'none');
					$('td:eq(4)', row).css('display', 'none');
					$('td:eq(5)', row).css('display', 'none');

					// Update cell data
					this.api().cell($('td:eq(0)', row)).data(data.IND);
				}
			},

			columns: [{
					data: 'GEN'
				},
				{
					data: 'COM'
				},
				{
					data: 'PRE'
				},
				{
					data: 'CAN'
				},
				{
					data: 'NUM'
				},
				{
					data: 'DES'
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

		$('#tableTratDet tbody').on('click', '.delConDiag', function() {
			var row = $(this).closest('tr');
			var rowData = table.row(row).data();
			$.ajax({
				url: '_accTratDet.php',
				type: 'GET',
				data: {
					idtd: rowData.ID,
					acc: "delTratDet"
				},
				success: function() {
					Toast.fire({
						icon: 'success',
						title: "Proceso correcto"
					});
					table.ajax.reload();
				},
				error: function() {
					Toast.fire({
						icon: 'error',
						title: "Error al eliminar registro"
					});
				}
			});
		});

		$("#printerButton").trigger("click");
	});

	function showEdit(editableObj) {
		$(editableObj).css("background", "#FFF");
	}

	function saveToDatabase(editableObj, column, id) {
		$(editableObj).css("background", "#FFF url(../../assets/images/loader.gif) no-repeat right");
		$.ajax({
			url: "saveDetTrat.php",
			type: "POST",
			data: 'column=' + column + '&editval=' + editableObj.innerHTML + '&id=' + id,
			success: function(data) {
				$(editableObj).css("background", "#FDFDFD");
			}
		});
	}
</script>