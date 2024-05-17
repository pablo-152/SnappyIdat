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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Reporte Mensual Redes (Facebook)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a onclick="Exportar();">
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
                        <label class="text-bold" for="id_status" >Empresa:</label>
                        <div class="col">
                            <select class="form-control" name="id_empresa" id="id_empresa">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_empresam as $empresa){ ?>
                                    <option value="<?php echo $empresa['id_empresa']; ?>"><?php echo $empresa['cod_empresa'];?></option>
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

                    <div class="form-group col-md-2">
                        <label class="text-bold"  for="id_mes" >Mes:</label>
                        <div class="col">
                            <select class="form-control" name="id_mes" id="id_mes">
                                <option value="0" >Seleccione</option>
                                <?php foreach($list_meses as $mes){ ?>
                                    <option value="<?php echo $mes['cod_mes']; ?>" ><?php echo $mes['nom_mes'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2 mb-3">
                        <label class="text-bold"  for="exampleInputPassword1">&nbsp;</label>
                        <button type="button" onclick="Consulta()" class="form-control btn btn-primary" style="background-color: #9c8f9e;border-color: #9c8f9e;">Buscar</button>
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
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#sredes").addClass('active');
        $("#hsredes").attr('aria-expanded', 'true');
        $("#informe_redes").addClass('active');
		document.getElementById("rredes").style.display = "block";
        document.getElementById("rcomunicacion").style.display = "block";
    });
</script>

<?php $this->load->view('Admin/footer'); ?>

<script>
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

        var id_empresa = document.getElementById("id_empresa").value;
        var nom_anio = document.getElementById("nom_anio").value;
        var id_mes = document.getElementById("id_mes").value;

        var url = "<?php echo site_url(); ?>Snappy/Reporte_Mensual/";
        frm = { 'id_empresa': id_empresa, 'nom_anio': nom_anio, 'id_mes':id_mes};

        if(Valida_Consulta()){
            $.ajax({
                url: url, 
                type: 'POST',
                data: frm,
            }).done(function(contextResponse, statusResponse, response) {
                $("#divtabla").html(contextResponse);
            })
        }
    }

    function Valida_Consulta(){
        var id_empresa = document.getElementById("id_empresa").value;
        var nom_anio = document.getElementById("nom_anio").value;
        var id_mes = document.getElementById("id_mes").value;

        if ( id_empresa == '0'){
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
        if ( id_mes == '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Mes.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Exportar(){
        var id_empresa = document.getElementById("id_empresa").value;
        var nom_anio = document.getElementById("nom_anio").value;
        var id_mes = document.getElementById("id_mes").value;
        
        window.location ="<?php echo site_url(); ?>Snappy/Excel_Reporte_Mensual/"+id_empresa+"/"+nom_anio+"/"+id_mes;
    }
</script>