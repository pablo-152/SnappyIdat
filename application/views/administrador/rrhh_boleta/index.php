<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Boletas (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" href="#" style="cursor:pointer;margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a title="Excel" href="#">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container-fluid">
        <div class="row">
            <div id="lista_rrhh_configuracion" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#rrhh_boletas").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";

        //Lista_Rrhh_Configuracion();
    });

    function Lista_Rrhh_Configuracion(){
        Cargando();

        var url="<?php echo site_url(); ?>Administrador/Lista_Rrhh_Configuracion";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_rrhh_configuracion').html(resp);
            }
        });
    }

    function Delete_Rrhh_Configuracion(id){
        Cargando();

        var url="<?php echo site_url(); ?>Administrador/Delete_Rrhh_Configuracion";
        
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
                    data: {'id':id},
                    success:function () {
                        Lista_Rrhh_Configuracion();
                    }
                });
            }
        })
    }

    function Excel_Configuracion(){ 
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Rrhh_Configuracion";
    }
</script>

<?php $this->load->view('Admin/footer'); ?>