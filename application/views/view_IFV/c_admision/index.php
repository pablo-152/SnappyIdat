<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Admisión (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                            <img >
                            <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal" 
                                        app_crear_per="<?= site_url('AppIFV/Modal_C_Admision') ?>"
                                        src="<?= base_url() ?>template/img/nuevo.png">
                        <a onclick="Excel_C_Admision();" style="margin-left: 5px;">
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
                <table id="example" class="table table-hover table-bordered table-striped" width="100%">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th width="10%" class="text-center">Grupo</th>
                            <th width="10%" class="text-center">Esp.</th>
                            <th width="20%" class="text-center">Modalidad</th>
                            <th width="10%" class="text-center">Turno</th>
                            <th width="10%" class="text-center">Inicio</th>
                            <th width="10%" class="text-center">Fin</th>
                            <th width="10%" class="text-center">Estado</th>
                            <th width="3%" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <?php /*foreach ($list_c_admision as $list){ 
                            $id_grupo = "";
                            $estado = "Todos";
                            $busqueda = in_array($list['Grupo'], array_column($list_grupo, 'grupo'));
                            if($busqueda != false){
                                $posicion = array_search($list['Grupo'], array_column($list_grupo, 'grupo'));
                                $id_grupo = $list_grupo[$posicion]['id_grupo'];
                                $estado = $list_grupo[$posicion]['estado'];
                                    if($estado==1){
                                        $estado = "Activos";
                                    }
                                    else if($estado>1){
                                        $estado = "Todos";
                                    }
                                else{
                                    $estado = "Todos";
                                }
                            }
                            ?>
                            <tr class="even pointer text-center">
                                <td><?php echo $list['Grupo']; ?></td>
                                <td><?php echo $estado; ?></td>
                                <td>
                                    <?php if($id_grupo==""){ ?>
                                        <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal" 
                                        app_crear_per="<?= site_url('AppIFV/Modal_C_Admision') ?>/<?php echo str_replace('/','_',$list['Grupo']); ?>"
                                        src="<?= base_url() ?>template/img/editar.png">
                                    <?php }else{ ?>
                                        <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                                        app_crear_mod="<?= site_url('AppIFV/Modal_Update_C_Admision') ?>/<?php echo $id_grupo; ?>" 
                                        src="<?= base_url() ?>template/img/editar.png">
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }*/ ?>-->
                        <?php foreach ($list_c_admision as $list){ ?>
                            <tr class="even pointer text-center">
                                <td><?php echo $list['grupo']; ?></td>
                                <td><?php echo $list['esp_grupo']; ?></td>
                                <td><?php echo $list['mod_grupo']; ?></td>
                                <td><?php echo $list['tur_grupo']; ?></td>
                                <td><?php echo $list['inicio_grupo']; ?></td>
                                <td><?php echo $list['fin_grupo']; ?></td>
                                <td><span class="badge" style="background:<?php echo $list['color']; ?>;"><?php echo $list['estado']; ?></span></td>
                                <td><img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                                        app_crear_mod="<?= site_url('AppIFV/Modal_Update_C_Admision') ?>/<?php echo $list['id_grupo'];; ?>" 
                                        src="<?= base_url() ?>template/img/editar.png"></td>
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
        $("#c_admisiones").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";

        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
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
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 2 ]
                }
            ]
        });
    });

    function Excel_C_Admision(){
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_C_Admision";
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>