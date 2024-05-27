<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Detalles</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4"> 
                <label class="control-label text-bold">Sexo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="sexo_u" name="sexo_u">
                    <?php if($update_sexo==1){ ?>
                        <option value="0" <?php if($get_id[0]['sexo']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="1" <?php if($get_id[0]['sexo']==1){ echo "selected"; } ?>>Femenino</option>
                        <option value="2" <?php if($get_id[0]['sexo']==2){ echo "selected"; } ?>>Masculino</option>
                    <?php }else{ ?>
                        <option value="0">Seleccione</option>
                        <option value="1">Femenino</option>
                        <option value="2">Masculino</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 row" >
            <div class="form-group col-md-4 " > 
                <label class="control-label text-bold">Institución Proveniencia:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_colegio_prov_u" name="id_colegio_prov_u" onchange="updateLabel()">
                    <option value="0">Seleccione</option>
                    <?php if($update_colegio==1){ ?>
                        <?php foreach($list_colegio_prov as $list){ ?>
                            <option value="<?php echo $list['id']; ?>" <?php if($colegio_prov_empresa[0]['id_colegio_prov']==$list['id']){ echo "selected"; } ?>><?php echo $list['institucion'];?></option>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php foreach($list_colegio_prov as $list){ ?>
                            <option value="<?php echo $list['id']; ?>"><?php echo $list['institucion'];?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4 "> 
                <label class="control-label text-bold" id="infoLabel">
                <?php if($update_colegio==1){
                        foreach($list_colegio_prov as $list){
                            if (in_array($list['id'], array_column($colegio_prov_empresa, 'id_colegio_prov'))) {
                                echo $list['nombre_departamento'] . ' | ' . $list['nombre_provincia'] . ' | ' . $list['nombre_distrito'] . '<br>';
                            }
                        }
                      }
                ?>
                </label>
            </div>
        </div>
        <div class="col-md-12 row" >
            <div class="form-group col-md-4 " > 
                <label class="control-label text-bold">Correo institucional:</label>
            </div>
            <div class="col-md-4">
                <input type="email" class="form-control" pattern="[a-zA-Z0-9._%+-]+" oninput="this.value = this.value.replace(/[^a-zA-Z0-9._%+-]+/, '');"
                placeholder="correo institucional..." id="correo_inst_u" name="correo_inst_u" style="text-align:right; padding-right:37%"
                value="<?php if($update_correo_inst==1){ echo $correo_inst[0]['correo']; } ?>">
                <span class="correo-simbolo" style="position: absolute; right: 20px; top: 7px;">@igb.edu.pe</span>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $id_alumno; ?>">
        <input type="hidden" id="id_sexo" name="id_sexo" value="<?php echo $update_sexo == 1 ? $get_id[0]['id_sexo'] : 0; ?>">
        <input type="hidden" id="id_colegio_prov_empresa" name="id_colegio_prov_empresa" value="<?php echo $update_colegio == 1 ? $colegio_prov_empresa[0]['id'] : 0; ?>">
        <input type="hidden" id="id_correo_inst_empresa" name="id_correo_inst_empresa" value="<?php echo $update_correo_inst == 1 ? $correo_inst[0]['id'] : 0; ?>">


        <button type="button" class="btn btn-primary" onclick="Update_Detalle()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        activateEnterKeyForFunction(Update_Detalle);
        var correoInput = document.getElementById("correo_inst_u");
        correoInput.value = correoInput.value.replace("@ifv.edu.pe", "");
    }); 
    function updateLabel() {
        var selectElement = document.getElementById("id_colegio_prov_u");
        var selectedIndex = selectElement.selectedIndex;
        var labelElement = document.getElementById("infoLabel");
        
        if (selectedIndex !== 0) {
            var selectedOption = selectElement.options[selectedIndex];
            var selectedValue = selectedOption.value;
            
            // Find the corresponding entry in list_colegio_prov
            var selectedData = <?php echo json_encode($list_colegio_prov); ?>;
            var selectedInfo = selectedData.find(item => item.id == selectedValue);
            
            if (selectedInfo) {
                labelElement.textContent = selectedInfo.nombre_departamento + ' | ' + selectedInfo.nombre_provincia + ' | ' + selectedInfo.nombre_distrito;
            }
        } else {
            labelElement.textContent = "";
        }
    }
    function Update_Detalle(){
        Cargando();
        var id_alumno = $("#id_alumno").val();
        
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Detalle_Alumno";

        if (Valida_Update_Detalle()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Matriculados_C/"+id_alumno;
                }
            });
        }
    }

    function Valida_Update_Detalle() {
        if($('#sexo_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sexo.',
                'warning'
            ).then(function() { });
            return false;
        }
/*         if($('#id_colegio_prov_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una institucion.',
                'warning'
            ).then(function() { });
            return false;
        } */
        return true;
    }
</script>