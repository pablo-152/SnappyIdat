<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
  .div_padre{
    position: relative;
    padding-bottom: 86px;
    text-align: center;
  }

  .boton_principal_pendiente{
    position: absolute;
    background-color: #C00000;
    border-color: #C00000;
    color: white;
    top: 50%;
    margin-top: -18px;
  }

  .boton_principal_revisado{
    position: absolute;
    background-color: #009245;
    border-color: #009245;
    color: white;
    top: 50%;
    margin-top: -18px;
  }

  .boton_principal_pendiente:hover{
    color: white;
  }

  .boton_principal_revisado:hover{
    color: white;
  }
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Horario</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal"  app_crear_per="<?= site_url('AppIFV/Modal_Horario_Detalle/') ?><?php echo $get_id[0]['id_horario'] ?>">
              <img src="<?= base_url() ?>template/img/nuevo.png"/>
            </a>
            <a type="button" href="<?= site_url('AppIFV/Horario') ?>">
              <img src="<?= base_url() ?>template/img/icono-regresar.png">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container-fluid">
    <form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
      <div class="form-group">
        <div class="col-md-12 row">
          <div class="form-group col-md-4">
            <label class="control-label text-bold">Especialidad:</label>
            <select class="form-control" id="id_especialidad" name="id_especialidad" onchange="Busca_Grupo()">
              <option value="0">Seleccione</option>
              <?php foreach($list_especialidad as $list){ ?>
                <option value="<?php echo $list['id_especialidad']; ?>" <?php if($get_id[0]['id_especialidad']==$list['id_especialidad']){echo "selected";} ?>><?php echo $list['nom_especialidad']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Grupo:</label>
            <div id="cmb_grupo">
              <select name="grupo" id="grupo" class="form-control" onchange="Busca_Turno()">
                <option value="0">Seleccione</option>
                <?php foreach($list_grupo as $list){?> 
                    <option value="<?php echo $list['id_grupo'] ?>" <?php if($get_id[0]['grupo']==$list['id_grupo']){echo "selected";}?>><?php echo $list['grupo'] ?></option>
                <?php }?>
              </select>
            </div>
              
          </div>
          
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Modulo:</label>
            <div id="cmb_modulo">
              <select name="id_modulo" id="id_modulo" class="form-control">
                <option value="0">Seleccione</option>
                <?php foreach($list_modulo as $list){?> 
                    <option value="<?php echo $list['id_modulo'] ?>" <?php if($get_id[0]['id_modulo']==$list['id_modulo']){echo "selected";}?>><?php echo $list['modulo'] ?></option>
                <?php }?>
              </select>
            </div>
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Turno:</label>
            <div id="cmb_turno">
              <select name="id_turno" id="id_turno" class="form-control">
                <option value="0">Seleccione</option>
                <?php if(count($get_turno)>0 && isset($get_turno[0]['id_turno']) && $get_turno[0]['id_turno']!=""){
                  foreach($list_turno as $list){ ?>
                    <option value="<?php echo $list['id_turno']; ?>" <?php if($get_id[0]['id_turno']==$list['id_turno']){echo "selected";}?>>
                    <?php echo $list['nom_turno']; ?>
                    </option>
                <?php }  } ?>
              </select>
            </div>
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Tipo:</label>
            <select name="id_tipo_horario" id="id_tipo_horario" class="form-control">
              <option value="0">Seleccione</option>
              <?php foreach($list_tipo as $list){?>
              <option value="<?php echo $list['id_tipo_horario'] ?>" <?php if($get_id[0]['id_tipo_horario']==$list['id_tipo_horario']){echo "selected";}?>><?php echo $list['nom_tipo_horario'] ?></option>  
              <?php }?>
            </select>
          </div>
        
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Semana: <input type="checkbox" name="ch_semana" id="ch_semana" value="1" onclick="Semana()" <?php if($get_id[0]['ch_semana']==1){echo "checked";}?>></label>
            <select name="semana" id="semana" class="form-control" <?php if($get_id[0]['ch_semana']!=1){echo "disabled";}?>>
              <option value="0">Seleccione</option>
              <?php $i=1; while($i<=52){ ?>
                  <option value="<?php echo $i; ?>" <?php if($i==$get_id[0]['semana']){ echo "selected"; } ?>><?php echo $i; ?></option> 
              <?php $i++; } ?>
            </select>
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Del día:</label>
            <input type="date" class="form-control" id="del_dia" name="del_dia" value="<?php echo $get_id[0]['del_dia'] ?>" <?php if($get_id[0]['ch_semana']==1){echo "disabled";}?>>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Hasta:</label>
            <input type="date" class="form-control" id="hasta" name="hasta" value="<?php echo $get_id[0]['hasta'] ?>" <?php if($get_id[0]['ch_semana']==1){echo "disabled";}?>>
          </div>

          <div class="col-md-12 modal-footer">
            <input type="hidden" id="primer_estado" name="primer_estado">
            <input type="hidden" name="id_horario" id="id_horario" value="<?php echo $get_id[0]['id_horario'] ?>">
            <button type="button" class="btn btn-primary" onclick="Update_Horario()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
            <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Horario') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
          </div>
        </div>
      </div>
      <div class="form-group">
      </div>
    </form>
  </div>
</div>

<div class="panel panel-flat">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12" >
        <div class="content-group-lg" id="busqueda_detalle">
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $("#registros").addClass('active');
        $("#hregistros").attr('aria-expanded', 'true');
        $("#horarios_registros").addClass('active');
		document.getElementById("rregistros").style.display = "block";
    
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
        pageLength: 50
    });
    Busqueda_Horario_Detalle();
  });
</script>

<?php $this->load->view('view_IFV/footer'); ?>

<script>
  function Busca_Grupo(){
    $(document).ajaxStart(function() {
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
    }).ajaxStop(function() {
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
    var dataString = new FormData(document.getElementById('formulario'));
    var url = "<?php echo site_url(); ?>AppIFV/Busca_Grupo";
    $.ajax({
      url: url,
      data:dataString,
      type:"POST",
      processData: false,
      contentType: false,
      success: function(data) {
        $('#cmb_grupo').html(data);
        Busca_Modulo();
        Busca_Turno();
      }
    });
  }
  function Busca_Modulo(){
    $(document).ajaxStart(function() {
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
    }).ajaxStop(function() {
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
    var dataString = new FormData(document.getElementById('formulario'));
    var url = "<?php echo site_url(); ?>AppIFV/Busca_Modulo";
    $.ajax({
      url: url,
      data:dataString,
      type:"POST",
      processData: false,
      contentType: false,
      success: function(data) {
        $('#cmb_modulo').html(data);
      }
    });
  }

  function Busca_Turno(){
    $(document).ajaxStart(function() {
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
    }).ajaxStop(function() {
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
    var dataString = new FormData(document.getElementById('formulario'));
    var url = "<?php echo site_url(); ?>AppIFV/Busca_Turno";
    $.ajax({
      url: url,
      data:dataString,
      type:"POST",
      processData: false,
      contentType: false,
      success: function(data) {
        $('#cmb_turno').html(data);
      }
    });
  }

  function Semana(){
    $('#semana').val('0');
    $('#del_dia').val('');
    $('#hasta').val('');
    if ($('#ch_semana').is(":checked")) {
      $("#semana").prop('disabled', false);
      $("#del_dia").prop('disabled', true);
      $("#hasta").prop('disabled', true);
    }else{
      $("#semana").prop('disabled', true);
      $("#del_dia").prop('disabled', false);
      $("#hasta").prop('disabled', false);
    }
  }

  function Update_Horario() {
    $(document)
    .ajaxStart(function() {
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
    .ajaxStop(function() {
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

    var dataString = new FormData(document.getElementById('formulario'));
    var url = "<?php echo site_url(); ?>AppIFV/Update_Horario";

    if (Valida_Horario()) {
      $.ajax({
        url: url,
        data:dataString,
        type:"POST",
        processData: false,
        contentType: false,
        success: function(data) {
          if(data=="error"){
            swal.fire(
              'Actualización Denegada!',
              'Existe un registro con los mismos datos',
              'error'
            ).then(function() {
              
            });
          }else{
            swal.fire(
              'Actualización Exitosa!',
              'Haga clic en el botón!',
              'success'
            ).then(function() {
              window.location = "<?php echo site_url(); ?>AppIFV/Horario";
            });  
          }
          
        }
      });
    }
  }

  function Valida_Horario() {
    if ($('#id_especialidad').val() == "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Especialidad.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#grupo').val() === "0") {
      Swal(
        'Ups!',
        'Debe ingresar grupo.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_modulo').val()=== "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Módulo.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_turno').val() === "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Turno.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_tipo_horario').val() === "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Tipo.',
        'warning'
      ).then(function() {});
      return false;
    }

    if ($('#ch_semana').is(":checked")) {
      if ($('#semana').val() == "0") {
        Swal(
          'Ups!',
          'Debe seleccionar Semana.',
          'warning'
        ).then(function() {});
        return false;
      }
    }else{
      if ($('#del_dia').val() == "") {
        Swal(
          'Ups!',
          'Debe ingresar Del día.',
          'warning'
        ).then(function() {});
        return false;
      }
      if ($('#hasta').val() == "") {
        Swal(
          'Ups!',
          'Debe ingresar Hasta.',
          'warning'
        ).then(function() {});
        return false;
      }
    }
    return true;
  }

  function Busqueda_Horario_Detalle(){
    $(document).ajaxStart(function() {
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
    }).ajaxStop(function() {
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
    var id_horario = $('#id_horario').val();
    var url = "<?php echo site_url(); ?>AppIFV/List_Horario_Detalle";
    $.ajax({
      url: url,
      data:{'id_horario':id_horario},
      type:"POST",
      success: function(data) {
        $('#busqueda_detalle').html(data);
      }
    });
  }

  function Delete_Horario_Detalle(id) {
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

        var id = id;
        var url = "<?php echo site_url(); ?>AppIFV/Delete_Horario_Detalle";
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
                    type: "POST",
                    url: url,
                    data: {'id_horario_detalle': id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                          Busqueda_Horario_Detalle();
                        });
                    }
                });
            }
        })
    }
</script>