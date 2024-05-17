<form id="from_foto" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Sub-Tipo (Nuevo)</b></h5>
    </div>
    
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_tipo" id="id_tipo">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo as $tipo){ ?>
                        <option value="<?php echo $tipo['id_tipo']; ?>"><?php echo $tipo['nom_tipo'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_empresa" id="id_empresa">
                    <option value="0">Seleccione</option>
                    <?php foreach($combo_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold">SubTipo: </label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control" id="nom_subtipo" name="nom_subtipo" placeholder="Ingresar Sub-tipo" autofocus onkeypress="if(event.keyCode == 13){ Insert_Subtipo(); }">
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Arte/Foto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="tipo_subtipo_arte" name="tipo_subtipo_arte" placeholder="Ingresar Arte/Foto" autofocus onkeypress="if(event.keyCode == 13){ Insert_Subtipo(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Redes: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="tipo_subtipo_redes" name="tipo_subtipo_redes" placeholder="Ingresar Redes" autofocus onkeypress="if(event.keyCode == 13){ Insert_Subtipo(); }">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_status" id="id_status">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>" <?php if($estado['id_status']==2){ echo "selected"; } ?>>
                            <?php echo $estado['nom_status'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Reporte Redes (mensual): </label>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" id="rep_redes" name="rep_redes" value="1" class="minimal" onkeypress="if(event.keyCode == 13){ Insert_Subtipo(); }"/>
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Subtipo();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Subtipo(){ 
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

        var dataString = new FormData(document.getElementById('from_foto'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Subtipo";

        if (Valida_Insert_Subtipo()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>Snappy/Subtipo";
                }
            });      
        }
    }

    function Valida_Insert_Subtipo() {
        if($('#id_tipo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_subtipo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status').val() === '0') {
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
