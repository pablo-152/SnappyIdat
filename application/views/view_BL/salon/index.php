<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Salón (Lista)</b></span></h4>
                </div>

                <div class="heading-elements"> 
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" href="<?= site_url('BabyLeaders/Registrar_Salon') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo">
                        </a>

                        <a href="<?= site_url('BabyLeaders/Excel_Salon') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center" width="5%">Planta</th>
                            <th class="text-center" width="9%">Ref.</th>    
                            <th class="text-center" width="15%">Tipo</th>
                            <th class="text-center" width="18%">Descripción</th>
                            <th class="text-center" width="5%">AE</th>
                            <th class="text-center" width="5%">CF</th>
                            <th class="text-center" width="5%">DS</th>
                            <th class="text-center" width="5%">ET</th>
                            <th class="text-center" width="5%">FT</th>
                            <th class="text-center" width="8%">Capacidad</th>
                            <th class="text-center" width="8%">Disponible</th>
                            <th class="text-center" width="7%">Estado</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_salon as $list) {  ?>                                           
                            <tr class="even pointer text-center">
                                <td><?php echo $list['planta']; ?></td>
                                <td><?php echo $list['referencia']; ?></td>   
                                <td class="text-left"><?php echo $list['nom_tipo_salon']; ?></td>   
                                <td class="text-left"><?php echo $list['descripcion']; ?></td>   
                                <td><?php echo $list['ae']; ?></td>                                                   
                                <td><?php echo $list['cf']; ?></td>   
                                <td><?php echo $list['ds']; ?></td>         
                                <td><?php echo $list['et']; ?></td>   
                                <td><?php echo $list['ft']; ?></td>         
                                <td><?php echo $list['capacidad']; ?></td>   
                                <td><?php echo $list['disponible']; ?></td>         
                                <td><?php echo $list['estado_salon']; ?></td>        
                                <td>
                                    <a title="Editar" href="<?= site_url('BabyLeaders/Editar_Salon') ?>/<?php echo $list['id_salon']; ?>">
                                        <img src="<?= base_url() ?>template/img/editar.png">
                                    </a>
                                    <a href="#" class="" title="Eliminar" onclick="Delete_Salon('<?php echo $list['id_salon']; ?>')" role="button"> 
                                        <img src="<?= base_url() ?>template/img/eliminar.png">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded', 'true');
        $("#salones").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";
    });
</script>

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

        var table=$('#example').DataTable( {
            order: [[0,'asc'],[1,'asc']],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 12 ]
                }
            ]
        } );
    } );
    
    function Delete_Salon(id){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url="<?php echo site_url(); ?>BabyLeaders/Delete_Salon";
        
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_salon':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>BabyLeaders/Salon";
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_BL/footer'); ?>