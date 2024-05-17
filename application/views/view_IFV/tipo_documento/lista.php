<table class="table table-hover table-bordered table-striped" id="example" width="100%">
	<thead>
		<tr style="background-color: #E5E5E5;">
			<th width="10%">Tipo</th>
			<th width="10%">Estado</th>
			<!--<th width="17%">Texto</th>-->
			<!--<th  width="10%">De</th>-->
			<th class="text-center" width="3%"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $item) {  ?>
			<tr class="even pointer ">
				<td><?php echo $item['nom_status']; ?></td>
				<td><?php echo $item['estado']; ?></td>
				<!--<td><?php echo $item['texto']; ?></td>-->
				<td class="text-center">
					<img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Actualizar_Tipo_Documento') ?>/<?php echo $item['id_status_general']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
					<a href="#" class="" title="Eliminar" onclick="Eliminar_Tipo_Documento('<?php echo $item['id_status_general']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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
