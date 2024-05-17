<div class="col-md-12 row">
    <div class="form-group col-md-1">
        <label class="text-bold">Mes/Año:</label>
    </div>
    <div class="form-group col-md-2">
        <select id="mes_anioi" name="mes_anioi" class="form-control" onchange="Estado_Bancario_Mes_Anio();">
            <option value="0">Seleccione</option>
            <?php foreach($list_mes_anio as $list){ ?>
                <option value="<?php echo $list['mes'].$list['anio']."_".$list['mes_anio']; ?>"><?php echo $list['mes_anio']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-1">
        <a type="button" id="btn_modal" name="btn_modal" class="btn btn-primary">Actualizar Mes</a>
        <button type="button" style="display:none" id="modal_mes" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?=site_url('Administrador/Modal_Update_Estado_Bancario_Mes_Anio_Varios') ?>/<?php echo $id_estado_bancario; ?>"></button>
    </div>
</div>
<form id="form_cuentas">
    <input type="hidden" id="mes_anioe_f" name="mes_anioe_f" value="0">
    <div id="lista_estado_bancario_mes_anio" class="col-lg-12">
        <table class="table table-hover table-bordered table-striped" id="example" width="100%">
            <thead>
                <tr>
                    <th class="text-center" width="10%" title="Mes/Año Snappy">Mes/Año Snp</th>    
                    <th class="text-center" width="10%" title="Mes/Año Arpay">Mes/Año</th>
                    <th class="text-center" width="10%">Tipo</th>
                    <th class="text-center" width="10%">Fecha</th>
                    <!--<th class="text-center" width="10%">Monto</th>-->
                    <th class="text-center" width="10%" title="Saldo Snappy">Saldo Snp</th>
                    <th class="text-center" width="10%" title="Saldo Arpay">Saldo</th>
                    <th class="text-center" width="10%">Monto Real</th>
                    <th class="text-center" width="20%">Descripción</th>
                    <th class="text-center" width="6%">Ref</th>
                    <th class="text-center" width="10%">Operación</th>
                    <th class="text-center" width="4%"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar '+title+'"/>');
            }
            
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 9 ]
                }
            ]
        } );
    } );

    function Estado_Bancario_Mes_Anio(tipo){
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

        var mes_anio = $("#mes_anioi").val();
        var id_estado_bancario = $("#id_estado_bancario").val();
        var url="<?php echo site_url(); ?>Administrador/Estado_Bancario_Mes_Anio";
        
        $.ajax({
            type:"POST",
            url:url,
            data:{'mes_anio':mes_anio,'id_estado_bancario':id_estado_bancario},
            success:function (data) {
                $('#lista_estado_bancario_mes_anio').html(data);
            }
        });
    }

    $("#btn_modal").on('click', function(e){
        var contador=0;
        var contadorf=0;

        $("input[type=checkbox]").each(function(){
        if($(this).is(":checked"))
        contador++;
        }); 

        if(contador>0 && document.getElementById('total').checked){
        contadorf=contador-1;
        }else{
        contadorf=contador;
        }
        
        if(contadorf>0){
        $('#modal_mes').click();    
        }else{
        Swal(
            'Ups!',
            'Debe seleccionar al menos 1 registro.',
            'warning'
        ).then(function() { });
        return false;
        }
    });

    function seleccionart(){
        if (document.getElementById('total').checked){
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_registro')
                inp[i].checked=1;
            }
        }else{
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_registro')
                inp[i].checked=0;
            }
        }
    }

    function Update_Mes(){
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
        var contador=0;
        var contadorf=0;

        $("input[type=checkbox]").each(function(){
        if($(this).is(":checked"))
        contador++;
        }); 

        if(contador>0 && document.getElementById('total').checked){
            contadorf=contador-1;
        }else{
            contadorf=contador;
        }

        var dataString = new FormData(document.getElementById('form_cuentas'));
        var url="<?php echo site_url(); ?>Administrador/Update_Estado_Bancario_Fecha_Varios";

        if (Valida_Update_Mes()) {
            bootbox.confirm({
                title: "Actualizar Mes",
                message: "¿Desea actualizar Mes/Año de "+contadorf+" registro(s)?",
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
                            var cadena = data.trim();
                            validacion = cadena.substr(0, 1);
                            mensaje = cadena.substr(1);
                            if (validacion == 1) {
                                swal.fire(
                                    'Actualización con Errores!',
                                    mensaje,
                                    'warning'
                                ).then(function() {
                                    Estado_Bancario_Mes_Anio();
                                    $("#acceso_modal_mod .close").click();
                                });
                            } else if (validacion == 2) {
                                swal.fire(
                                    'Actualización Exitosa!',
                                    mensaje,
                                    'success'
                                ).then(function() {
                                    Estado_Bancario_Mes_Anio();
                                    $("#acceso_modal_mod .close").click();
                                });
                            }
                            
                        }
                    });
                    }
                } 
            });             
        }
    }

    function Valida_Update_Mes() {
        if($('#mes_anioe').val() === '0') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Envío.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function MesRegistro(){
        var mes_anioe=$('#mes_anioe2').val();
        $('#mes_anioe_f').val(mes_anioe);
    }
</script>