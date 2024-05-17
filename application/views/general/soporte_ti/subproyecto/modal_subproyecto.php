<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"> <b>Sub-Proyecto (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_empresa" id="id_empresa" onchange="Proyecto()">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Proyecto: </label>
            </div>
            <div class="form-group col-md-4" id="mproyecto">
                <select class="form-control" name="id_proyecto_soporte" id="id_proyecto_soporte">
                    <option  value="0"  selected>Seleccionar</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sub&nbsp;Proyecto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="subproyecto" name="subproyecto" placeholder="Ingresar Sub-Proyecto">
            </div>
        </div>  	           	                	        
    </div> 


    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Soporte_Subproyecto();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    function Proyecto(){
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

        var url = "<?php echo site_url(); ?>General/Busca_Proyecto";
        var id_empresa = $('#id_empresa').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#mproyecto').html(data);
            }
        });
    }

    function Insert_Soporte_Subproyecto(){
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>General/Insert_Soporte_Subproyecto";

        if (Valida_Insert_Soporte_Subproyecto()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
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
                        window.location = "<?php echo site_url(); ?>General/Soporte_Subproyecto";
                    }
                }
            });
        }    
    }

    function Valida_Insert_Soporte_Subproyecto() {
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_proyecto_soporte').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Proyecto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#subproyecto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Subproyecto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
