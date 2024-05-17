
<form id="formulario_codigo" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Código (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            
            <div class="form-group col-md-2">
                <label>Letra:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="letra" name="letra" maxlength="2" placeholder="Ingresar Letra" autofocus onkeypress="if(event.keyCode == 13){ Insert_Codigo(); }">
            </div>

            <div class="form-group col-md-2">
                <label>Inicio:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control inicio" value="0" id="num_inicio" name="num_inicio" maxlength="5" placeholder="Ingresar Letra" autofocus onkeypress="if(event.keyCode == 13){ Insert_Codigo(); }">
            </div>

            <div class="form-group col-md-2">
                <label>Fin:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control fin" value="1" id="num_fin" name="num_fin" maxlength="5" placeholder="Ingresar Letra" autofocus onkeypress="if(event.keyCode == 13){ Insert_Codigo(); }">
            </div>

            <div class="form-group col-md-2">
                <label>Año:</label>
            </div>

            <div class="form-group col-md-10">
                <select required class="form-control" name="id_anio" id="id_anio" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $tipo){ ?>
                        <option value="<?php echo $tipo['id_anio']; ?>"><?php echo $tipo['nom_anio'];?></option>
                    <?php } ?>
                </select>
            </div>
            

        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Codigo()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('#letra').bind('keyup paste', function(){
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
    });
    $('#num_inicio').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#num_fin').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $(document).ready(function() {
        /**/var msgDate = '';
        var inputFocus = '';

        $(".inicio").TouchSpin({
            min: 1,
            max: 99999,
            step: 1,
            decimals: 0,
        });

        $(".fin").TouchSpin({
            min: 2,
            max: 99999,
            step: 1,
            decimals: 0,
            //prefix: 'A/'
        });
        
    });


    function Insert_Codigo(){

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

        var dataString = new FormData(document.getElementById('formulario_codigo'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Codigo";
        if (valida_codigo()) {
            bootbox.confirm({
                title: "Registrar Código",
                message: "¿Desea registrar nuevos códigos?",
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
                                if(data=="activo"){
                                    swal.fire(
                                        'Registro Denegado!',
                                        'Existe un código activo',
                                        'error'
                                    ).then(function() {
                                    });
                                }else if(data=="error"){
                                    swal.fire(
                                        'Registro Denegado!',
                                        'Existe un código para el año o letra seleccionado',
                                        'error'
                                    ).then(function() {
                                    });
                                }else{
                                    swal.fire(
                                        'Registro Exitoso!',
                                        '',
                                        'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>Snappy/Codigo";
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
    

    function valida_codigo() {
        if($('#letra').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar letra.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#num_inicio').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar número de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#num_fin').val().trim() == '' || $('#num_fin').val().trim() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar número de fin.',
                'warning'
            ).then(function() { });
            return false;
        }
        
        if(parseFloat($('#num_fin').val()) == parseFloat($('#num_inicio').val())) {
            Swal(
                'Ups!',
                'Los números de inicio y fin no deben ser iguasles',
                'warning'
            ).then(function() { });
            return false;
        }

        if(parseFloat($('#num_fin').val()) < parseFloat($('#num_inicio').val())) {
            Swal(
                'Ups!',
                'Número fin no debe ser menor que número de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_anio').val()=='0' ) {
            Swal(
                'Ups!',
                'Debe seleccionar año.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
