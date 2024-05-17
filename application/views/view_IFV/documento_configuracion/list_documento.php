<table class="table table-hover table-bordered table-striped" id="example" width="100%">
	<thead>
		<tr style="background-color: #E5E5E5;">
			<th width="10%">Codigo</th>
			<th width="17%">Nombre</th>
			<th width="10%">Asunto</th>
			<th width="17%">Tipo</th>
			<th width="10%">Texto</th>
			<!--<th  width="10%">De</th>-->
			<th class="text-center" width="3%"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list_documento as $documento) {  ?>
			<tr class="even pointer ">
				<td><?php echo $documento['codigo']; ?></td>
				<td><?php echo $documento['nombre']; ?></td>
				<td><?php echo $documento['asunto']; ?></td>
				<td><?php echo $documento['nom_status']; ?></td>
				<td><?php echo $documento['texto']; ?></td>
				<td class="text-center">
					<img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Actualizar_Documento_Configuracion') ?>/<?php echo $documento['id_documento']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
					<a href="#" class="" title="Eliminar" onclick="Eliminar_Documento_Configuracion('<?php echo $documento['id_documento']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
				</td>
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
