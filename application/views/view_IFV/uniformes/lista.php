
<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="8%" class="text-center" title="Apellido Paterno">Ap. Paterno</th>
            <th width="8%" class="text-center" title="Apellido Materno">Ap. Materno</th>
            <th width="10%" class="text-center">Nombre(s)</th>
            <th width="4%" class="text-center">Código</th>
            <th width="20%" class="text-center">Especialidad</th> 
            <th width="4%" class="text-center">Grupo</th>            
            <th width="5%" class="text-center">Turno</th>
            <th width="4%" class="text-center" title="Módulo">Mod.</th>
            <th width="4%" class="text-center" title="Sección">Sec.</th>
            <th width="6%" class="text-center">Matrícula</th>
            <th width="5%" class="text-center">Alumno</th>
            <th width="4%" class="text-center">Uniformes</th>
            <th width="4%" class="text-center" title="Documentos">Monto</th>
            <th width="5%" class="text-center" title="Fotocheck">FV11/F12</th>
            <th width="4%" class="text-center"></th>
            <th width="4%" class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_matriculado as $list){  ?>
            <tr class="even pointer text-center" <?php if($list['Alumno']=="Bloqueado"){ ?> style="background-color:#FFF3DF;" <?php } ?>>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Codigo']; ?></td> 
                <td class="text-left"><?php echo $list['Especialidad']; ?></td>
                <td><?php echo $list['Grupo']; ?></td>
                <td><?php echo $list['Turno']; ?></td>
                <td><?php echo $list['Modulo']; ?></td>
                <td><?php echo $list['Seccion']; ?></td>
                <td><?php echo $list['Matricula']; ?></td>
                <td><span class="badge" style="background:#9cd5d1;"><?php echo $list['Alumno']; ?></span></td>
                <td><?php echo $list['foto']; ?></td>
                <td><?php if($list['documentos_obligatorios']-$list['documentos_subidos']==2){ echo "Si"; }else{ echo "No"; } ?></td>
                <td><?php echo $list['v_fotocheck']; ?></td>
                <td>
                </td>
                <td nowrap>
                    <!--<a title="Editar Datos" href="<?= site_url('AppIFV/V_Editar_Retirar') ?>/<?php echo $list['Id']; ?>">
                        <img title="Retirar" src="<?= base_url() ?>template/img/retirar.png" style="cursor:pointer;"/>
                    </a> -->
                    <a title="Editar Datos" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Uniforme_Fuera') ?>/<?php echo $list['Id']; ?>">
                        <img class="top" src="<?= base_url() ?>template/img/editar.png" alt="">
                    </a>
                    <!--<a title="Editar Observación" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Obs_Uniforme') ?>/<?php echo $list['Id']; ?>/<?php echo $list['Codigo']; ?>/<?php echo $tipo ?>">
                        <img title="Editar Datos" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;"/>
                    </a>-->
                    <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Matriculados_C') ?>/<?php echo $list['Id']; ?>"> 
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
                    </a>
                    <?php if($list['id_foto']!=""){ ?>
                        <a onclick="Descargar_Foto_Matriculados_C('<?php echo $list['id_foto']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                    <?php }?>
                </td>
            </tr>
        <?php  }?>
    </tbody>
</table>

<script>
   $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title=""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example').DataTable({
            order: [[5,"asc"],[4,"asc"],[6,"asc"],[7,"asc"],[8,"asc"],[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100
        });

    } );
</script>

