<table class="table table-hover table-bordered table-striped" id="example" width="100%">
	<thead>
		<tr style="background-color: #E5E5E5;">
			<th class="text-center" width="18%">Institución</th>
			<th class="text-center" width="18%">Departamento</th>
			<th class="text-center" width="18%">Provincia</th>
			<th class="text-center" width="18%">Distrito</th>
			<th class="text-center" width="16%">Tipo de Gestión</th>
			<th class="text-center" width="6%">Estado</th>
			<th class="text-center" width="6%"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $item) {  ?>
			<tr class="even pointer ">
				<td><?php echo $item['institucion']; ?></td>
				<td><?php echo $item['nombre_departamento']; ?></td>
				<td><?php echo $item['nombre_provincia']; ?></td>
				<td><?php echo $item['nombre_distrito']; ?></td>
				<td><?php echo $item['nombre_tipo_gestion']; ?></td>
				<td class="text-center"><span class="badge" style="background-color:<?php echo $item['color']; ?>;"><?php echo $item['nom_status']; ?></span></td>
				<td class="text-center">
					<img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Actualizar_Colegio_Prov') ?>/<?php echo $item['id']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
					<a href="#" class="" title="Eliminar" onclick="Eliminar_Colegio_Prov('<?php echo $item['id']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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
				'aTargets': [ 6 ]
			}]
		});
	});
</script>
