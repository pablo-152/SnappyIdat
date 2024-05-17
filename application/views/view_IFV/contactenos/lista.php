
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
	<thead>
		<tr style="background-color: #E5E5E5;">
			<th width="10%">Fecha</th>
			<th width="10%">Hora</th>
			<th width="17%">Nombre</th>
			<th width="10%">Celular</th>
			<th width="17%">Correo</th>
			<th width="10%">Motivo</th>
			<th width="10%">Estado</th>
			<th width="17%">Usuario</th>
			<th width="10%">Fecha</th>
			<th class="text-center" width="3%"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $item) {  ?>
			<tr class="even pointer ">
				<td><?php echo $item['fecha']; ?></td>
				<td><?php echo $item['hora']; ?></td>
				<td><?php echo $item['nombre']; ?></td>
				<td><?php echo $item['celular']; ?></td>
				<td><?php echo $item['email']; ?></td>
				<td><?php echo $item['titulo']; ?></td>
				<td><?php echo $item['nom_status']; ?></td>
				<td><?php echo $item['usuario']; ?></td>
				<td><?php echo $item['fecha_usuario']; ?></td>
				<td class="text-center"> 
					<?php $base_array = explode(",",$item['usuarios']);
						if (in_array($id_usuario,$base_array)){ ?>
						<img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
						app_crear_mod="<?= site_url('AppIFV/Modal_Actualizar_Contactenos') ?>/<?php echo $item['id_contacto']; ?>" 
						src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
					<?php } ?>
					<!--<a href="#" class="" title="Eliminar" onclick="Eliminar_Tipo_Documento('<?php /*echo $item['id_status_general'];*/ ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
					-->
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
