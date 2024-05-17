<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" style="color: #715d74;font-size: 21px;"><b>Editar Proyecto</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_empresa" id="id_empresa" >
                    <option value="0">Seleccione</option>
                        <?php foreach($list_empresa as $list){ 
                        if($get_id[0]['id_empresa'] == $list['id_empresa']){ ?>
                        <option selected value="<?php echo $list['id_empresa'] ; ?>">
                        <?php echo $list['cod_empresa'];?></option>
                        <?php }else
                        {?>
                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
                    <?php }} ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Proyecto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?php echo $get_id[0]['proyecto'] ?>" placeholder="Ingresar Proyecto">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_status" id="id_status" >
                    <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ 
                        if($get_id[0]['estado'] == $list['id_status']){ ?>
                        <option selected value="<?php echo $list['id_status'] ; ?>">
                        <?php echo $list['nom_status'];?></option>
                        <?php }else
                        {?>
                    <option value="<?php echo $list['id_status']; ?>"><?php echo $list['nom_status'];?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>  	           	                	        
    </div>


    <div class="modal-footer">
        <input name="id_proyecto_soporte" type="hidden" id="id_proyecto_soporte" value="<?php echo $get_id[0]['id_proyecto_soporte']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Soporte_Proyecto();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    function Update_Soporte_Proyecto(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>General/Update_Soporte_Proyecto";

        if (Valida_Update_Soporte_Proyecto()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>General/Soporte_Proyecto";
                }
            });
        }    
    }

    function Valida_Update_Soporte_Proyecto() {
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#proyecto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Proyecto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
