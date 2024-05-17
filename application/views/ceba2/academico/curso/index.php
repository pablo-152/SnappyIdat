<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('ceba2/header'); ?>
<?php $this->load->view('ceba2/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cursos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nuevo Curso" style="cursor:pointer; cursor: hand;" href="<?= site_url('Ceba2/Modal_Curso') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('Ceba2/Excel_Curso') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" style="margin-left:5px;"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="tabla">
                
                <table id="example" class="table table-hover table-bordered">
                    <thead >
                        <tr style="background-color: #E5E5E5;">
                            <th width="5%">Año</th>
                            <th width="11%">Grado</th>
                            <th width="11%">Grupo</th>
                            <th width="11%">Unidad</th>
                            <th width="5%">Turno</th>
                            <th width="5%" title="Inicio de Matrícula">Inicio Mat.</th>
                            <th width="5%" title="Fin de Matrícula">Fin Mat.</th>
                            <th width="5%" title="Inicio de Curso">Inicio Cur.</th>
                            <th width="5%" title="Fin de Curso">Fin Cur.</th>
                            <th width="3%" title="Cantidad de Registros">Reg.</th>
                            <th width="3%" title="Cantidad de Matriculados">Mat.</th>
                            <th width="3%" title="Activos">Act.</th>
                            <th width="3%" title="Cantidad que estan Asistiendo">Asi.</th>
                            <th width="3%" title="Pendiente de Pago">PP</th>
                            <th width="3%" title="Sin asistir">SA</th>
                            <th width="3%" title="Pendiente de Matrícula">PM</th>
                            <th width="3%" title="Finalizado">Fin.</th>
                            <th width="3%" title="Retirado">Ret.</th>
                            <th width="3%" title="Anulado">Anu.</th>
                            <th width="5%">Estado</th>
                            <td width="3%"></td>
                        </tr>
                    </thead>
                    <tbody >
                        <?php foreach($list_curso as $list) {  ?>                                           
                            <tr class="text-center">
                                <td><?php echo $list['nom_anio']; ?></td>
                                <td class="text-left"><?php echo $list['descripcion_grado']; ?></td>
                                <td class="text-left"><?php echo $list['grupo']; ?></td>
                                <td class="text-left"><?php echo $list['unidad']; ?></td>
                                <td><?php echo $list['nom_turno']; ?></td>
                                <td><?php echo $list['fec_inicio']; ?></td>
                                <td><?php echo $list['fec_fin']; ?></td>
                                <td><?php echo $list['inicio_curso']; ?></td>
                                <td><?php echo $list['fin_curso']; ?></td>
                                <td><?php echo $list['cant_registrado'] ?></td>
                                <td><?php echo $list['cant_matriculado'] ?></td>
                                <td><?php echo $list['cant_activo'] ?></td>
                                <td><?php echo $list['cant_asistiendo'] ?></td>
                                <td><?php echo $list['cant_ppendiente'] ?></td>
                                <td><?php echo $list['cant_sinasistir'] ?></td>
                                <td><?php echo $list['cant_pmatricula'] ?></td>
                                <td><?php echo $list['cant_finalizados'] ?></td>
                                <td><?php echo $list['cant_retirado'] ?></td>
                                <td><?php echo $list['cant_anulado'] ?></td>
                                <td>
                                    <span class="badge" style="background:<?php echo $list['color']; ?>;color: white;"><?php echo $list['nom_status']; ?></span>
                                </td>
                                <td>
                                    <a title="Detalle del Curso" href="<?= site_url('Ceba2/Detalles_Curso') ?>/<?php echo $list["id_curso"]; ?>">
                                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" 
                                        style="cursor:pointer; cursor: hand;" width="22" height="22" />
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
        $("#academico").addClass('active');
        $("#hcurso").attr('aria-expanded','true');
        $("#curso").addClass('active');
        document.getElementById("rcurso").style.display = "block";

        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

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
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        });
    } );
</script>

<?php $this->load->view('ceba2/validaciones'); ?>
<?php $this->load->view('ceba2/footer'); ?>