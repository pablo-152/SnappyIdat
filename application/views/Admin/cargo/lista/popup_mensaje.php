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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Agregar Mensaje para <?php echo $get_id[0]['cod_cargo'] ?></b></span></h4>
                </div>
            </div>
        </div>
    </div>

    <form id="formulario_mensaje" method="POST" enctype="multipart/form-data"  class="horizontal">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                  <div class="form-group col-md-12">
                    <label class="control-label text-bold label_tabla">Mensaje:</label>
                    <div class="col">
                        <textarea name="obs" type="text" maxlength="500" rows="5" class="form-control" id="obs" placeholder="Ingresar Mensaje"><?php echo $get_historial[0]['observacion']; ?></textarea>
                        <input name="id" type="hidden" maxlength="500" rows="5" class="form-control" id="id" placeholder="Ingresar Mensaje" value="<?php echo $get_id[0]['id_cargo'] ?>">
                        <input name="id_cargo_historial" type="hidden" maxlength="500" rows="5" class="form-control" id="id_cargo_historial"  value="<?php echo $get_historial[0]['id_cargo_historial'] ?>">
                        
                    </div>
                  </div>
                </div>

            </div>
            
        </div>
        <div class="modal-footer">
            
            <button type="button" class="btn btn-primary" onclick="Insert_Mensaje()" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" onclick="Cancelar()">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("#cargo").addClass('active');
        $("#hcargo").attr('aria-expanded', 'true');
        $("#slista").addClass('active');
        /*$("#hlista").attr('aria-expanded', 'true');
        $("#nuevocargo").addClass('active');
        document.getElementById("rlista").style.display = "block";*/
        document.getElementById("rcargo").style.display = "block";
    });
</script>

<script>
function Insert_Mensaje(){
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

    var dataString = new FormData(document.getElementById('formulario_mensaje'));
    var url="<?php echo site_url(); ?>Snappy/Insert_mensaje_Cargo";
    if (valida_registros_mensaje()) {
        $.ajax({
                      type:"POST",
                      url:url,
                      data:dataString,
                      processData: false,
                      contentType: false,
                      success:function (data) {
                          
                        swal.fire(
                            'Registro de mensaje exitoso!',
                            '',
                            'success'
                        ).then(function() {
                                window.location = "<?php echo site_url('Snappy/Cargo')?>";
                        });
                      }
                    });
    }
  }

  function Cancelar(){
    window.location = "<?php echo site_url('Snappy/Cargo')?>";
  }

  function valida_registros_mensaje() {
    if($('#obs').val().trim() === '') {
        Swal(
            'Ups!',
            'Debe ingresar mensaje.',
            'warning'
        ).then(function() { });
        return false;
    }

    return true;
  }

</script>

<?php $this->load->view('Admin/footer'); ?>