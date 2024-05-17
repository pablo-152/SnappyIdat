<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Admin/nav'); ?>
<main class="app-content">
    <div id="nuevo_proyect">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <div class="row tile-title line-head"  style="background-color: #C1C1C1;">
                                            <div class="col" style="vertical-align: middle;">
                                                <b>Lista de Proyectos</b>
                                            </div>
                                            <div class="col" align="right">
                                                <a title="Exportar Excel" onclick="Exportar_Proyectos()">
                                                    <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="toolbar">                  
                                        <div class="col-md-12 row mb-3">
                                            <div class="form-group col-md-1">
                                                <label class="control-label text-bold">Año:</label>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <select name="anio" id="anio" class="form-control" onchange="Cambiar_Anio()">
                                                    <?php foreach($list_anio as $list){ ?>
                                                        <option value="<?php echo $list['anio']; ?>" <?php if($list['anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['anio'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="busqueda_anio" class="box-body table-responsive">
                                        <table class="table table-bordered table-striped" style="font-size:12px" id="example">
                                            <thead>
                                                <tr style="background-color: #E5E5E5;">
                                                    <th width="5%">Pri</th>
                                                    <th width="5%">Cód</th>
                                                    <th width="5%">Status</th>
                                                    <th width="5%">Emp</th>
                                                    <th width="5%">Sede</th>
                                                    <th width="8%">Tipo</th>
                                                    <th width="8%">SubTipo</th>
                                                    <th width="18%">Descripción</th>
                                                    <th width="8%">Snappy's</th>
                                                    <th width="6%">Agenda</th>
                                                    <th width="5%">Usu</th>
                                                    <th width="6%">Fecha</th>
                                                    <th width="5%">Usu</th>
                                                    <th width="6%">Fecha</th>
                                                    <th width="7%">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($list_proyecto as $row_p) {  ?>                                           
                                                    <tr <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?> >
                                                        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['prioridad']; ?></td>
                                                        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo utf8_encode($row_p['cod_proyecto']); ?></td>
                                                        <td style="background-color:<?php echo $row_p['color']; ?>"><?php echo $row_p['nom_statusp']; ?></td>
                                                        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                                                            <?php 
                                                                $empresa="";
                                                                foreach($list_empresa as $list){
                                                                if($list['id_proyecto']==$row_p['id_proyecto']){
                                                                    $empresa=$empresa.$list['cod_empresa'].",";
                                                                }
                                                                }
                                                                echo substr($empresa,0,-1);
                                                            ?>
                                                        </td>
                                                        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                                                            <?php 
                                                                $sede="";
                                                                foreach($list_sede as $list){
                                                                if($list['id_proyecto']==$row_p['id_proyecto']){
                                                                    $sede=$sede.$list['cod_sede'].",";
                                                                }
                                                                }
                                                                echo substr($sede,0,-1);
                                                            ?>
                                                        </td>
                                                        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_tipo']; ?></td>
                                                        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_subtipo']; ?></td>
                                                        <td style="max-width: 10px; overflow: hidden;" nowrap <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['descripcion']; ?></td>
                                                        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['s_artes']+$row_p['s_redes']; ?></td>
                                                        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_agenda']!='00/00/0000') echo $row_p['fec_agenda']; ?></td>
                                                        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_solicitado']; ?></td>
                                                        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_solicitante']!='00/00/0000') echo $row_p['fec_solicitante']; ?></td>
                                                        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_asignado']; ?></td>
                                                        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_termino']!='00/00/0000 00:00:00') echo $row_p['fec_termino'];?></td>
                                                        <td nowrap align="center"
                                                        <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                                                        <!--<a onclick="Editar(this,'<?php echo $row_p['id_proyecto']; ?>')" style="cursor:pointer; cursor: hand;">
                                                            <img src="<?= base_url() ?>images/editar.png" onclick="Editar('<?php echo $row_p['id_proyecto']; ?>')" style="cursor:pointer; cursor: hand;" width="20px" height="20px">
                                                        </a>-->
                                                        

                                                        <?php  if($row_p['duplicado']!=1){ ?>
                                                            <a type="button" title="Editar Proyecto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Teamleader/Editar_proyect') ?>/<?php echo $row_p['id_proyecto']; ?>/<?php echo "1"; ?>"> 
                                                                <img width="20px" height="20px" src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;"/>
                                                            </a>
                                                            
                                                            <?php if ($row_p['imagen']!='') { ?>
                                                                <img src="<?= base_url() ?>template/img/ver.png" width="21px" height="21px" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $row_p['imagen']?>" title="Ver Imagen" style="cursor:pointer; cursor: hand;"/>
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
                </div>
            </div>
        </div>
    </div>
</main>

<style type="text/css">
  td, th {
      padding: 1px;
      padding-top: 5px;
      padding-right: 8px;
    padding-bottom: 1px;
      padding-left: 8px;
      line-height: 1;
      vertical-align: top;
  }

  .table-total {
      border-spacing: 0;
      border-collapse: collapse;
  }
</style>

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
        // Setup - add a text input to each footer cell
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

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 100
        } );

    } );
</script>

<?php $this->load->view('Admin/footer'); ?>

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
        var url="<?php echo site_url(); ?>Teamleader/Buscador_Anio";
        $.ajax({
            type:"POST",
            url:url,
            data: {'anio':anio},
            success:function (data) {
                $('#busqueda_anio').html(data);
            }
        });
    }

    function Exportar_Proyectos(){
        var anio=$('#anio').val();
        window.location ="<?php echo site_url(); ?>Teamleader/Excel_Lista_Proyecto/"+anio;
    }
</script>

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
        <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url() ?>'>
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
        document.getElementById("capital2").innerHTML = "<img src='"+nombre_archivo+"'>";
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
