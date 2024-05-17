<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
        <th width="8%" class="text-center" title="Apellido Paterno">Ap. Paterno</th>
        <th width="8%" class="text-center" title="Apellido Materno">Ap. Materno</th>
        <th width="10%" class="text-center">Nombre(s)</th>
        <th width="4%" class="text-center">Código</th>
        <th width="6%" class="text-center">Celular</th>
        <th width="8%" class="text-left">Correo Institucional</th>
        <th width="8%" class="text-left">Correo Personal</th>
        <th width="4%" class="text-center">Grupo</th>
        <th width="4%" class="text-center">Especialidad</th> 
        <th width="5%" class="text-center">Turno</th>
        <th width="4%" class="text-center" title="Módulo">Mod.</th>
        <th width="4%" class="text-center" title="Sección">Sec.</th>
        <th width="6%" class="text-center">Matrícula</th>
        <th width="5%" class="text-center">Alumno</th>
        <th width="4%" class="text-center">Sexo</th>
        <th width="2%" class="text-center">Edad</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_alumno as $list){ ?>
            <tr class="even pointer text-center" <?php if($list['Alumno']=="Bloqueado"){ ?> style="background-color:#FFF3DF;" <?php } ?>>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td> 
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Codigo']; ?></td> 
                <td><?php echo $list['Celular']; ?></td> 
                <td><?php echo $list['Correo_Institucional']; ?></td> 
                <td><?php echo $list['Email']; ?></td> 
                <td><?php echo $list['Grupo']; ?></td>
                <td class="text-center"><?php echo $list['Especialidad_Abreviatura']; ?></td>
                <td><?php echo $list['Turno']; ?></td>
                <td><?php echo $list['Modulo']; ?></td>
                <td><?php echo $list['Seccion']; ?></td>
                <td><?php echo $list['Matricula']; ?></td>
                <td><span class="badge" style="background:#9cd5d1;"><?php echo $list['Alumno']; ?></span></td>
                <td><?php echo $list['Sexo']; ?></td>
                <td><?php echo $list['Edad']; ?></td>
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