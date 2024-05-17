<div class="panel-body">
    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label title="Creado Por:" class="control-label text-bold">Cre.&nbsp;por:</label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['creadopor']; ?>">
        </div>

        <div class="form-group col-md-2 text-right">
            <label title="Fecha creación:" class="control-label text-bold">Fec.&nbsp;Crea:</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Fec_reg']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Mayor de edad:" class="control-label text-bold">May.&nbsp;Edad:</label>
        </div>   
        <div class="form-group col-md-1">
            <?php
            $edad = $get_id[0]['edad']; 
            if ($edad >= 18) {
                $mayor_de_edad = 'Si';
            } elseif ($edad < 18) {
                $mayor_de_edad = 'No';
            } else {
                $mayor_de_edad = '';
            }
        ?>
            <input type="text" class="form-control" disabled value="<?php echo $mayor_de_edad; ?>">
        </div>      
                                    
        <div class="form-group col-md-1">
        </div>

        <div class="form-group col-md-1 text-right">
            <label title="Codigo:" class="control-label text-bold">Codigo:</label>
        </div>   
        <div class="form-group col-md-1">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Codigo']; ?>">
        </div>                              
    </div>
    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right ">
            <label title="Especialidad:" class="control-label text-bold">Esp.:</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Nombre_Especialidad']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Modalidad" class="control-label text-bold">Modali.:</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Modalidad']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Turno" class="control-label text-bold">Turno:</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Turno']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="¿Cómo se entero de nosotros?" class="control-label text-bold">CEN:</label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['CEN']; ?>">
        </div>
    </div>
    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label title="Certificado de Estudios" class="control-label text-bold">Cert.&nbsp;Est.:</label>
        </div>
        <div class="form-group col-md-1">
        <!--    <input type="text" class="form-control" disabled value="<?php /* echo $get_id[0]['Doc_Certificado']; */?>"> -->
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Doc_Certificado']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Declaración Jurada" class="control-label text-bold">Dec.&nbsp;Jur.:</label>
        </div>
            <?php 
                $edad = $get_id[0]['edad']; 
                if ($edad == '') {
                    $resultado = '';
                }else {
                    if ($edad >= 18) {
                        $resultado = $get_id[0]['Doc_Certificado'];
                    } elseif ($edad < 18) {
                        $resultado = 'N/A';
                    } 
                }
                
            ?>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" disabled value="<?php echo $resultado; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Documento Menor de edad:" class="control-label text-bold">Doc&nbsp;Men.:</label>
        </div>
        <div class="form-group col-md-1">
        <!--    <input type="text" class="form-control" disabled value="<?php /*echo $get_id[0]['Doc_DNI_Alumno'];*/ ?>"> -->
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Doc_DNI_Alumno']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Evaluación:" class="control-label text-bold">Eval.:</label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Evaluacion']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Nota" class="control-label text-bold">Nota:</label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Nota']; ?>">
        </div>
        <div class="form-group col-md-1 text-right">
            <label title="Estado oficial:" class="control-label text-bold">Est.&nbsp;Ofi.:</label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Est_Of']; ?>">
        </div>
    </div>
</div>