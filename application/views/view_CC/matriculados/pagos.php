<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

<style>
    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          <div class="page-title" style="background-color: #C1C1C1;">
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
          </div>
  
          <div class="heading-elements">
            <div class="heading-btn-group">
                <a type="button" href="<?= site_url('CursosCortos/Matriculados') ?>">
                  <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                </a>

                <a style="margin-left:5px;" onclick="Excel_Pago_Matriculados();">
                    <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                </a>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Pagos(2);" id="pendientes" style="color:#ffffff;background-color:#C00000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Pagos(1);" id="todos" style="color:#000000; background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="estado" name="estado" value="2">
            <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $id_alumno; ?>">
        </div>

        <div class="row">
            <div id="lista_pagos" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#alumnos").addClass('active');
        $("#halumnos").attr('aria-expanded','true');
        $("#matriculados").addClass('active');
        document.getElementById("ralumnos").style.display = "block";
        Lista_Pagos(2);
    } );

    function Lista_Pagos(estado){
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

        var id_alumno = $('#id_alumno').val();
        var url="<?php echo site_url(); ?>CursosCortos/Lista_Pago_Matriculados";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_alumno':id_alumno,'estado':estado},
            success:function (data) {
                $('#lista_pagos').html(data);
                $('#estado').val(estado);
            }
        });

        var pendientes = document.getElementById('pendientes');
        var todos = document.getElementById('todos');

        if(estado==1){
            pendientes.style.color = '#000000';
            todos.style.color = '#FFFFFF';
        }else{
            pendientes.style.color = '#FFFFFF';
            todos.style.color = '#000000';
        }
    }

    function Excel_Pago_Matriculados(){
        var id_alumno = $('#id_alumno').val();
        var estado=$('#estado').val();
        window.location ="<?php echo site_url(); ?>CursosCortos/Excel_Pago_Matriculados/"+id_alumno+"/"+estado;
    }
</script>

<?php $this->load->view('view_CC/footer'); ?>