<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Base de Datos (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold">Empresa: </label> 
                <select class="form-control" id="id_empresa_i" name="id_empresa_i" onchange="Sede_I();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                    <?php } ?>
                </select>
            </div> 
            
            <div id="div_sede_i" class="form-group col-md-3">
                <label class="control-label text-bold">Sede:</label>
                <select class="form-control" id="id_sede_i" name="id_sede_i">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Base de Datos: </label>
                <input type="text" class="form-control" id="nom_base_datos_i" name="nom_base_datos_i" placeholder="Base de Datos" onkeypress="if(event.keyCode == 13){ Insert_Base_Datos(); }">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Archivo: </label>
                <a href="<?= site_url('Administrador/Plantilla_Base_Datos') ?>" title="Estructura de Excel">
                    <img src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel"/>
                </a>
                <input type="file" id="archivo_i" name="archivo_i" data-allowed-file-extensions='["xls|xlsx"]' size="100" required>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Base_Datos();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Sede_I(){
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
        
        var url = "<?php echo site_url(); ?>Administrador/Buscar_Sede_I";
        var id_empresa = $("#id_empresa_i").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#div_sede_i').html(data);
            }
        });
    }

    function Insert_Base_Datos(){
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

        var tipo = $("#tipo_excel").val();
        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Administrador/Insert_Base_Datos";
        var url2="<?php echo site_url(); ?>Administrador/Insert_Base_Datos_Con_Error";

        if (Valida_Base_Datos()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data!=""){
                        if(data=="error"){
                            Swal({
                                title: 'Registro Denegado',
                                text: "¡El registro ya existe!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else{
                            swal.fire(
                                'Errores Encontrados!',
                                data.split("*")[0],
                                'error'
                            ).then(function() {
                                if(data.split("*")[1]=="INCORRECTO"){
                                    Lista_Base_Datos(tipo);
                                     $("#acceso_modal .close").click()
                                }else{
                                    Swal({
                                        title: '¿Desea registrar de todos modos?',
                                        text: "El archivo contiene errores y no se cargara esa(s) fila(s)",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si',
                                        cancelButtonText: 'No',
                                    }).then((result) => {
                                        if (result.value) {
                                            $.ajax({
                                                type:"POST",
                                                url:url2,
                                                data: dataString,
                                                processData: false,
                                                contentType: false,
                                                success:function () {
                                                    Lista_Base_Datos(tipo);
                                                    $("#acceso_modal .close").click()
                                                }
                                            });
                                        }
                                    })
                                }
                            });
                        }
                    }else{
                        Lista_Base_Datos(tipo);
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Base_Datos() {
        if($('#id_empresa_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sede.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_base_datos_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Base de Datos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#archivo_i').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Archivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>