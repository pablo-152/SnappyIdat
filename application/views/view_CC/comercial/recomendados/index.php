<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Recomendados (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group"> 
                        <a title="Configurar SMS" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('Administrador/Modal_Configurar_Sms') ?>" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/configurar_sms.png" alt="Configurar SMS" />
                        </a> 

                        <a href="<?= site_url('Administrador/Excel_Recomendados') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="filtro_tabla" value="<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="lista_alumno">
                <table id="example" class="table table-hover table-bordered table-striped" width="100%">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th width="6%" class="text-center" title="DNI Alumno">DNI A.</th>
                            <th width="6%" class="text-center">Código</th>
                            <th width="16%" class="text-center">Especialidad</th>
                            <th width="11%" class="text-center">Validado</th>
                            <th width="10%" class="text-center">Registro</th>
                            <th width="6%" class="text-center" title="DNI Recomendado">DNI R.</th>
                            <th width="6%" class="text-center">Celular</th>
                            <th width="15%" class="text-center">Correo Electrónico</th>
                            <th width="10%" class="text-center">Estado</th>
                            <th width="11%" class="text-center">Validado</th>
                            <th width="4%" class="text-center"></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_recomendado as $list){ ?>
                            <tr class="even pointer text-center">
                                <td><?php echo $list['dni_alumno']; ?></td>
                                <td><?php echo $list['codigo']; ?></td>
                                <td class="text-left"><?php echo $list['especialidad']; ?></td>
                                <td class="text-left"><?php echo $list['validado1']; ?></td>
                                <td><?php echo $list['registro']; ?></td>
                                <td><?php echo $list['dni_recomendado']; ?></td>
                                <td><?php echo $list['celular']; ?></td>
                                <td class="text-left"><?php echo $list['correo']; ?></td>
                                <td class="text-left"><?php echo $list['estado_r']; ?></td>
                                <td class="text-left"><?php echo $list['validado2']; ?></td>
                                <td>
                                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                                    app_crear_mod="<?= site_url('Administrador/Modal_Update_Recomendados') ?>/<?php echo $list['id_recomendado']; ?>" 
                                    src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;">
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
        $("#comercial").addClass('active');
        $("#hcomercial").attr('aria-expanded','true');
        $("#recomendados").addClass('active');
        document.getElementById("rcomercial").style.display = "block";

        var filtro_tabla =  $('#filtro_tabla').val();

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

        if(filtro_tabla == 1 || filtro_tabla == 6){
            var table = $('#example').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 25,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 10 ]
                    }
                ]
            });
        }else{
            var table = $('#example').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 21,
                "aoColumnDefs" : [ 
                    {
                        'targets' : [ 10 ],
                        'visible' : false
                    }
                ]
            });
        }
    });
</script>

<?php $this->load->view('Admin/footer'); ?>