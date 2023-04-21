<div class="table-responsive">
	<table class="table" id="tableConDiag" data-val="<?php echo $idsCon ?>">
		<thead>
			<tr>
				<th>ID</th>
				<th>COD</th>
				<th>Diagnostico</th>
				<th></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#tableConDiag').DataTable({
			"ajax": {
				"url": URLp+"json.consulta.diagnosticos.php",
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

	});
</script>