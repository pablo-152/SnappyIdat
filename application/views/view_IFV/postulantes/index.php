<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Postulantes (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a style="cursor:pointer;margin-right:5px;" id="btn_invitar">
                            <img src="<?= base_url() ?>template/img/invitar.png" alt="Invitar Postulante" />
                        </a>
                        
                        <a onclick="Exportar_Postulante();" style="cursor:pointer">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form  method="post" id="formulario_excel" enctype="multipart/form-data">
        <input type="hidden" name="ot" id="ot" value="">

        <div class="container-fluid" style="margin-bottom: 15px;">
            <div class="row col-md-12 col-sm-12 col-xs-12">
                <a onclick="Muestra_Postulante(1);"  id="invitados" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Invitados</span><i class="icon-arrow-down52"></i></a>
                <a onclick="Muestra_Postulante(2);"  id="concluidos" style="color: #ffffff; background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span style="color: #ffffff;">Concluidos</span><i style="color: #ffffff;" class="icon-arrow-down52"></i> </a>
                <a onclick="Muestra_Postulante(3);"  id="todos" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>

                <a class="form-group btn">
                    <input class="form-group" name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]'  size="100" required >
                </a>

                <a class="form-group btn" href="<?= site_url('AppIFV/Excel_Vacio_Postulante') ?>" title="Estructura de Excel" style="margin-right:10px;">
                    <img height="40px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel" />
                </a>

                <a class="btn btn-primary form-group" type="button" onclick="Insert_Requerimiento();">Importar</a>
                <span role="alert" id="resultado" style="color:red;"></span>
            </div>
        </div>
    </form>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="lista_postulante">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#examenadmision").addClass('active');
        $("#hexamenadmision").attr('aria-expanded', 'true');
        $("#postulantes").addClass('active');
		document.getElementById("rexamenadmision").style.display = "block";

        Muestra_Postulante(1);
    });
</script>

<script>
    var base_url = "<?php echo site_url(); ?>";

    function Insert_Requerimiento() {
        
        $(document)
        .ajaxStart(function () {
            //screen.fadeIn();
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
            });/**/
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
        var dataString = new FormData(document.getElementById('formulario_excel'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Listas";
        var url2="<?php echo site_url(); ?>AppIFV/Insert_Listas_Siosi";
        if (Valida_Import_Excel()) 
        {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                
                success:function (data) {
                    var mensaje = data;
                    
                    if(mensaje=="15"){
                        Swal({
                                title: '¿Realmente desea registrar',
                                text: "El archivo contiene mas de 15 datos con errores",
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
                                        url:url2,
                                        data: dataString,
                                        processData: false,
                                        contentType: false,
                                        success:function () {
                                            swal.fire(
                                                'Carga Exitosa!',
                                                '',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                                            });
                                        }
                                    });
                                }
                            })
                    }
                    else if(mensaje.trim()!=""){
                        swal.fire(
                            'Carga con Errores!',
                            mensaje,
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                        });
                    }else{
                        swal.fire(
                            'Carga Exitosa!',
                            '',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                        });
                    }
                }
            });
        }
    }

    function Valida_Import_Excel() {
        

        if($('#archivo_excel').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar archivo Excel.',
                'warning'
            ).then(function() { });
            return false;
        }

        //if ($('#semana').val() <)

        return true;
    }

    function Muestra_Postulante(id) {
        $(document)
        .ajaxStart(function () {
            //screen.fadeIn();
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
            });/**/
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
      var id = id;
      var url="<?php echo site_url(); ?>AppIFV/Muestra_Postulante";

      var observacion = document.getElementById("observacion");
      var div = document.getElementById("div_archivo");
      var btn = document.getElementById("btn_invitar");

      $.ajax({
          type:"POST",
          url:url,
          data: {'parametro':id},
          success:function (data) {
              $('#lista_postulante').html(data);
          }
      });

        var invitados = document.getElementById('invitados');
        var concluidos = document.getElementById('concluidos');
        var todos = document.getElementById('todos');
        if(id==1){
                invitados.style.color = '#ffffff';
                concluidos.style.color = '#000000';
                todos.style.color = '#000000';
        }else if(id==2){
            
            invitados.style.color = '#000000';
            concluidos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else if(id==3){
            invitados.style.color = '#000000';
            concluidos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Delete_Postulante(id){
        var id = id;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Postulante";
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
                    data: {'id_postulante':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                            
                        });
                    }
                });
            }
        })
    }
</script>

<script>


    $("#btn_invitar").on('click', function(e)
    {
        $(document)
        .ajaxStart(function () {
            //screen.fadeIn();
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
            });/**/
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

        var contadorf=$('#cantidad').val();

        var dataString = new FormData(document.getElementById('frm_snappy'));
        var url="<?php echo site_url(); ?>AppIFV/Invitar";

        

        if(contadorf>0)
        {
            bootbox.confirm({
                title: "Enviar Invitación",
                message: "¿Desea invitar a  "+contadorf+ " postulantes?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                    
                    }else{
                       $.ajax({
                        url: url,
                        data:dataString,
                        type:"POST",
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            if(data=="error"){
                                swal.fire(
                                'No tienes ningún examen activo actualmente!',
                                '',
                                'warning'
                                    ).then(function() {
                                        //window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                                    });
                            }else{
                                swal.fire(
                                'Invitación Exitosa!',
                                '',
                                'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                                    });
                            }
                            //Carga_Mensaje();
                            }
                    }); 
                    }
                    

                } 
            });
        }else{
            Swal(
                'Ups!',
                'Debe seleccionar al menos 1 postulante.',
                'warning'
            ).then(function() { });
            return false;
        }
    });

    function Carga_Mensaje()
    {
        swal.fire(
                'Invitación Exitosa!',
                'Haga clic en el botón!',
                'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                    });
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>

