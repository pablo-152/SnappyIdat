<form id="formulario_code" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Update_Tipo')?>"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualizar Código: </b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Letra:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="letra" name="letra" maxlength="2" value="<?php echo $get_id[0]['letra'] ?>" placeholder="Ingresar Letra" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_Codigo(); }">
                <input type="hidden" class="form-control" id="letra_anterior" name="letra_anterior" maxlength="2" value="<?php echo $get_id[0]['letra'] ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label>Inicio:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control inicio"  id="num_inicio" maxlength="5" value="<?php echo $get_id[0]['num_inicio'] ?>" name="num_inicio" placeholder="Ingresar Cantidad" onkeypress="if(event.keyCode == 13){ Actualizar_Codigo(); }">
            </div>

            <div class="form-group col-md-2">
                <label>Fin:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control fin"  id="num_fin" maxlength="5" value="<?php echo $get_id[0]['num_fin'] ?>" name="num_fin" placeholder="Ingresar Cantidad" onkeypress="if(event.keyCode == 13){ Actualizar_Codigo(); }">
                <input type="hidden" class="form-control"  id="num_fin_anterior" value="<?php echo $get_id[0]['num_fin'] ?>" name="num_fin_anterior">
            </div>

            <div class="form-group col-md-2">
                <label>Año:</label>
            </div>

            <div class="form-group col-md-10">
                <select required class="form-control" name="id_anio" id="id_anio" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ if($get_id[0]['id_anio']==$list['id_anio']){?>
                        <option selected value="<?php echo $list['id_anio']; ?>"><?php echo $list['nom_anio'];?></option>
                    <?php }else{?> 
                        <option value="<?php echo $list['id_anio']; ?>"><?php echo $list['nom_anio'];?></option>
                    <?php } } ?>
                </select>
            </div>
        
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <input name="id_codigo_inventario" type="hidden" class="form-control" id="id_codigo_inventario" value="<?php echo $get_id[0]['id_codigo_inventario']; ?>">
        <button type="button" class="btn btn-primary" onclick="Actualizar_Codigo()" data-loading-text="Loading..." autocomplete="off">
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
            //prefix: 'A/'
        });

        $(".fin").TouchSpin({
            min: 2,
            max: 99999,
            step: 1,
            decimals: 0,
            //prefix: 'A/'
        });
        
    });

    function Actualizar_Codigo(){
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
        var dataString = new FormData(document.getElementById('formulario_code'));
        var url="<?php echo site_url(); ?>Snappy/Update_Codigo";
   
        if (valida_codeu()) {
            bootbox.confirm({
                title: "Editar Datos del Código",
                message: "¿Desea actualizar datos de Código?",
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
                                    'Actualización Denegada!',
                                    'Existe un código para el año o letra seleccionado',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Actualización Exitosa!',
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
        }
    }

    

    function valida_codeu() {
        if($('#letra').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar letra.',
                'warning'
            ).then(function() { });
            return false;
        }

       if($('#num_inicio').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar número de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#num_fin').val() === '' || $('#num_fin').val() === '0') {
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

        var ini = parseFloat($('#num_inicio').val());
        var fin = parseFloat($('#num_fin').val());
        if(ini > fin ) {
            Swal(
                'Ups!',
                'Número fin no debe ser menor que número de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_anio').val()=='0') {
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
