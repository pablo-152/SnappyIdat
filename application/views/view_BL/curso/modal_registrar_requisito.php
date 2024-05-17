<form id="formulario_insert_requisito" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Requisito (Nuevo)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Grado: </label>
                <div class="col">
                    <select class="form-control" disabled>
                        <?php foreach($list_grado as $list){ ?>
                            <option value="<?php echo $list['id_grado']; ?>" <?php if($list['id_grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_grado']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <input type="hidden" id="id_grado_i" name="id_grado_i" value="<?php echo $get_id[0]['id_grado']; ?>"/>
            
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" name="id_tipo_requisito_i" id="id_tipo_requisito_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo_requisito as $list){ ?>
                            <option value="<?php echo $list['id_tipo_requisito']; ?>"><?php echo $list['nom_tipo_requisito']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Descripción: </label>
                <div class="col">
                    <input type="text" class="form-control" id="desc_requisito_i" name="desc_requisito_i" placeholder="Ingresar Descripción"/>
                </div>
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <input name="id_curso" type="hidden" class="form-control" id="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Requisito();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Requisito(){
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

        var dataString = new FormData(document.getElementById('formulario_insert_requisito'));  
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Requisito";
        var id = $('#id_curso').val();
       
        if (Valida_Insert_Requisito()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Requisito();
                    $("#acceso_modal .close").click()
                }
            });   
        }
    }

    function Valida_Insert_Requisito() {
        if($('#id_tipo_requisito_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#desc_requisito_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
