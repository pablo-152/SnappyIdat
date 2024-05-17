<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar: <b><?php echo $get_id[0]['nom_arpay']; ?></b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Nombre: </label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control" id="nom_arpay" name="nom_arpay" placeholder="Nombre" value="<?php echo $get_id[0]['nom_arpay']; ?>" onkeypress="if(event.keyCode == 13){ Update_Arpay_Online(); }">
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold">Descripción: </label>
        </div>
        <div class="form-group col-md-10">
            <textarea class="form-control" id="descripcion_arpay" name="descripcion_arpay" placeholder="Descripción" rows="5"><?php echo $get_id[0]['descripcion_arpay']; ?></textarea>
        </div>
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_arpay" name="id_arpay" value="<?php echo $get_id[0]['id_arpay']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Arpay_Online();" data-loading-text="Loading..." autocomplete="off">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    function Update_Arpay_Online(){
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

        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>Administrador/Update_Arpay_Online";

        if (Valida_Arpay_Online()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Administrador/Arpay_Online";
                    });
                }
            });       
        }
    }

    function Valida_Arpay_Online() {
        if($('#nom_arpay').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
