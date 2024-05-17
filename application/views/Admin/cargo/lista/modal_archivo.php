<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>

<form id="formulario_archi" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel" ><b>Subir Archivo:</b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="text-bold">Nombre del documento: </label>
                <div class="col">
                    <input type="text" class="form-control" id="nom_archivo" maxlength="20" name="nom_archivo" placeholder="Nombre de Documento" onkeypress="if(event.keyCode == 13){ Guardar_Archivo(); }">
                </div> 
            </div>
              

            <div class="form-group col-md-4">
                <label class="text-bold">Archivo: </label>
                <div class="col">
                    <div class="col">
                        <input id="archivo" name="archivo" type="file" size="100" required data-allowed-file-extensions='["JPG|jpg|png|PNG|jpeg|JPEG|xls|xlsx|pdf"]' onkeypress="if(event.keyCode == 13){ Guardar_Archivo(); }">
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_cargo" type="hidden" maxlength="50" class="form-control" id="id_cargo" placeholder="Ingresar Descripción" value="<?php echo $id_cargo ?>">
        <button type="button" class="btn btn-primary" onclick="Guardar_Archivo()" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
    </div>
</form>

<script>
    function Guardar_Archivo(){
        $(document).ajaxStart(function () {
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
        var id=$('#id_cargo').val();
        var dataString = new FormData(document.getElementById('formulario_archi'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Archivo_Cargo";
        if (Archivo()) {
            bootbox.confirm({
                title: "Registrar Archivo",
                message: "¿Desea guardar nuevo archivo para el cargo",
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
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: 'Existe un archivo con el mismo nombre',
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }else if(data==1){
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: '¡Solo se puede adjuntar 5 documentos por cargo!',
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }
                                else{
                                    swal.fire(
                                        'Registro Exitoso!',
                                        '',
                                        'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>Snappy/Vista_Upd_Cargo/"+id;
                                        
                                    });
                                }
                            }
                        });
                    }
                } 
            });
        }
    }

    function Archivo() {
        if($('#nom_archivo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre de Documento.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#archivo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe adjuntar Documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
