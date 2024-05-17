<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('view_IFV/nav'); ?>


<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold">
                        <b><?php echo $get_id[0]['nom_examen'] ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('AppIFV/Examen_Efsrt') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered" >
                    <thead >
                        <tr style="background-color: #E5E5E5;">
                            <th width="76%" class="text-center"><div >Carrera</div></th>
                            <!--<th width="28%" class="text-center"><div >Área</div></th>
                            <th width="20%" class="text-center"><div >Orden</div></th>-->
                            <th width="10%" class="text-center"><div >N° Preguntas</div></th>
                            <th width="4%" class="text-center"><div ></div></th>
                        </tr>
                    </thead>

                    <tbody >
                        <?php foreach($list_carrera as $list) {  ?>                                           
                            <tr class="even pointer text-center">                                    
                                <td class="text-left"><?php 
                                $busqueda = in_array($list['id_carrera'], array_column($nombre_carrera, 'id_especialidad'));
                                if($busqueda != false){
                                    $posicion = array_search($list['id_carrera'], array_column($nombre_carrera, 'id_especialidad'));
                                    echo $nombre_carrera[$posicion]['nom_especialidad'];
                                } 
                                ?></td>
                                <!--<td class="text-left"><?php echo $list['nombre']; ?></td>
                                <td><?php echo $list['orden']; ?></td>-->
                                <td><?php echo $list['cantidad'] ?></td>
                                <td>
                                    <a title="Más Información" href="<?= site_url('AppIFV/Preguntas_Efsrt') ?>/<?php echo $list['id_carrera']; ?>/<?php echo $get_id[0]['id_examen'] ?>">
                                        <img title="Lista de Preguntas" src="<?= base_url() ?>template/img/ver.png"  style="cursor:pointer; cursor: hand;">
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
        $("#practicas").addClass('active');
        $("#hpracticas").attr('aria-expanded', 'true');
        $("#examenes_efsrt").addClass('active');
		document.getElementById("rpracticas").style.display = "block";


        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );

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
            order: [ 0, "asc" ],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0 ]
                } 
            ]
        } );
    } );
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>