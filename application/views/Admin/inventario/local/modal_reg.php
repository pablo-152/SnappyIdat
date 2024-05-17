

<form id="formulario_local" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Local (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            
            <div class="form-group col-md-2">
                <label>Empresa:</label>
            </div>

            <div class="form-group col-md-10">
                <select required class="form-control" name="id_empresa" id="id_empresa" onchange="Busca_Sede()" >
                <option value="0">Seleccione</option>
                <?php foreach($list_empresa as $tipo){ ?>
                    <option value="<?php echo $tipo['id_empresa']; ?>"><?php echo $tipo['cod_empresa'];?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Sede:</label>
            </div>

            <div class="form-group col-md-10" id="div_sede">
                    <select required class="form-control" name="id_sede" id="id_sede" >
                    <option value="0">Seleccione</option>
                    
                    </select>
            </div>

            <div class="form-group col-md-2">
                <label>Responsable:</label>
            </div>

            <div class="form-group col-md-10">
                <select  class="form-control basic" id="id_responsable" name="id_responsable">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_usuario as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Nombre:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_local" name="nom_local" placeholder="Ingresar Nombre" autofocus onkeypress="if(event.keyCode == 13){ Insert_Local(); }">
            </div>

            

        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Local()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>

    var ss = $(".basic").select2({
        tags: true
    });

    $('.basic').select2({
        dropdownParent: $('#modal_form_vertical')
    });

    function Busca_Sede(){
        var dataString = new FormData(document.getElementById('formulario_local'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Sede_Cargo";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_sede').html(data);
                
            }
        });
    }


    function Insert_Local(){
        var dataString = new FormData(document.getElementById('formulario_local'));
        var url="<?php echo site_url(); ?>Snappy/Insert_local";
        if (valida_local()) {
            bootbox.confirm({
                title: "Registrar Local",
                message: "¿Desea registrar nuevo local?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data=="error"){
                                    swal.fire(
                                    'Registro Denegado!',
                                    'Existe un registro con los mismos datos',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Registro Exitoso!',
                                    '',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Snappy/Local";
                                    
                                });
                                }
                                
                            }
                        });
                    }
                } 
            });      
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }


    

    function valida_local() {
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar empresa.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_sede').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar sede.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_responsable').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar responsable.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#nom_local').val().trim() == '' ) {
            Swal(
                'Ups!',
                'Debe ingresar nombre de local.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
