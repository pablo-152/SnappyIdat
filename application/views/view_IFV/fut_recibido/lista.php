<table class="table table-hover table-bordered table-striped" id="example" width="100%">
	<thead>
		<tr style="background-color: #E5E5E5;">
			
			<th width="7%">Cód. FUT</th> 
			<th width="5%">Fecha</th>
			<th width="10%">Producto</th>
            <!--<th width="30%">Texto</th>-->
			<th width="5%">DNI</th>
			<th width="5%">Código</th>		
			<th width="10%">Nombre del Alumno</th>
            <th width="10%">Apellido Paterno</th>
			<th width="10%">Apellido Materno</th>
			<th width="10%">Especialidad</th>
			<th width="8%">Estado</th>
			<th width="1%"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $item) {  ?>
			<tr class="even pointer">
				
				<td><?php echo $item['cod_fut'] ?></td>
				<td><?php echo date('d/m/Y',strtotime(substr($item['fec_reg'],0,10)))  ?></td>
                <td><?php echo $item['nom_producto'] ?></td>
				<!--<td><?php echo $item['texto_fut_corto'] ?></td>-->
				<td><?php echo $item['Dni'] ?></td>
				<td><?php echo $item['Codigo'] ?></td>
				<td><?php echo $item['nom_alumno'] ?></td>
				<td><?php echo $item['Apellido_Paterno'] ?></td>
				<td><?php echo $item['Apellido_Materno'] ?></td>
				<td><?php echo $item['Especialidad'] ?></td>
				<td><?php echo $item['nom_status'] ?></td>
				<td>
					<a title="Más Información" href="<?= site_url('AppIFV/Historial_Fut_Recibido') ?>/<?php echo $item['id_envio']; ?>">
                            <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;"/>
                        </a>
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
			"aoColumnDefs": [
				{
					'bSortable': false,
					'aTargets': [ 10 ]
				}
			]
		});
	});
</script>
