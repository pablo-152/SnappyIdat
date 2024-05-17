<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Registro Ingreso del Alumno</b></span></h4>
                </div>

                <!--<div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Registro_Ingreso();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>-->
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-md-4">
                <label class="text-bold">Semana:</label>
                <select class="form-control" id="semana" name="semana">
                    <option value="0">Seleccione</option> 
                    <?php foreach($list_semanas as $list){ ?>
                        <option value="<?php echo $list['nom_semana']; ?>" <?php if($list['nom_semana']==date('W')){ echo "selected"; } ?>><?php echo "Semana ".$list['nom_semana']." (".date('d/m/Y',strtotime($list['fec_inicio']))." - ".date('d/m/Y',strtotime($list['fec_fin'])).")"; ?></option>
                    <?php } ?>
                </select>
            </div>
            <!--<div class="form-group col-md-2">
                <label class="text-bold">Fecha Inicio:</label>
                <div class="col">
                    <input type="date" class="form-control" id="fec_in" name="fec_in" value="<?php echo date('Y-m-01'); ?>">
                    <input type="date" class="form-control" id="fec_in" name="fec_in" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Fecha Fin:</label>
                <div class="col">
                    <input type="date" class="form-control" id="fec_fi" name="fec_fi" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>-->

            <div class="form-group col-md-2">
                <label class="text-bold" style="color: transparent;">Buscar:</label>
                <div class="col">
                    <button type="button" class="btn btn-primary"  id="busqueda_lista_asistencia" onclick="Lista_Asistencia_Registro_Ingreso_x_alumno(1);">Buscar</button>
                </div>
            </div>
        </div>
        <input id="codigo" name="codigo" type="hidden" value="<?php echo $cod_alumno; ?>">

        <!--<div class="heading-btn-group">
            <a onclick="Lista_Asistencia_Registro_Ingreso_x_alumno(1);" id="alumnos_btn" style="background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Alumnos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Asistencia_Registro_Ingreso_x_alumno(2);" id="invitados_btn" style="background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Invitados</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel">
        </div>-->

        <div class="row">
            <div id="lista_registro_ingreso_x_alumno" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#asistencias").addClass('active');
        $("#hasistencias").attr('aria-expanded', 'true');
        $("#listas_asistencias").addClass('active');
        $("#busqueda_lista_asistencia").trigger("click");
		document.getElementById("rasistencias").style.display = "block";

        Lista_Asistencia_Registro_Ingreso_x_alumno(1);
    });

    function Lista_Asistencia_Registro_Ingreso_x_alumno(tipo){
        Cargando();

        /*var fec_in = $("#fec_in").val();
        var fec_fi = $("#fec_fi").val();*/
        var semana = $("#semana").val();
        var codigo = $("#codigo").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Asistencia_Registro_Ingreso_x_alumno";

        $.ajax({
            type:"POST",
            url:url,
            data:{'codigo':codigo,'semana':semana, 'tipo':tipo},
            success:function (resp) {
                $('#lista_registro_ingreso_x_alumno').html(resp);
                $('#tipo_excel').val(tipo);
            }
        });

        var alumnos = document.getElementById('alumnos_btn');
        var invitados = document.getElementById('invitados_btn');
        if(tipo==1){
            alumnos.style.color = '#ffffff';
            invitados.style.color = '#000000';
        }else{
            alumnos.style.color = '#000000';
            invitados.style.color = '#ffffff';
        }
    }

    function Excel_Registro_Ingreso(){
        Cargando();
        
        var semana = $("#semana").val();

        /*var fec_in=$('#fec_in').val().split("-");
        var fec_in = fec_in[0]+fec_in[1]+fec_in[2]
        var fec_fi=$('#fec_fi').val().split("-");
        var fec_fi = fec_fi[0]+fec_fi[1]+fec_fi[2];*/
        var tipo=$('#tipo_excel').val();
        //window.location = "<?php echo site_url(); ?>AppIFV/Excel_Registro_Ingreso/"+fec_in+"/"+fec_fi+"/"+tipo;
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Registro_Ingreso/"+semana+"/"+tipo;
    }

    function Delete_Registro_Ingreso(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Registro_Ingreso_Lista";

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
                    data: {'id_registro_ingreso':id},
                    success:function () {
                        Lista_Asistencia_Registro_Ingreso_x_alumno();
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>

