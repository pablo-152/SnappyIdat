<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario"> 
    <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Cierre de Caja</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Cofre:</label>                 
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="cofre_u" name="cofre_u" placeholder="Cofre" maxlength="30" value="<?php echo $get_id[0]['cofre']; ?>" onkeypress="if(event.keyCode == 13){ Update_Cierre_Caja(); }">
            </div>  
        </div>
    </div>

    <div class="modal-footer"> 
        <input type="hidden" id="id_cierre_caja" name="id_cierre_caja" value="<?php echo $get_id[0]['id_cierre_caja']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Cierre_Caja();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Cierre_Caja(){
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

        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>Laleli5/Update_Cierre_Caja"; 
        var id_cierre_caja = $("#id_cierre_caja").val();

        if (Valida_Update_Cierre_Caja()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>Laleli5/Detalle_Cierre_Caja/"+id_cierre_caja;
                }
            });
        }    
    }

    function Valida_Update_Cierre_Caja() {
        /*if($('#cofre_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Cofre.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>
