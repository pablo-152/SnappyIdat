<?php $this->load->view($vista.'/header'); ?>
<?php $this->load->view($vista.'/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Colaboradores (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" type="button" href="<?= site_url('Colaborador/Registrar_Colaborador') ?>/<?= $get_id[0]['id_sede']; ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a onclick="Excel_Colaborador();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Colaborador(1);" id="btn_activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Colaborador(2);" id="btn_todos" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_colaborador" class="col-lg-12"> 
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#colaboradores_lista").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";

        Lista_Colaborador(1);
    });

    function Lista_Colaborador(tipo){
        Cargando();

        var id_sede = <?= $get_id[0]['id_sede']; ?>;
        var url="<?php echo site_url(); ?>Colaborador/Lista_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo,'id_sede':id_sede},
            success:function (resp) {
                $('#lista_colaborador').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var activos = document.getElementById('btn_activos');
        var todos = document.getElementById('btn_todos');
        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Delete_Colaborador(id){
        Cargando();

        var tipo_excel = $("#tipo_excel").val();
        var url="<?php echo site_url(); ?>Colaborador/Delete_Colaborador";
        
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
                    data: {'id_colaborador':id},
                    success:function () {
                        Lista_Colaborador(tipo_excel);
                    }
                });
            }
        })
    }
    
    function Reenviar_Validacion_Correo(id){   
        Cargando();

        var url="<?php echo site_url(); ?>Colaborador/Reenviar_Validacion_Correo";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_colaborador':id},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Reenvío Denegado',
                        text: "¡El colaborador no tiene correo personal!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Lista_Colaborador();
                }
            } 
        });
    }

    function Excel_Colaborador(){ 
        var tipo_excel = $("#tipo_excel").val();
        var id_sede = <?= $get_id[0]['id_sede']; ?>;
        window.location = "<?php echo site_url(); ?>Colaborador/Excel_Colaborador/"+tipo_excel+"/"+id_sede;
    }
</script>

<?php $this->load->view($vista.'/footer'); ?>