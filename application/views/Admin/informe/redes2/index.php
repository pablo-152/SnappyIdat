<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Admin/nav'); ?>
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_title">
                            <div class="row tile-title line-head"  style="background-color: #C1C1C1;">
                                <div class="col" style="vertical-align: middle;">
                                    <b>Reporte  mensual de Redes</b>
                                </div>
                                <div class="col" align="right">
                                    <a onclick="Exportar();">
                                        <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <div class="form-group col-md-2">
                                <label class="form-group col text-bold" for="id_status" >Empresa:</label>
                                <div class="col">
                                    <select class="form-control" name="id_empresa" id="id_empresa">
                                        <option value="0">Seleccione</option>
                                        <?php foreach($list_empresa as $empresa){ ?>
                                            <option value="<?php echo $empresa['cod_empresa']; ?>"><?php echo $empresa['cod_empresa'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="form-group col text-bold"  for="id_mes" >Mes:</label>
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
                                <label class="form-group col text-bold"  for="exampleInputPassword1">&nbsp;</label>
                                <button type="button" onclick="Consulta()" class="form-control btn-vino">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">  
                    <div class="box-body table-responsive" id="divtabla">
                            
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>
<?php $this->load->view('Admin/footer'); ?>

<script type="text/javascript">
    function Consulta(){
        var id_empresa = document.getElementById("id_empresa").value;
        var id_mes = document.getElementById("id_mes").value;
        //alert();

        if ( id_empresa == '0'){
            alert("Seleccione una empresa");
            document.getElementById("id_empresa").focus();
            return false;
        }
        
        if ( id_mes == '0'){
            alert("Seleccione el mes a buscar");
            document.getElementById("id_mes").focus();
            return false;
        }
    
        var url = "<?php echo site_url(); ?>Snappy/Reporte_Mensual/";
        frm = { 'id_empresa': id_empresa, 'id_mes':id_mes};
        $.ajax({
            url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
            $("#divtabla").html(contextResponse);
        })
    }

    function Exportar(){
        //var trabajador = document.form1.id_trabajador.value;
        var anio = '<?php echo date('Y'); ?>';
        /*var id_mes = '<?php echo $id_mes; ?>';
        var id_empresa = '<?php echo $id_empresa; ?>';*/
        var id_empresa = document.getElementById("id_empresa").value;
        var id_mes = document.getElementById("id_mes").value;
        
        valores = "anio=" + escape(anio) + "&id_mes=" + escape(id_mes) + "&id_empresa=" + escape(id_empresa);
        pagina = "application/views/Admin/informe/redes/exportar_excel.php?"+valores;
        //pagina = "exportar_excel.php";
        parent.location=pagina;
        //win = window.open(pagina, '', 'toolbar=no,statusbar=no,titlebar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
    }

    /*function Consulta(){
        var id_empresa = document.getElementById("id_empresa").value;
        var id_mes = document.getElementById("id_mes").value;
        //var mes = document.form1.id_mes.value;

        if ( id_empresa == '0'){
            alert("Seleccione una empresa");
            document.getElementById("id_empresa").focus();
            return false;
        }
        
        if ( id_mes == '0'){
            alert("Seleccione el mes a buscar");
            document.getElementById("id_mes").focus();
            return false;
        }
        
        var valores;
        //valores = "id_empresa=" + escape(id_empresa)+"&id_mes=" + escape(id_mes);
        url = "lista.php";
        
        $("#asistencia").load(url,{id_empresa:id_empresa, id_mes:id_mes}); 
    }*/
</script>