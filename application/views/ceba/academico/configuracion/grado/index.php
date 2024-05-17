<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('ceba/header'); ?>
<?php $this->load->view('ceba/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Grados (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo grado" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ceba/Modal_Grado') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Grado" />
                        </a>
                        <a href="<?= site_url('Ceba/Excel_Grado') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
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
                            <th class="text-center" width="80%">Descripción</th>
                            <th class="text-center" width="15%">Estado</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>

                    <tbody >
                        <?php foreach($list_grado as $list) {  ?>                                           
                            <tr class="even pointer text-center">
                                <td class="text-left"><?php echo $list['descripcion_grado']; ?></td>
                                <td><?php echo $list['nom_status']; ?></td>                                                       
                                <td>
                                    <img title="Editar Datos Grado" data-toggle="modal" data-target="#acceso_modal_mod" 
                                    app_crear_mod="<?= site_url('Ceba/Modal_Update_Grado') ?>/<?php echo $list["id_grado"]; ?>" 
                                    src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;"/>

                                    <img title="Eliminar" onclick="Delete_Grado('<?php echo $list['id_grado']; ?>')" id="delete_grado"
                                    src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer;"/>
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
        $("#grados").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

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
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        } );
    });

    function Delete_Grado(id){
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

        var url="<?php echo site_url(); ?>Ceba/Delete_Grado";
        
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
                    data: {'id_grado':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Ceba/Grado";
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('ceba/footer'); ?>