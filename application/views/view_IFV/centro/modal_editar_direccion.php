<form id="formulario_dire" method="POST" enctype="multipart/form-data" action="<?= site_url('AppIFV/Update_Postulante')?>"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Actualización Dirección </b></h4>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Dirección: </label>
                <div class="col">
                    <input name="direccion" type="text" class="form-control" id="direccion" value="<?php echo $get_id[0]['direccion']; ?>">
                </div>
            </div>
            

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Departamento: </label>
                <div class="col">
                    <select class="form-control" name="departamento" id="departamento" onchange="Provincia()">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_departamento as $list){ 
                        if($get_id[0]['departamento'] == $list['id_departamento']){ ?>
                        <option selected value="<?php echo $list['id_departamento'] ; ?>">
                        <?php echo $list['nombre_departamento'];?></option>
                        <?php }else
                        {?>
                        <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>
            

            <div class="form-group col-md-2" id="mprovinciad">
                <label class="control-label text-bold">Provincia: </label>
                <div class="col">
                    <select class="form-control" name="provincia" id="provincia" onchange="Distrito()">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_provincia as $list){ 
                        if($get_id[0]['provincia'] == $list['id_provincia']){ ?>
                        <option selected value="<?php echo $list['id_provincia'] ; ?>">
                        <?php echo $list['nombre_provincia'];?></option>
                        <?php }else
                        {?>
                        <option value="<?php echo $list['id_provincia']; ?>"><?php echo $list['nombre_provincia'];?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>
            

            <div class="form-group col-md-2" id="mdistritod">
                <label class="control-label text-bold">Distrito: </label>
                <div class="col">
                    <select class="form-control" name="distrito" id="distrito">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_distrito as $list){ 
                        if($get_id[0]['distrito'] == $list['id_distrito']){ ?>
                        <option selected value="<?php echo $list['id_distrito'] ; ?>">
                        <?php echo $list['nombre_distrito'];?></option>
                        <?php }else
                        {?>
                        <option value="<?php echo $list['id_distrito']; ?>"><?php echo $list['nombre_distrito'];?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Persona Cont:</label>
                <input type="text" class="form-control"  id="contacto_dir" name="contacto_dir" value="<?php echo $get_id[0]['contacto_dir'] ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular:</label>
                <input type="text" class="form-control" maxlength="9" id="celular_dir" name="celular_dir" value="<?php echo $get_id[0]['celular_dir'] ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tel Fijo:</label>
                <input type="text" class="form-control" maxlength="9" id="tel_fijo" name="tel_fijo" value="<?php echo $get_id[0]['tel_fijo'] ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo:</label>
                <input type="text" class="form-control" id="correo_dir" name="correo_dir" value="<?php echo $get_id[0]['correo_dir'] ?>">
            </div>
            

            <div class="form-group col-md-2">
                <label class="control-label text-bold">CP</label>
                &nbsp;&nbsp;
                <input type="checkbox" <?php if($get_id[0]['cp']==1 ){ echo "checked"; }?> id="cp" name="cp" value="1" class="mt-1"> 
                &nbsp;&nbsp;
                
            </div>

        </div>


    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_ultimo_historial" id="id_ultimo_historial" value="<?php echo $get_id_u[0]['id_ultimo_h'] ?>">
        <input name="id_centro_direccion" type="hidden" class="form-control" id="id_centro_direccion" value="<?php echo $get_id[0]['id_centro_direccion']; ?>">
        <input name="id_centro" type="hidden" class="form-control" id="id_centro" value="<?php echo $id_centro; ?>">
        <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    /*$('#contacto_dir').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });*/
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
                $('#mprovinciad').html(data);
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
                $('#mdistritod').html(data);
            }
        });
    }

    $("#createProductBtn").on('click', function(e){
        if (valida_edit_direccion()) {
            bootbox.confirm({
                title: "Actualizar Dirección",
                message: "¿Desea ctualizar datos de dirección?",
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
                        var dataString = new FormData(document.getElementById('formulario_dire'));
                        var id_centro=$('#id_centro').val();
                        var url="<?php echo site_url(); ?>AppIFV/Update_DireccionCentro";
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                swal.fire(
                                    'Actualización Exitosa!',
                                    'Haga clic en el botón!',
                                    'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Centro/"+id_centro;
                                    });
                                
                            }
                        });
                    }
                } 
            });        
        }
    });

    function valida_edit_direccion() {
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
        }if($('#provincia').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar provincia.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#distrito').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar distrito.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>