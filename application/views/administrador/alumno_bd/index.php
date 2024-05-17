<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Base de Datos - Alumnos (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            
            <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#modal_small" modal_small="<?= site_url('Administrador/Modal_Asignar_Folder') ?>">  <img src="<?= base_url() ?>template/img/asignar.png" alt="Nuevo Evento" />
            </a>

            <a style="margin-left:5px;" onclick="Excel_Alumno_BD();">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>    
    <div></div>
      
    </div>
  </div>

    
  <div class="container-fluid" id="tablai">
    
  </div>
</div>
<script>
    $(document).ready(function() {
        $("#base_dato").addClass('active');
        $("#hbase_dato").attr('aria-expanded','true');
        $("#base_datos_alumnos").addClass('active');
		    document.getElementById("rbase_dato").style.display = "block";
        Buscar(this,0);
    });

    $('#tipo_folder').bind('keyup paste', function(){
      var tipo_folder=$('#tipo_folder').val();
      $('#tipo_folder_f').val(anio);
    });

    function seleccionart(){
        if (document.getElementById('total').checked)
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_alumno')
                    inp[i].checked=1;
            }
        }

        else
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_alumno')
                    inp[i].checked=0;
            }
        }
    }

    function Asignar_Folder(){
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

        var contador=0;
        var contadorf=0;
        var url = "<?php echo site_url(); ?>Administrador/Asignar_Folder";
        var dataString = new FormData(document.getElementById('formulario_ibd'));

        $("input[type=checkbox]").each(function(){
            if($(this).is(":checked"))
                contador++;
        });
        if(contador>0 && document.getElementById('total').checked==true)
        {
            contadorf=contador-1;
        }
        else{
            contadorf=contador;
        }
        if(Valida_Asignacion()){
          if(contadorf==25)
          {
              Swal({
                title: '¿Realmente desea asignar '+contadorf+' registros?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        data:dataString,
                        type:"POST",
                        processData: false,
                        contentType: false,
                        
                        success:function (data) {
                          if(data=="error"){
                            Swal(
                                'Asignación Denegada!',
                                'La asignación para el folder y tipo ya existe. Por favor verificar',
                                'error'
                            ).then(function() {
                               
                            });
                          }else{
                            Swal(
                                'Asignación Exitosa!',
                                'Las registros fueron asignados al folder exitosamente.',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>Administrador/BD_Alumnos";
                            });
                          }
                            
                        }
                    });
                }
            })
          }else{
              Swal(
                  'Ups!',
                  'Debe seleccionar 25 registros.',
                  'warning'
              ).then(function() { });
              return false;
          }
        }
    }

    function Valida_Asignacion(){
      if($('#anio1').val().trim()===""){
        Swal(
              'Ups!',
              'Debe ingresar año.',
              'warning'
          ).then(function() { });
          return false;
      }

      if($('#tipo_folder').val()==0){
        Swal(
              'Ups!',
              'Debe seleccionar tipo de folder.',
              'warning'
          ).then(function() { });
          return false;
      }

      if($('#sede_folder').val()==0){
        Swal(
              'Ups!',
              'Debe seleccionar sede.',
              'warning'
          ).then(function() { });
          return false;
      }
      return true;
    }

    function Buscar(e,status){
      var parametro =status;
      
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
      var url="<?php echo site_url(); ?>Administrador/Busqueda_SAsignar";
      $.ajax({
          url: url,
          data:{'parametro':parametro},
          type:"POST",
          success:function (data) {
            $("#tablai").html(data);
          }
      });

      
    }

    function Validar_Documentacion(){
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

        var url = "<?php echo site_url(); ?>Administrador/Validar_Documentacion";
        var dataString = new FormData(document.getElementById('formulario_validacion'));

        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            
            success:function (data) {
                Swal(
                    'Actualización Exitosa!',
                    '',
                    'success'
                ).then(function() {
                    //window.location = "<?php echo site_url(); ?>Administrador/BD_Alumnos";
                    Buscar(this,1);
                    //alert("aquii");
                    $('#modal_small').modal('hide');
                    
                });
            }
        });
    }

    function Excel_Alumno_BD(){
      var parametro= $('#parametro').val();
      window.location = "<?php echo site_url(); ?>Administrador/Excel_Alumno_BD/"+parametro;
    }


    
</script>

<?php $this->load->view('Admin/footer'); ?>


