<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button> 
    <h5 class="modal-title"><b>Asignar Cofre</b></h5>
</div>

<div class="modal-body" style="max-height:450px; overflow:auto;"> 
    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="form-group col text-bold">Cofre:</label>                 
        </div>
        <div class="form-group col-md-4">
            <input type="text" class="form-control" id="cofre" name="cofre" placeholder="Cofre" maxlength="30" onkeypress="if(event.keyCode == 13){ Asignar_Cofre_Cierre_Caja(); }">
        </div>  
    </div> 
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="Asignar_Cofre_Cierre_Caja();">
        <i class="glyphicon glyphicon-ok-sign"></i> Guardar
    </button>    
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
    </button>
</div>

<script>
    function Asignar_Cofre_Cierre_Caja(){
        Cargando();
        
        var tipo_excel = $("#tipo_excel").val();
        var url = "<?php echo site_url(); ?>AppIFV/Asignar_Cofre_Cierre_Caja";
        var cadena = $("#cadena").val();
        var cantidad = $("#cantidad").val();
        var cofre = $("#cofre").val();

        if (Valida_Asignar_Cofre()) {
            if(cofre==""){
                Swal({
                    title: '¿Realmente desea asignar cofre(s) en blanco?',
                    text: "El cierre de caja tendrá un cofre asignado en blanco",
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
                            url:url,
                            data:{'cadena':cadena,'cantidad':cantidad,'cofre':cofre},
                            success:function (data) {
                                Lista_Cierre_Caja(tipo_excel);
                                $("#acceso_modal .close").click()
                            }
                        });
                    }
                })
            }else{
                $.ajax({
                    type:"POST",
                    url:url,
                    data:{'cadena':cadena,'cantidad':cantidad,'cofre':cofre},
                    success:function (data) {
                        Lista_Cierre_Caja(tipo_excel);
                        $("#acceso_modal .close").click()
                    }
                });
            }
        }
    }

    function Valida_Asignar_Cofre() {
        if($('#cantidad').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar como mínimo un cierre de caja.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
