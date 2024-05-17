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