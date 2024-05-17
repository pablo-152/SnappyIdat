<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('general/header'); ?>

<?php $this->load->view('general/nav'); ?>



<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Búsqueda (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a onclick="Exportar_Tickets_All();">
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
                        <label class="text-bold" for="id_status" >Año:</label>
                        <div class="col">
                            <select name="anio" id="anio" class="form-control" onchange="Cambiar_Anio()">
                                <?php foreach($list_anio as $list){ ?>
                                    <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['nom_anio'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!--<div class="form-group col-md-2">
                        <label class="text-bold" for="id_status" >Empresa:</label>
                        <div class="col">
                            <select name="id_empresa" id="id_empresa" class="form-control" onchange="Cambiar_Anio()">
                                <?php foreach($list_empresas as $list){ ?>
                                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    
    <div >
        <div class="container-fluid" >
            <div class="row">
                <div class="col-lg-12"  id="busqueda_anio">
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    $(document).ready(function() {
        $("#soporteti").addClass('active');
        $("#hsoporteti").attr('aria-expanded', 'true');
        $("#informeti").addClass('active');
        $("#hinformeti").attr('aria-expanded', 'true');
        $("#hbusqueda_informe").addClass('active');
        document.getElementById("rsoporteti").style.display = "block";
        document.getElementById("rinformeti").style.display = "block";


        Cambiar_Anio();
    });
</script>

<script>
    function Cambiar_Anio(){
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
        var anio=$('#anio').val();
        var id_empresa=$('#id_empresa').val();

        var url="<?php echo site_url(); ?>General/Buscador_Anio";
        $.ajax({
            type:"POST",
            url:url,
            data: {'anio':anio,'id_empresa':id_empresa},
            success:function (data) {
                $('#busqueda_anio').html(data);
            }
        });
    }

    function Exportar_Tickets_All(){
        var anio=$('#anio').val();
        var id_empresa=$('#id_empresa').val();
        window.location ="<?php echo site_url(); ?>General/Excel_Lista_Tickets_All/"+anio+"/"+1;
    }
</script>

<?php $this->load->view('general/footer'); ?>

