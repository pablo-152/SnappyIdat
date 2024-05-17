<form id="formulario_direccione" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" ><b>Nueva Dirección </b></h4>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Departamento:</label>
                <select id="departamento" name="departamento" class="form-control" onchange="Provincia();">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_departamento as $list){ ?>
                        <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="mprovincia" class="form-group col-md-2">
                <label class="control-label text-bold">Provincia:</label>
                <select id="provincia" name="provincia" class="form-control" onchange="Distrito();">
                    <option value="0" >Seleccione</option>
                </select>
            </div>

            <div id="mdistrito" class="form-group col-md-2">
                <label class="control-label text-bold">Distrito:</label>
                <select id="distrito" name="distrito" class="form-control">
                    <option value="0" >Seleccione</option>
                </select>
            </div>
        
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Persona Cont:</label>
                <input type="text" class="form-control"  id="contacto_dir" name="contacto_dir">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular:</label>
                <input type="text" class="form-control" maxlength="9" id="celular_dir" name="celular_dir">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tel Fijo:</label>
                <input type="text" class="form-control" maxlength="9" id="tel_fijo" name="tel_fijo" >
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo:</label>
                <input type="text" class="form-control" id="correo_dir" name="correo_dir">
            </div>

            <div class="form-group col-md-1">
                <br>
                <div class="row">
                    &nbsp;&nbsp;
                    <input type="checkbox" id="cp" name="cp" value="1" class="mt-1" > 
                    &nbsp;&nbsp;
                    <label class="control-label text-bold">CP</label>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_ultimo_historial" id="id_ultimo_historial" value="<?php echo $get_id[0]['id_ultimo_h'] ?>">
        <input name="id_centro" type="hidden" class="form-control" id="id_centro" value="<?php echo $id_centro; ?>">
        <button type="button" class="btn btn-primary" onclick="Agregar_Direccione()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>
<script>
    $('#tel_fijo').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#celular_dir').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Provincia(){
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
        var url = "<?php echo site_url(); ?>AppIFV/Busca_Provincia";
        var id_departamento = $('#departamento').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento},
            success: function(data){
                $('#mprovincia').html(data);
            }
        });
        Distrito();
    }

    function Distrito(){
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
        var url = "<?php echo site_url(); ?>AppIFV/Busca_Distrito";
        var id_departamento = $('#departamento').val();
        var id_provincia = $('#provincia').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia},
            success: function(data){
                $('#mdistrito').html(data);
            }
        });
    }

    function Agregar_Direccione() {
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
        var id_centro=$('#id_centro').val();
        var dataString = new FormData(document.getElementById('formulario_direccione'));
        var url="<?php echo site_url(); ?>AppIFV/Agregar_Direccion_Centro";
        if (Valida_Direccione()) {
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
                            text: "¡La dirección ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        var url2="<?php echo site_url(); ?>AppIFV/List_Guardado_Direccion";
                        var dataString2 = new FormData(document.getElementById('formulario_direccione'));
                        
                        $.ajax({
                            type:"POST",
                            url: url2,
                            data:dataString2,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                            $('#div_direccione').html(data);
                            //$("#ModalUpdate .close").click()
                            window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Centro/"+id_centro;
                        }
                        });
                    }
                    
                    
                    
                }
            });
        }
        
    }

    function Valida_Direccione() {
        if($('#direccion').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar dirección.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#departamento').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar departamento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#provincia').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar provincia.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#distrito').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar distrito.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#celular_dir').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Celular.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#celular_dir').val().length!=9) {
            Swal(
                'Ups!',
                'N° de Celular inválido.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
