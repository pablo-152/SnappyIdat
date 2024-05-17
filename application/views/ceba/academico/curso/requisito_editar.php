<form id="formulario_update_requisito" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualización del Requisito <b><?php echo $get_id[0]['desc_requisito']; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Grado: </label>
                <div class="col">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_grado as $list){ ?>
                            <option value="<?php echo $list['id_grado']; ?>" <?php if($list['id_grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                                <?php echo $list['descripcion_grado']; ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Tipo de Requisito: </label>
                <div class="col">
                    <select class="form-control" name="id_tipo_requisito" id="id_tipo_requisito">
                        <option value="0">Seleccione</option>
                        <?php foreach($id_tipo_requisito as $list){ ?>
                            <option value="<?php echo $list['id_tipo_requisito']; ?>" <?php if($list['id_tipo_requisito']==$get_id[0]['id_tipo_requisito']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo_requisito']; ?>
                            </option>
                        <?php } ?>
                    </select>        
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Descripción: </label>
                <div class="col">
                    <input type="text" class="form-control" id="desc_requisito" name="desc_requisito" placeholder= "Ingresar Descripción" value="<?php echo $get_id[0]['desc_requisito']; ?>"/>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Estado: </label>
                <div class="col">
                    <select class="form-control" id="id_status" name="id_status">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>	           	                	        
    </div> 

    <div class="modal-footer">
        <input name="id_requisito" type="hidden" class="form-control" id="id_requisito" value="<?php echo $get_id[0]['id_requisito']; ?>">
        <input name="id_curso" type="hidden" class="form-control" id="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Requisito();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Requisito(){
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

        var dataString = new FormData(document.getElementById('formulario_update_requisito'));
        var url="<?php echo site_url(); ?>Ceba/Update_Requisito";
        var id = $('#id_curso').val();

        if (Valida_Update_Requsito()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba/Detalles_Curso/"+id;
                    });
                }
            });      
        }
    }

    function Valida_Update_Requsito() {
        if($('#id_tipo_requisito').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo Requisito.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#desc_requisito').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status').val().trim() === '0') {
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