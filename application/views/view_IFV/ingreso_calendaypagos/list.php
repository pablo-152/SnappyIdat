<table class="table table-hover table-bordered table-striped" id="example" width="100%">
	<thead>
		<tr style="background-color: #E5E5E5;">
			<th width="5%" class="text-center">Codigo</th>
			<th width="5%" class="text-center">DNI</th>
			<th width="10%" class="text-center">Ape. Paterno</th>
			<th width="10%" class="text-center">Ape. Materno</th>
			<th width="10%" class="text-center">Nombres</th>
			<th width="5%" class="text-center">Especialidad</th>
			<th width="5%" class="text-center">Grupo</th>
			<th width="5%" class="text-center">Turno</th>
			<th width="5%" class="text-center">Modulo</th>
			<th width="5%" class="text-center">Ciclo</th>
			<th width="5%" class="text-center">Dia</th>
			<th width="5%" lass="text-center">Hora</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $item) {  ?>
			<tr class="pointer text-center odd">
				<td><?php echo $item['Codigo']; ?></td>
				<td><?php echo $item['dni']; ?></td>
				<td class="text-left"><?php echo $item['Apellido_Paterno']; ?></td>
				<td class="text-left"><?php echo $item['Apellido_Materno']; ?></td>
				<td class="text-left"><?php echo $item['Nombre']; ?></td>
				<td><?php echo $item['abreviatura']; ?></td>
				<td><?php echo $item['Grupo']; ?></td>
				<td><?php echo $item['turno']; ?></td>
				<td><?php echo $item['modulo']; ?></td>
				<td><?php echo $item['ciclo']; ?></td>
				<td><?php echo $item['dia']; ?></td>
				<td><?php echo $item['hora']; ?></td>
				<!--<td class="text-center">
					<img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Actualizar_Texto_Fut') ?>/<?php echo $item['id_texto']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
					<a href="#" class="" title="Eliminar" onclick="Eliminar_Texto_Fut('<?php echo $item['id_texto']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
				</td>-->
			</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('#example thead tr').clone(true).appendTo('#example thead');
		$('#example thead tr:eq(1) th').each(function(i) {
			var title = $(this).text();

			if (title == "") {
				$(this).html('');
			} else {
				$(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
			}

			$('input', this).on('keyup change', function() {
				if (table.column(i).search() !== this.value) {
					table
						.column(i)
						.search(this.value)
						.draw();
				}
			});
		});

		var table = $('#example').DataTable({
			orderCellsTop: true,
			fixedHeader: true,
			pageLength: 50,
			"aoColumnDefs": [{
				'bSortable': false,
				'aTargets': [2]
			}]
		});
	});
</script>
