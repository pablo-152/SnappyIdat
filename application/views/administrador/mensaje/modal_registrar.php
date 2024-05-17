<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>SMS (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold">Tipo Envío: </label>
                <select class="form-control" id="tipo_envio" name="tipo_envio" onchange="Tipo_Envio();">
                    <option value="1">Persona</option>
                    <option value="2">Base de Datos</option>
                </select>
            </div>

            <div id="div_persona" class="form-group col-md-3">
                <label class="control-label text-bold">Celular: </label>
                <input type="text" class="form-control" id="numero" name="numero" maxlength="9" placeholder="Celular" onkeypress="if(event.keyCode == 13){ Insert_Mensaje(); }">
            </div>

            <div class="form-group col-md-5 div_bd">
                <label class="control-label text-bold">Base de Datos: </label>
                <select class="form-control" id="id_base_datos" name="id_base_datos" onchange="Detalle_Base_Datos();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_base_datos as $list){ ?>
                        <option value="<?php echo $list['id_base_datos']; ?>"><?php echo $list['nom_base_datos']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="cantidad_numeros" class="form-group col-md-2 div_bd">
                <label class="control-label text-bold">Cantidad: </label>
                <input type="text" class="form-control" readonly placeholder="Cantidad" value="0">
            </div>

            <div id="modal_numeros" class="form-group col-md-2 div_bd">
                <p style="color:transparent;">Ver:</p>
                <img src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;cursor:hand;">
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Motivo: </label>
                <input type="text" class="form-control" id="motivo" name="motivo" placeholder="Motivo" onkeypress="if(event.keyCode == 13){ Insert_Mensaje(); }">
            </div>
            
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Mensaje:</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Mensaje" maxlength="160"></textarea>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Mensaje();">
            <i class="glyphicon glyphicon-ok-sign"></i> Enviar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".div_bd").hide();
    });

    $('#numero').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

<script>
    function Tipo_Envio(){
        var tipo_envio = $("#tipo_envio").val();

        if(tipo_envio==1){
            $("#div_persona").show();
            $(".div_bd").hide();
            $("#id_base_datos").val(0);
        }else{
            $("#div_persona").hide();
            $(".div_bd").show();
            $("#numero").val('');
            Detalle_Base_Datos();
        }
    }

    function Detalle_Base_Datos(){
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

        var id_base_datos = $("#id_base_datos").val();

        if(id_base_datos==0){
            $("#cantidad_numeros").html("<label class='control-label text-bold'>Cantidad:</label><input type='text' class='form-control' id='cantidad_numeros' readonly placeholder='Cantidad' value='0'>");
            $("#modal_numeros").html("<p style='color:transparent;''>Ver:</p><img src='<?= base_url() ?>template/img/ver.png' style='cursor:pointer;cursor:hand;'>");
        }else{
            var url="<?php echo site_url(); ?>Administrador/Contar_Numeros_Base_Datos";
            $.ajax({
                type:"POST",
                url:url,
                data: {'id_base_datos':id_base_datos},
                success:function (data) {
                    $("#cantidad_numeros").html("<label class='control-label text-bold'>Cantidad:</label><input type='text' class='form-control' id='cantidad_numeros' readonly placeholder='Cantidad' value='"+data+"'>");

                    var url="<?php echo site_url(); ?>Administrador/Traer_Numeros_Base_Datos";
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: {'id_base_datos':id_base_datos},
                        success:function (data) {
                            $("#tabla_numeros").html(data);
                            $("#modal_numeros").html("<p style='color:transparent;'>Ver:</p><img src='<?= base_url() ?>template/img/ver.png' data-toggle='modal' data-target='#dataUpdate' style='cursor:pointer;cursor:hand;'>");
                        }
                    });
                }
            });
        }
        
    }

    function Insert_Mensaje(){
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

        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Administrador/Insert_Mensaje";
        if (Valida_Mensaje()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function () {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Administrador/Mensaje";
                    });
                }
            });
        }
    }

    function Valida_Mensaje() {
        var celu = $('#numero').val();
        var num = celu.split('');

        if($('#numero').val().trim() === '' && $('#id_base_datos').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar Celular o seleccionar base de datos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#numero').val()!='') {
            if(num[0]!=9 || celu.length!=9) {
                Swal(
                    'Ups!',
                    'Formato de Celular Inválido.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#motivo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Motivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mensaje').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Mensaje.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>