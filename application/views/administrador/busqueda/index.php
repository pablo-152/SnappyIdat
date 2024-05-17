<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>

<?php $this->load->view('Admin/nav'); ?>

<style>
    table {
        table-layout: fixed;
        margin: 0rem auto;
        width: 100%;
        border-collapse: collapse;
    }

    th:last-child{
        width: 5%;
    }

    table tbody tr td {
        font-size:12px;
        text-align:left;
    }
</style> 

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Proyectos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements" style="position: absolute;top: 50%;margin: -25px 0 0 -25px;">
                    <div class="heading-btn-group" >
                        <a onclick="Exportar_Proyectos();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="text-bold" for="id_status" >Año:</label>
                        <div class="col">
                            <select name="anio" id="anio" class="form-control" onchange="Cambiar_Anio()">
                                <?php foreach($list_anio as $list){ ?>
                                    <option value="<?php echo $list['anio']; ?>" <?php if($list['anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['anio'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div >
        <div class="container-fluid" >
            <div class="row">
                <div id="lista_busqueda2" class="col-lg-12">
                    <table class="table table-hover table-bordered table-striped" id="example">
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                                <th class="text-center" width="2%">Pri</th>
                                <th class="text-center" width="5%">Cód</th>
                                <th class="text-center" width="6%">Status</th>
                                <th class="text-center" width="4%">Emp</th>
                                <th class="text-center" width="5%">Sede</th>
                                <th class="text-center" width="8%">Tipo</th>
                                <th class="text-center" width="15%">SubTipo</th>
                                <th class="text-center" width="22%">Descripción</th>
                                <th class="text-center" width="8%">Snappy's</th>
                                <th class="text-center" width="7%">Agenda</th>
                                <th class="text-center" width="8%">Usu</th>
                                <th class="text-center" width="8%">Fecha</th>
                                <th class="text-center" width="7%">Usu</th>
                                <th class="text-center" width="8%">Fecha</th>
                                <td class="text-center" width="4%"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_proyecto as $row_p) {  ?>                                           
                                <tr <?php if($row_p['background']!='') { echo "style='background-color: ".$row_p['background'].";'";} ?> >
                                    <td class="text-center"><?php echo $row_p['prioridad']; ?></td>
                                    <td class="text-center"><?php if($row_p['duplicado']==1){echo utf8_encode($row_p['cod_proyecto'])."*";}else{echo utf8_encode($row_p['cod_proyecto']);} ?></td>
                                    <td class="text-center" style="background-color:<?php echo $row_p['color']; ?>"><?php echo $row_p['nom_statusp']; ?></td>
                                    <td class="text-center"><?php echo $row_p['cod_empresa']; ?> </td>
                                    <td class="text-center">  <?php echo $row_p['cod_sede'];  ?> </td>
                                    <td class="text-center" nowrap><?php echo $row_p['nom_tipo']; ?></td>
                                    <td nowrap><?php echo $row_p['nom_subtipo']; ?></td>
                                    <td style="max-width: 10px; overflow: hidden;" nowrap ><?php echo $row_p['descripcion']; ?></td>
                                    <td class="text-center"><?php echo $row_p['s_artes']+$row_p['s_redes']; ?></td>
                                    <td class="text-center"><?php if($row_p['duplicado']==1){ echo $row_p['fec_agenda_duplicado']; }else{ if ($row_p['fec_agenda']!='00/00/0000') echo $row_p['fec_agenda']; }  ?></td>
                                    <td class="text-center"><?php echo $row_p['ucodigo_solicitado']; ?></td>
                                    <td class="text-center"><?php if ($row_p['fec_solicitante']!='00/00/0000') echo $row_p['fec_solicitante']; ?></td>
                                    <td class="text-center"><?php echo $row_p['ucodigo_asignado']; ?></td>
                                    <td class="text-center"><?php if ($row_p['fec_termino']!='00/00/0000 00:00:00') echo $row_p['fec_termino'];?></td>
                                    <td class="text-center" >
                                        <?php  if($row_p['duplicado']!=1){ ?>
                                            <a type="button" title="Editar Proyecto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Busqueda2') ?>/<?php echo $row_p['id_proyecto']; ?>"> 
                                                <img src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;"/>
                                            </a>
                                            
                                            <?php if ($row_p['imagen']!='') { ?>
                                                <img src="<?= base_url() ?>template/img/ver.png" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $row_p['imagen']?>" title="Ver Imagen" style="cursor:pointer; cursor: hand;"/>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>
<div id="acceso_modal_mod" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>
<div id="acceso_modal_eli" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#siredes").addClass('active');
        $("#hiredes").attr('aria-expanded', 'true');
        $("#busqueda2_redes").addClass('active');
		document.getElementById("riredes").style.display = "block";
        document.getElementById("rcomunicacion").style.display = "block";
    });

    $(document).ready(function() {
        // Setup - add a text input to each footer cell
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14 ]
        } ]
        });
    });
</script>

<script>
    function Cambiar_Anio(){
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
        var anio=$('#anio').val();
        var url="<?php echo site_url(); ?>Administrador/Lista_Busqueda2";
        $.ajax({
            type:"POST",
            url:url,
            data: {'anio':anio},
            success:function (data) {
                $('#lista_busqueda2').html(data);
            }
        });
    }

    function Exportar_Proyectos(){
        var anio=$('#anio').val();
        window.location ="<?php echo site_url(); ?>Administrador/Excel_Lista_Proyecto/"+anio;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>

<div class="modal fade bd-example-modal-lg" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Imagen Subida</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div align="center" id="capital2"></div>
        <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url(); ?>'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
    $('#dataUpdate').on(
    'show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget)
        var imagen = button.data('imagen')
        var imagen2 = imagen.substr(-3)
        var rutapdf= $("#rutafoto").val(); // ruta de la imagen
        var nombre_archivo= rutapdf+imagen // tuta y nombre del archivo
    
        if (imagen2=="PDF" || imagen2=="pdf")
        {
        document.getElementById("capital2").innerHTML = "<iframe height='350px' width='350px' src='"+nombre_archivo+"'></iframe>";
        }
        else
        {
        document.getElementById("capital2").innerHTML = "<img height='400px' width='650px' src='"+nombre_archivo+"'>";
        }
        var modal = $(this)
        modal.find('.modal-title').text('Imagen Subida')
        $('.alert').hide();//Oculto alert
    }
    )


    // ADMINISTRDOR
    function Nuevo(){
    //var status = status;
    //alert(status);
        var url = "<?php echo site_url(); ?>Administrador/nuevo_proyect/";
        frm = { };
        $.ajax({
            url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
            $("#nuevo_proyect").html(contextResponse);
        })

    }
    // TEAMLIDER
    function Nuevo_Proy(){
        var url = "<?php echo site_url(); ?>Teamleader/nuevo_proyTeam/";
        frm = { };
        $.ajax({
            url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
            $("#nuevo_proyect").html(contextResponse);
        })

    }

    function Buscar(e,status){
        var status = status;
    // alert(status);
        var url = "<?php echo site_url(); ?>Administrador/Busqueda/";
        frm = { 'status': status};
        $.ajax({
            url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
            $("#tabla").html(contextResponse);
        })
    }

    function Editar(e,id_proyecto){
        var id_proyecto = id_proyecto;
    // alert(id_proyecto);
        var url = "<?php echo site_url(); ?>Administrador/Editar_proyect/";
        frm = { 'id_proyecto': id_proyecto};
        $.ajax({
            url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
            $("#nuevo_proyect").html(contextResponse);
        })
    }
</script>
