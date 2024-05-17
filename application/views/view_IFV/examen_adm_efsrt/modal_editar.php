<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Examen EFSRT <b><?php echo $get_id[0]['nom_examen']; ?></b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Nombre:</label>
                <input type="text" class="form-control" id="nom_examen" name="nom_examen" value="<?php echo $get_id[0]['nom_examen']; ?>" >
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha Examen:</label>
                <input type="date" class="form-control" id="fec_limite" name="fec_limite" value="<?php echo $get_id[0]['fecha_limite']; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Publicación de Resultados:</label>
                <input type="date" class="form-control" id="fec_resultados" name="fec_resultados" value="<?php echo $get_id[0]['fecha_resultados']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Carreras</label>
                <select id="carrerae" name="carrerae[]" multiple="multiple" class="selecte form-control">
                    <?php foreach($list_especialidad as $list){?>
                    <option value="<?php echo $list['id_especialidad'] ?>" <?php $tipos=explode(",",$get_id[0]['carrera']);foreach($tipos as $t){ if($list['id_especialidad']==$t){echo "selected";}}?>><?php echo $list['nom_especialidad'] ?></option>    
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Estado</label>
                <select class="form-control" name="estado" id="estado" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($get_id[0]['estado']==$list['id_status']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php  } ?>
                </select>
            </div>
        </div>

    </div> 
    <div class="modal-footer">
        <input name="id_examen" type="hidden" class="form-control" id="id_examen" value="<?php echo $get_id[0]['id_examen']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Examen_Efsrt_IFV();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    $('.selecte').select2({
        minimumResultsForSearch: Infinity
    });
    function Update_Examen_Efsrt_IFV(){
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
        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Update_Examen_Efsrt_IFV";;

        if (Valida_Update_Examen_Efsrt_IFV()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="error"){
                        swal.fire(
                            'Actualización Denegada!',
                            'Existe otro examen activo, por favor revisar!',
                            'error'
                        ).then(function() {});
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $("#acceso_modal_mod .close").click();
                        Lista_Examen_Efsrt($('#tipo_excel').val())
                            //window.location = "<?php echo site_url(); ?>AppIFV/Examen_Efsrt";
                        });
                    }
                }
            });
        }
    }

    function Valida_Update_Examen_Efsrt_IFV() {
        if($('#nom_examen').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_limite').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Límite.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_resultados').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Publicación de Resultados.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#carrerae').val() == null) {
            Swal(
                'Ups!',
                'Debe seleccionar Carrera.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>