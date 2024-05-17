<style>
    .grande_check{
        width: 20px;
        height: 20px;
        margin: 0 10px 0 0 !important;
    }

    .label_check{
        position: relative;
        top: -4px;
    }
</style>

<form id="formulario_update_doc" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Documento Cargado</b></h5>
    </div>
 
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Alumno:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Código" value="<?php echo $get_id[0]['nom_alumno']; ?>" disabled>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Departamento" value="<?php echo $get_id[0]['Codigo'] ?>" maxlength="100" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Departamento" value="<?php echo $get_id[0]['Especialidad'] ?>" maxlength="100" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Nombre" value="<?php echo $get_id[0]['nom_documento']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="estado_u" id="estado_u" class="form-control" onchange="Motivo()">
                    <option value="0">Seleccione</option>
                    <option value="2" <?php if($get_id[0]['estado']==2){echo "selected";}?>>Recibido</option>
                    <?php if($get_id[0]['estado']==3){?>
                    <option value="3" <?php if($get_id[0]['estado']==3){echo "selected";}?>>Anulado</option>
                    <?php }?> 
                    <option value="4" <?php if($get_id[0]['estado']==4){echo "selected";}?>>Tramitado</option>
                </select>
            </div>

            <div class="form-group col-md-2" id="lbl_motivo" style="display:<?php if($get_id[0]['estado']==3){echo "block";}else{echo "none";}?>">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div class="form-group col-md-4" id="inp_motivo" style="display:<?php if($get_id[0]['estado']==3){echo "block";}else{echo "none";}?>">
                <select name="id_motivo_u" id="id_motivo_u" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_motivo']==1){echo "selected";}?>>Documento Ilegible</option>
                    <option value="2" <?php if($get_id[0]['id_motivo']==2){echo "selected";}?>>Documento Incompleto</option>
                    <option value="3" <?php if($get_id[0]['id_motivo']==3){echo "selected";}?>>Otros</option>
                </select>
            </div>
        </div>     	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_doc_cargado" name="id_doc_cargado" value="<?php echo $get_id[0]['id_doc_cargado']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Documento_Recibido()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Documento_Recibido(){
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

        var dataString = new FormData(document.getElementById('formulario_update_doc'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Documento_Recibido";

        if (Valida_Update_Documento_Recibido()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Documento_Recibido($('#tipo_i').val());
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Documento_Recibido() {
        if($('#estado_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val()==3){
            if($('#id_motivo_u').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Motivo.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }

    function Motivo(){
        var div1 = document.getElementById("lbl_motivo");
        var div2 = document.getElementById("inp_motivo");
        $('#id_motivo_u').val('0');
        if($('#estado_u').val()==3){
            div1.style.display = "block";
            div2.style.display = "block";
        }else{
            div1.style.display = "none";
            div2.style.display = "none";
        }
    }
</script>