<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<?php

		$sql = $conn->query(" SELECT
asistencia.id_asistencia,
asistencia.employee_id,
asistencia.entrada,
asistencia.salida,
employee_list.employee_id,
employee_list.firstname as 'nom_empleado',
employee_list.lastname,
employee_list.cedula
FROM
asistencia
INNER JOIN employee_list ON asistencia.employee_id = employee_list.id");

		?>
		<div class="card-body">
			<div class="text-right mb-2">
				<a href="fpdf/ReporteAsistencia.php" target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i> Generar reportes</a>
			</div>
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">EMPLEADO</th>
						<th scope="col">CEDULA</th>
						<th scope="col">ENTRADA</th>
						<th scope="col">SALIDA</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($datos = $sql->fetch_object()) { ?>
						<tr>
							<td><?= $datos->id_asistencia ?></td>
							<td><?= $datos->nom_empleado . " " . $datos->lastname ?></td>
							<td><?= $datos->cedula ?></td>
							<td><?= $datos->entrada ?></td>
							<td><?= $datos->salida ?></td>
						</tr>
					<?php }
					?>


				</tbody>
			</table>
		</div>

	</div>
</div>
<script>
	$(document).ready(function() {
		$('#list').dataTable()
		$('.view_asistencias').click(function() {
			uni_modal("<i class='fa fa-id-card'></i> Detalles de Asistencias", "view_asistencias.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_asistencia').click(function() {
			_conf("¿Estás seguro de eliminar a este registro?", "delete_asistencia", [$(this).attr('data-id')])
		})
	})

	function delete_asistencia($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_asistencia',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Datos Eliminados", 'proceso exitoso')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>