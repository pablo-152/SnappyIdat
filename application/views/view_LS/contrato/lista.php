<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden Pendiente</th>  
            <th class="text-center">Orden Todos</th> 
            <th class="text-center" width="5%">Contrato</th>  
            <th class="text-center" width="4%">Cod</th> 
            <th class="text-center" width="8%" title="Apellido Paterno">Ap. Paterno</th>
            <th class="text-center" width="8%" title="Apellido Materno">Ap. Materno</th>
            <th class="text-center" width="10%">Nombre(s)</th>
            <th class="text-center" width="10%">Apoderado</th> 
            <th class="text-center" width="5%" title="Parentescto">Paren.</th>
            <th class="text-center" width="10%">Email</th>
            <th class="text-center" width="6%">Celular</th>  
            <th class="text-center" width="6%" title="Fecha Envío">Fecha E.</th>
            <th class="text-center" width="6%" title="Hora Envío">Hora E.</th>
            <th class="text-center" width="6%" title="Fecha Firma">Fecha F.</th>
            <th class="text-center" width="6%" title="Hora Firma">Hora F.</th>
            <th class="text-center" width="4%">Status</th> 
            <th class="text-center" width="6%"></th>
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
                <td class="text-left"><?php echo $list['nom_apoderado']; ?></td>
                <td><?php echo $list['parentesco_apoderado']; ?></td> 
                <td class="text-left"><?php echo $list['email_apoderado']; ?></td> 
                <td><?php echo $list['celular_apoderado']; ?></td> 
                <td><?php echo $list['fec_envio']; ?></td>
                <td><?php echo $list['hora_envio']; ?></td>
                <td><?php echo $list['fec_firma']; ?></td>  
                <td><?php echo $list['hora_firma']; ?></td>      
                <td><span class="badge" style="background:<?php echo $list['color_status'] ?>;"><?php echo $list['nom_status']; ?></span></td>                                               
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('LeadershipSchool/Modal_Update_Email_Contrato') ?>/<?php echo $list['id_documento_firma']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <a title="Reenviar Correo" onclick="Reenviar_Email('<?php echo $list['id_documento_firma']; ?>')">
                        <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png"> 
                    </a>

                    <?php if($list['estado_d']==2 && ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85 || $_SESSION['usuario'][0]['id_nivel']==6)){ ?>
                        <a title="Eliminar" onclick="Delete_Contrato('<?php echo $list['id_documento_firma']; ?>')">
                            <img src="<?= base_url() ?>template/img/eliminar.png">
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