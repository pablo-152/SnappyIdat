<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden Pendiente</th>  
            <th class="text-center">Orden Todos</th> 
            <th class="text-center" width="5%">Contrato</th> 
            <th class="text-center" width="4%">Cod</th>   
            <th class="text-center" width="7%" title="Apellido Paterno">Ap. Paterno</th>
            <th class="text-center" width="7%" title="Apellido Materno">Ap. Materno</th>
            <th class="text-center" width="12%">Nombre(s)</th>
            <th class="text-center" width="15%">Email</th>
            <th class="text-center" width="6%">Celular</th>
            <th class="text-center" width="4%" title="Módulo">Mod.</th>
            <th class="text-center" width="6%" title="Fecha Envío">Fecha E.</th>
            <th class="text-center" width="6%" title="Hora Envío">Hora E.</th>
            <th class="text-center" width="6%" title="Fecha Firma">Fecha F.</th>
            <th class="text-center" width="6%" title="Hora Firma">Hora F.</th>
            <th class="text-center" width="4%">Arpay</th> 
            <th class="text-center" width="5%">Status</th>  
            <th class="text-center" width="7%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_nuevos as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['fecha_envio']; ?></td>
                <td><?php echo $list['fecha_firma']; ?></td>
                <td><?php echo $list['referencia']; ?></td> 
                <td><?php echo $list['cod_alumno']; ?></td>
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>
                <td class="text-left"><?php echo $list['email_alumno']; ?></td>
                <td><?php echo $list['celular_alumno']; ?></td>
                <td><?php echo $list['modulo_alumno']; ?></td>
                <td><?php echo $list['fec_envio']; ?></td>
                <td><?php echo $list['hora_envio']; ?></td>
                <td><?php echo $list['fec_firma']; ?></td>     
                <td><?php echo $list['hora_firma']; ?></td>    
                <td><?php echo $list['v_arpay']; ?></td>   
                <td><span class="badge" style="background:<?php echo $list['color_status'] ?>;"><?php echo $list['nom_status']; ?></span></td>                                             
                <td>
                    <a title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('AppIFV/Modal_Update_Email_Contrato_Efsrt') ?>/<?php echo $list['id_documento_firma']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <a title="Reenviar Correo" onclick="Reenviar_Email_Efsrt('<?php echo $list['id_documento_firma']; ?>')">
                        <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png">
                    </a>

                    <?php if($list['estado_d']==3 && $list['arpay']==0){ ?>
                        <a title="Validar en Arpay" onclick="Validar_Arpay('<?php echo $list['id_documento_firma']; ?>')">
                            <img src="<?= base_url() ?>template/img/check.png">
                        </a>
                    <?php } ?>

                    <?php if($list['estado_d']==2 && ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85 || $_SESSION['usuario'][0]['id_nivel']==6)){ ?>
                        <a title="Eliminar" onclick="Delete_Contrato('<?php echo $list['id_documento_firma']; ?>')">
                            <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php if($tipo==1){ ?> 
    <script>
        $(document).ready(function() {
            $('#example thead tr').clone(true).appendTo( '#example thead' );
            $('#example thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();

                if(title==""){
                    $(this).html('');
                }else{
                    $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
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

            var table = $('#example').DataTable( {
                order: [[0,"desc"]],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 16 ]
                    },
                    {
                        'targets' : [ 0,1 ],
                        'visible' : false
                    } 
                ]
            } );
        });
    </script>
<?php }else{ ?>
    <script>
        $(document).ready(function() {
            $('#example thead tr').clone(true).appendTo( '#example thead' );
            $('#example thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();

                if(title==""){
                    $(this).html('');
                }else{
                    $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
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

            var table = $('#example').DataTable( {
                order: [[1,"desc"]],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 16 ]
                    },
                    {
                        'targets' : [ 0,1 ],
                        'visible' : false
                    } 
                ]
            } );
        });
    </script>
<?php } ?>