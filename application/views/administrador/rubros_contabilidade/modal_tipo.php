<form id="from_foto" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Rubro (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_tipo" name="nom_tipo" placeholder="Ingresar Nombre" autofocus onkeypress="if(event.keyCode == 13){ Insert_Tipo(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Status: </label>
            </div>
            <div class="form-group col-sm-4">
                <select class="form-control" name="id_status" id="id_status">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>"><?php echo $estado['nom_status'];?></option>
                    <?php } ?>
                </select>
            </div>

        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Tipo();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Tipo(){
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
        var url="<?php echo site_url(); ?>Administrador/Insert_Rubro_Contabilidade";

        if (Valida_Insert_Tipo()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Administrador/Rubro_Contabilidade";
                    });
                }
            });           
        }
    }

    function Valida_Insert_Tipo() {
        if($('#nom_tipo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe Ingresar un nombre.',
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
