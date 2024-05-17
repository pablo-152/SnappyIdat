<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Registrar Salida</b></h5>
</div>
 
<div class="modal-body" style="max-height:520px; overflow:auto;">
    <div id="lista_salida" class="col-md-12 row">
        <table class="table" width="100%">
            <thead>
                <tr>
                    <th width="15%">Ingreso</th>
                    <th width="35%">Apellidos</th>
                    <th width="35%">Nombre</th>
                    <th width="15%"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list_salida as $list) {  ?>                                           
                    <tr class="even pointer text-center">
                        <td><?php echo $list['hora_ingreso']; ?></td>   
                        <td style="text-align: left;"><?php echo $list['apellidos']; ?></td>  
                        <td style="text-align: left;"><?php echo $list['nombres']; ?></td>                                                  
                        <td>
                            <a href="#" title="Eliminar" onclick="Update_Registro_Salida('<?php echo $list['id_registro_ingreso']; ?>')" role="button"> 
                                <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>  	           	                	        
</div> 

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
    </button>
</div>

<script>
    function Lista_Registro_Salida(){
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

        var url = "<?php echo site_url(); ?>AppIFV/Lista_Registro_Salida";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#lista_salida').html(resp);
            }
        });
    }

    function Update_Registro_Salida(id){
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

        var url="<?php echo site_url(); ?>AppIFV/Update_Registro_Salida";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_registro_ingreso':id},
            success:function () {
                Botones_Bajos();
                Lista_Registro_Salida();
            }
        });
    }
</script>
