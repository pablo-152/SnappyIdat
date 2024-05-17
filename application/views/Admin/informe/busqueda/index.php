<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>

<?php $this->load->view('Admin/nav'); ?>



<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Búsqueda (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
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
                                    <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['nom_anio'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold" for="id_status" >Empresa:</label>
                        <div class="col">
                            <select name="id_empresa" id="id_empresa" class="form-control" onchange="Cambiar_Anio()">
                                <?php foreach($list_empresas as $list){ ?>
                                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
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
                <div class="col-lg-12"  id="busqueda_anio">
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
        $("#busqueda_redes").addClass('active');
		document.getElementById("riredes").style.display = "block";
        document.getElementById("rcomunicacion").style.display = "block";

        Cambiar_Anio();
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
        var id_empresa=$('#id_empresa').val();

        var url="<?php echo site_url(); ?>Snappy/Buscador_Anio";
        $.ajax({
            type:"POST",
            url:url,
            data: {'anio':anio,
                    'id_empresa':id_empresa},
            success:function (data) {
                $('#busqueda_anio').html(data);
            }
        });
    }

    function Exportar_Proyectos(){
        var anio=$('#anio').val();
        var id_empresa=$('#id_empresa').val();
        window.location ="<?php echo site_url(); ?>Snappy/Excel_Lista_Proyecto/"+anio+"/"+id_empresa;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>

<div class="modal fade bd-example-modal-lg" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Imagen Subida</h4>
        <a id="imgnewwindow" href="" target="_blank"><img src="<?= base_url() ?>template/img/ver.png" ></a>
        <a id="imgnewwindow2" href="" download><img src="<?= base_url() ?>template/img/descarga_peq.png" ></a>
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
            document.getElementById('imgnewwindow').href = nombre_archivo;
            document.getElementById('imgnewwindow2').href = nombre_archivo;
            }
            else
            {
            document.getElementById("capital2").innerHTML = "<img height='400px' width='650px' src='"+nombre_archivo+"'>";
            document.getElementById('imgnewwindow').href = nombre_archivo;
            document.getElementById('imgnewwindow2').href = nombre_archivo;
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
