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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>RRHH (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="<?= site_url('AppIFV/Excel_Rrhh') ?>">
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
                            <th class="text-center" width="10%" title="Apellido Paterno">A. Paterno</th>
                            <th class="text-center" width="10%" title="Apellido Materno">A. Materno</th>
                            <th class="text-center" width="10%">Nombre</th>
                            <th class="text-center" width="5%" title="Código">Cod.</th>
                            <th class="text-center" width="7%" title="Tipo Documento">Tipo Doc.</th>
                            <th class="text-center" width="6%" title="Número Documento">Nr. Doc.</th>
                            <th class="text-center" width="6%" title="Fecha Nacimiento">F. Nac.</th>
                            <th class="text-center" width="6%">Cargo</th>
                            <th class="text-center" width="6%">AE</th>
                            <th class="text-center" width="6%">CF</th> 
                            <th class="text-center" width="6%">DS</th>
                            <th class="text-center" width="6%">ET</th>
                            <th class="text-center" width="6%">FT</th>
                            <th class="text-center" width="6%">Estado</th>
                            <th class="text-center" width="4%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_rrhh as $list){   
                            $id_rrhh = "";
                            $ae = "";
                            $cf = "";
                            $ds = "";
                            $et = "";
                            $ft = "";
                            $busqueda = in_array($list['Id'], array_column($rrhh, 'EmployeeId'));
                            if($busqueda != false){
                                $posicion = array_search($list['Id'], array_column($rrhh, 'EmployeeId'));
                                $id_rrhh = $rrhh[$posicion]['id_rrhh'];
                                $ae = $rrhh[$posicion]['ae'];
                                $cf = $rrhh[$posicion]['cf'];
                                $ds = $rrhh[$posicion]['ds'];
                                $et = $rrhh[$posicion]['et'];
                                $ft = $rrhh[$posicion]['ft'];
                            } ?>                                           
                            <tr class="even pointer text-center">
                                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>   
                                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>         
                                <td class="text-left"><?php echo $list['Nombre']; ?></td>   
                                <td><?php echo $list['Codigo']; ?></td>                                                   
                                <td><?php echo "DNI"; ?></td>   
                                <td><?php echo $list['Dni']; ?></td>         
                                <td><?php echo $list['Fecha_Nacimiento']; ?></td>   
                                <td class="text-left"><?php echo $list['Cargo']; ?></td>     
                                <td><?php echo $ae; ?></td>         
                                <td><?php echo $cf; ?></td>   
                                <td><?php echo $ds; ?></td>         
                                <td><?php echo $et; ?></td>   
                                <td><?php echo $ft; ?></td>     
                                <td><?php echo "Activo"; ?></td>        
                                <td>
                                    <?php if($id_rrhh==""){ ?>
                                        <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal" 
                                        app_crear_per="<?= site_url('AppIFV/Modal_Rrhh') ?>/<?php echo $list['Id']; ?>"
                                        src="<?= base_url() ?>template/img/editar.png">
                                    <?php }else{ ?>
                                        <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                                        app_crear_mod="<?= site_url('AppIFV/Modal_Update_Rrhh') ?>/<?php echo $id_rrhh; ?>" 
                                        src="<?= base_url() ?>template/img/editar.png">
                                    <?php } ?>
                                    <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Rrhh') ?>/<?php echo $list['Id']; ?>">
                                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
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
        $("#rrhhs").addClass('active');
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 14 ]
                }
            ]
        } );
    } );
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>