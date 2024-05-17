<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row"> 
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Gastos SUNAT - Informes (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Reenviar" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Administrador/Modal_Reenviar_Informe_Sunat') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/reenviar_correo.png">
                        </a>

                        <a onclick="Exportar();">
                            <img src="<?= base_url() ?>template/img/excel.png">
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
                        <label class="text-bold">Empresa:</label>
                        <div class="col">
                            <select class="form-control" name="cod_empresa" id="cod_empresa">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_empresam as $empresa){ ?>
                                    <option value="<?php echo $empresa['id_empresa']."_".$empresa['cod_empresa']; ?>"><?php echo $empresa['cd_empresa'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Año:</label>
                        <div class="col">
                            <select class="form-control" name="nom_anio" id="nom_anio">
                                <option value="0" >Seleccione</option>
                                <?php foreach($list_anios as $list){ ?>
                                    <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>>
                                        <?php echo $list['nom_anio'];?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2 mb-3">
                        <label class="text-bold"  for="exampleInputPassword1">&nbsp;</label>
                        <button type="button" class="form-control btn btn-primary" onclick="Consulta();" style="background-color: #9c8f9e;border-color: #9c8f9e;">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="divtabla">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#gastossunat").addClass('active');
        $("#hgastossunat").attr('aria-expanded', 'true');
        $("#informe_sunat").addClass('active');
		document.getElementById("rgastossunat").style.display = "block";
        document.getElementById("rcontabilidad").style.display = "block";
    });
</script>

<?php $this->load->view('Admin/footer'); ?>

<script type="text/javascript">
    function Consulta(){
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

        var cod_empresa = document.getElementById("cod_empresa").value;
        var nom_anio = document.getElementById("nom_anio").value;

        var url = "<?php echo site_url(); ?>Administrador/Lista_Informe_Sunat";
        frm = {'cod_empresa':cod_empresa,'nom_anio':nom_anio};

        if(Valida_Consulta()){
            $.ajax({
                type:"POST",
                url:url,
                data: frm,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Búsqueda Denegada',
                            text: "¡No hay Sub-Rubros disponibles!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        $('#divtabla').html(data);
                    }
                }
            });
        }
    }

    function Valida_Consulta(){
        var cod_empresa = document.getElementById("cod_empresa").value;
        var nom_anio = document.getElementById("nom_anio").value;

        if ( cod_empresa == '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ( nom_anio == '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Exportar(){
        var cod_empresa = document.getElementById("cod_empresa").value;
        var nom_anio = document.getElementById("nom_anio").value;
        window.location ="<?php echo site_url(); ?>Administrador/Excel_Informe_Sunat/"+cod_empresa+"/"+nom_anio;
    }
</script>