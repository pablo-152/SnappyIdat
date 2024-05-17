<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_CA/header'); ?>
<?php $this->load->view('view_CA/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <!--<h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Saldo: € <?php echo $saldo[0]['saldo']; ?></b></span></h4>
                    -->
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Movimientos</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
                            <a title="Nuevo Movimiento" style="cursor:pointer;margin-right:5px;" href="<?= site_url('Ca/Modal_Despesa') ?>">
                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                            </a>
                        <?php } ?>
                        <a onclick="Excel_Despesa();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Despesa(2);" id="validos" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Despesa(4);" id="anulados" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_despesa" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded','true');
        $("#despesas_index").addClass('active');
        document.getElementById("rcontabilidad").style.display = "block";        

        Lista_Despesa(2);
    });

    function Lista_Despesa(tipo){
        Cargando();

        var url="<?php echo site_url(); ?>Ca/Lista_Despesa";

        $.ajax({
            type:"POST",
            url:url,
            data:{'tipo':tipo},
            success:function (resp) {
                $('#lista_despesa').html(resp);
                $('#tipo_excel').val(tipo);
            }
        });

        var validos = document.getElementById('validos');
        var anulados = document.getElementById('anulados');
        if(tipo==2){
            validos.style.color = '#ffffff';
            anulados.style.color = '#000000';
        }else{
            validos.style.color = '#000000';
            anulados.style.color = '#ffffff';
        }
    }
    
    function Delete_Despesa(id){
        Cargando();

        var url="<?php echo site_url(); ?>Ca/Delete_Despesa";

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
                    data: {'id_despesa':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Despesa();
                        });
                    }
                });
            }
        })
    }

    function Excel_Despesa(){ 
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>Ca/Excel_Despesa/"+tipo_excel;
    }
</script>

<?php $this->load->view('view_CA/footer'); ?>