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
            <tr>
                <td><?php echo $list['hora_ingreso']; ?></td>   
                <td style="text-align: left;"><?php echo $list['apellidos']; ?></td>  
                <td style="text-align: left;"><?php echo $list['nombre']; ?></td>                                                  
                <td>
                    <a title="Salida" onclick="Update_Registro_Salida('<?php echo $list['id_registro_ingreso']; ?>')"> 
                        <img src="<?= base_url() ?>template/img/salida.png">
                    </a>

                    <a title="No Registrada" onclick="Update_Registro_Salida_No_Registrada('<?php echo $list['id_registro_ingreso']; ?>')"> 
                        <img src="<?= base_url() ?>template/img/retirar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>