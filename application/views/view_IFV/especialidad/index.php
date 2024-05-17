<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Especialidad (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('AppIFV/Modal_Especialidad') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel">
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_Especialidad') ?>">
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
                            <th class="text-center" width="10%">Licenciamiento</th>
                            <th class="text-center" width="10%">Código</th>
                            <th class="text-center" width="45%">Nombre</th>
                            <th class="text-center" width="10%">N° Módulos</th>
                            <th class="text-center" width="10%">Estado</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_especialidad as $list){ ?>                                           
                            <tr class="even pointer text-center">
                                <td><?php echo $list['nom_licenciamiento']; ?></td>   
                                <td><?php echo $list['abreviatura']; ?></td>                                               
                                <td class="text-left"><?php echo $list['nom_especialidad']; ?></td>
                                <td><?php echo $list['nmodulo']; ?></td>
                                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>    
                                <td>
                                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Especialidad') ?>/<?php echo $list['id_especialidad']; ?>">
                                        <img src="<?= base_url() ?>template/img/editar.png">
                                    </a>

                                    <a title="Editar" href="<?= site_url('AppIFV/Detalle_Especialidad') ?>/<?php echo $list['id_especialidad']; ?>">
                                        <img src="<?= base_url() ?>template/img/ver.png">
                                    </a>

                                    <a href="#" class="" title="Eliminar" onclick="Delete_Especialidad('<?php echo $list['id_especialidad']; ?>')"  role="button"> 
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
        $("#configuraciones").addClass('active');
        $("#hconfiguraciones").attr('aria-expanded', 'true');
        $("#especialidades").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";
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
            "order": [[ 1, "asc" ]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );

    function Delete_Especialidad(id){
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Especialidad";

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
                    data: {'id_especialidad':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Especialidad";
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>