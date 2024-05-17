<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
.esqueleto {
    width: 100%;
    height: 200px;
    background: #ececec;
    border-radius: 5px;
}
</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;"> 
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Alumnos (Datos)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="#" onclick="Actualizar_Lista_Datos_Alumno();">
                            <img src="<?= base_url() ?>template/img/actualizar_lista.png">
                        </a>
                        <a onclick="Excel_Datos_Alumno();" style="margin-left: 5px;"> 
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="tipo_excel" value="1">
 
    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Datos_Alumno(1);" id="matriculados_btn" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Matriculados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Datos_Alumno(2);" id="todos_btn" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>            
        </div>
        <div class="row"> 
            <div class="col-lg-12" id="lista_datos_alumno">
                <div class="esqueleto" id="esqueleto-div"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informes").addClass('active');
        $("#hinformes").attr('aria-expanded','true');
        $("#datos_alumnos").addClass('active');
		document.getElementById("rinformes").style.display = "block";

        Lista_Datos_Alumno(1); 
    });

    function Lista_Datos_Alumno(tipo){ 
        Cargando();
        mostrarEsqueleto();

        var tipoExcel = $('#tipo_excel').val();
        var storageKey;

        if (tipo === 1) {
            storageKey = 'datos_alumno_matriculados';
        } else if (tipo === 2) {
            storageKey = 'datos_alumno_todos';
        } else {
            // Tipo desconocido, maneja el error aquí si es necesario
            return;
        }

        var cachedData = localStorage.getItem(storageKey);

        if (cachedData) {
            $('#lista_datos_alumno').html(cachedData);
            $('#tipo_excel').val(tipo);
        } else {
            var url = "<?php echo site_url(); ?>AppIFV/Lista_Datos_Alumno/" + tipo;

            $.ajax({
                type: "POST",
                url: url,
                success: function (resp) {
                    $('#lista_datos_alumno').html(resp);
                    $('#tipo_excel').val(tipo);

                    localStorage.setItem(storageKey, resp);
                    ocultarEsqueleto();
                }
            });
        }

        var matriculados = document.getElementById('matriculados_btn');
        var todos = document.getElementById('todos_btn');
        if(tipo==1){
            todos.style.color = '#000000';
            matriculados.style.color = '#ffffff';
        }else if(tipo==2){
            todos.style.color = '#ffffff';
            matriculados.style.color = '#000000';
        }
    }

    function Actualizar_Lista_Datos_Alumno() {
       // Mostrar un esqueleto mientras se actualiza la información
       mostrarEsqueleto();
        
       var tipo = $('#tipo_excel').val();
       var storageKey;
        
       if (tipo === "1") {
           storageKey = 'datos_alumno_matriculados';
       } else if (tipo === "2") {
           storageKey = 'datos_alumno_todos';
       } else {
           // Tipo desconocido, maneja el error aquí si es necesario
           return;
       }
    
       var url = "<?php echo site_url(); ?>AppIFV/Lista_Datos_Alumno/" + tipo;
    
       $.ajax({
           type: "POST",
           url: url,
           success: function (resp) {
               $('#lista_datos_alumno').html(resp);
               $('#tipo_excel').val(tipo);
            
               // Actualizar los datos en el localStorage
               localStorage.setItem(storageKey, resp);
            
               // Ocultar el esqueleto después de actualizar la información
               ocultarEsqueleto();
           }
       });
    }

    function mostrarEsqueleto() {
        $("#esqueleto-div").show(); // Mostrar el div del esqueleto
    }
    
    function ocultarEsqueleto() {
        $("#esqueleto-div").hide(); // Ocultar el div del esqueleto
    }


    function Excel_Datos_Alumno(){
        var tipoExcel = $('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Datos_Alumno/"+tipoExcel;
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>
<?php $this->load->view('view_IFV/utils/index.php'); ?>
