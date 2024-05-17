<style>
    #modalduplicado {
        position: relative;
        margin-left: -15px;
    }
</style>

<div id="modalduplicado" class="modal-content" style="background-color:#cee7ce">
    <form class="form-horizontal" id="formulario_dupli" method="POST" enctype="multipart/form-data" class="formulario">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"><b>Duplicar Tkt <?php echo $get_id[0]['cod_proyecto'] ?></b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                <div class="form-group col-md-3 text-center">
                    <label class="control-label text-bold">Week Snappy Redes:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" id="s_redesd" name="s_redesd" maxlength="3" placeholder="Ingresar Redes" value="3">
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">&nbsp;</label>
                </div>

                <div class="form-group col-md-3 text-center">
                    <label class="control-label text-bold">Tipo:</label>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control" id="id_tipo_d" name="id_tipo_d" onchange="Traer_Subtipo();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo as $list){ ?>
                            <option value="<?php echo $list['id_tipo']; ?>" <?php if($list['id_tipo']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-3 text-center">
                    <label class="control-label text-bold">Sub-Tipo:</label>
                </div>
                <div id="cmb_subtipo" class="form-group col-md-3">
                    <select class="form-control" id="id_subtipo_d" name="id_subtipo_d">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_subtipo as $list){ ?>
                            <option value="<?php echo $list['id_subtipo']; ?>" <?php if($list['id_subtipo']==$get_id[0]['id_subtipo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_subtipo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">&nbsp;</label>
                </div>

                <div class="form-group col-md-3 text-center">
                    <label class="control-label text-bold">Agenda / Redes:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="date" class="form-control" id="fec_agendad" name="fec_agendad" min="<?php echo date('Y-m-d')?>">
                </div> 
            </div>  	           	                	        
        </div> 

        <div class="modal-footer">
            <input type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $get_id[0]['id_proyecto']; ?>">
            <input type="hidden" name="id_empresa" id="id_empresa" value="<?php echo $get_id[0]['id_empresa']; ?>">
            <button type="button" class="btn" style="background-color:green;color:white" onclick="Agregar_Duplicado();"><i class="glyphicon glyphicon-ok-sign"></i>Duplicar</button> 
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
        </div>
    </form>
</div>

<script>
    $('#s_redesd').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

    function Traer_Subtipo(){
        Cargando();

        var url = "<?php echo site_url(); ?>Administrador/subtipo_xtipo2";
        var id_tipo = $("#id_tipo_d").val();
        var id_empresa = $("#id_empresa").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_tipo':id_tipo,'id_empresa':id_empresa},
            success: function(data) {
                $('#cmb_subtipo').html(data);
            }
        });
    }

    function Agregar_Duplicado(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_dupli'));
        var url="<?php echo site_url(); ?>Administrador/Agregar_Duplicado";

        if (Valida_Agregar_Duplicado()) { 
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    var url1="<?php echo site_url(); ?>Administrador/List_Duplicados";
                    var id_proyecto = $("#id_proyecto").val();

                    $.ajax({    
                        url:url1,
                        type:"POST",
                        data: {'id_proyecto':id_proyecto},
                        success:function (resp) {
                            $('#div_duplicados').html(resp);
                            $("#acceso_modal_eli .close").click()
                        }
                    });
                }
            });
        }
    }

    function Valida_Agregar_Duplicado(){
        if($('#s_redesd').val().trim()===""){
            Swal(
                'Ups!',
                'Debe ingresar Week Snappy Redes.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_d').val().trim()==="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_subtipo_d').val().trim()==="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Sub-Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_agendad').val().trim()===""){
            Swal(
                'Ups!',
                'Debe ingresar Fecha Agenda.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>