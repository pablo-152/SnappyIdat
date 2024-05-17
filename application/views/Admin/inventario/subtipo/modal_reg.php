
<form id="formulario_subt" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Subtipo (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            
            <div class="form-group col-md-2">
                <label>Tipo</label>
            </div>

            <div class="form-group col-md-10">
                <select required class="form-control" name="id_tipo_inventario" id="id_tipo_inventario">
                <option value="0">Seleccione</option>
                <?php foreach($list_tipo as $list){ ?>
                    <option value="<?php echo $list['id_tipo_inventario']; ?>"><?php echo $list['nom_tipo_inventario'];?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Sub-Tipo</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_subtipo_inventario" name="nom_subtipo_inventario" placeholder="Ingresar Nombre" autofocus onkeypress="if(event.keyCode == 13){ Insert_Subtipo(); }">
            </div>

            <div class="form-group col-md-2">
                <label>Intervalo de Revisión (mes)</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="intervalo_rev" name="intervalo_rev" placeholder="Ingresar Intervalo" autofocus onkeypress="if(event.keyCode == 13){ Insert_Subtipo(); }">
            </div>

            

        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Subtipo()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('#intervalo_rev').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    function Insert_Subtipo(){
        var dataString = new FormData(document.getElementById('formulario_subt'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Subtipo_Inventario";
        if (valida_subtipo()) {
            bootbox.confirm({
                title: "Registrar Sub-Tipo",
                message: "¿Desea registrar nuevo sub-tipo?",
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
                                    window.location = "<?php echo site_url(); ?>Snappy/SubTipo_Inventario";
                                    
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


    

    function valida_subtipo() {
        if($('#id_tipo_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#nom_subtipo_inventario').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre de subtipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#intervalo_rev').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar intervalo de revisión.',
                'warning'
            ).then(function() { });
            return false;
        }

        
        return true;
    }
</script>
