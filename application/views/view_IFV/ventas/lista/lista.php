<table class="table table-hover table-bordered table-striped" id="example" width="100%">
	<thead>
		<tr style="background-color: #E5E5E5;">
			<th class="text-center" width="10%">Código</th>
			<th class="text-center" width="20%" title="Producto">Producto</th> 
			<th class="text-center" width="5%" title="Código">Cod.</th>
			<th class="text-center" width="10%">Ap. Paterno</th>
			<th class="text-center" width="10%">Ap. Materno</th>
			<th class="text-center" width="15%">Nombre(s)</th> 
			<th class="text-center" width="4%">Esp.</th>
			<th class="text-center" width="4%">Grupo</th>
			<th class="text-center" width="3%">Sec.</th>
            <th class="text-center" width="8%" title="Monto Entregado">Monto Ent.</th>
			<th class="text-center" width="8%">Fecha Pago</th>
			<th class="text-center" width="3%"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list_venta as $list){ ?> 
			<tr class="even pointer text-center">
                <td><?php echo $list['cod_venta']; ?></td>
				<td class="text-left"><?php echo $list['productos']; ?></td>
				<td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
				<td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
				<td class="text-left"><?php echo $list['Nombre']; ?></td>
				<td class="text-center"><?php echo $list['Abreviatura']; ?></td>
				<td><?php echo $list['Grupo']; ?></td>
				<td><?php echo $list['Seccion']; ?></td>
				
				<td class="text-right"><?php echo "s/. ".$list['monto_entregado']; ?></td>
				<td><?php echo $list['fecha_pago']; ?></td>
				<td>

                    <a title="Documento" href="<?= site_url('AppIFV/Recibo_Venta') ?>/<?php echo $list['id_venta']; ?>" target="_blank">
                        <img src="<?= base_url() ?>template/img/icono_impresora.png">
                    </a>
                   
						<!--
                    <?php if($list['estado_venta']==1 && $list['anulado']==0){ ?>
                        <a title="Devolución" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('Laleli/Modal_Anular_Venta') ?>/<?php echo $list['id_venta']; ?>">
                            <img src="<?= base_url() ?>template/img/devolucion.png">
                        </a>
                    <?php } ?>
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
				'aTargets': [ 11 ]
			}]
		});
	});
</script>