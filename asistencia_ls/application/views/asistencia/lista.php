<table class="table">
    <thead>
        <tr>
            <th class="color">Ingreso</th>    
            <th class="color">Apellidos</th>    
            <th class="color">Nombre</th>
            <th class="color">Grado</th>
            <th class="color">Sección</th>
            <th class="color">Registro</th>
            <th class="color"></th>
        </tr>
    </thead> 
    
    <tbody>
        <?php foreach($list_registro_ingreso as $list){ ?>
            <tr>
                <td <?php if($list['nom_tipo_acceso']=="Colaborador"){ ?> style="background-color:#C8C8C8;" <?php } ?>><?php echo $list['hora_ingreso']; ?></td>
                <td <?php if($list['nom_tipo_acceso']=="Colaborador"){ ?> style="background-color:#C8C8C8;text-align: left;" <?php }else{ ?> style="text-align: left;" <?php } ?>><?php echo $list['apellidos']; ?></td>
                <td <?php if($list['nom_tipo_acceso']=="Colaborador"){ ?> style="background-color:#C8C8C8;text-align: left;" <?php }else{ ?> style="text-align: left;" <?php } ?>><?php echo $list['nombre']; ?></td>
                <td <?php if($list['nom_tipo_acceso']=="Colaborador"){ ?> style="background-color:#C8C8C8;" <?php } ?>><?php echo $list['grado']; ?></td>
                <td <?php if($list['nom_tipo_acceso']=="Colaborador"){ ?> style="background-color:#C8C8C8;" <?php } ?>><?php echo $list['seccion']; ?></td>
                <td <?php if($list['nom_tipo_acceso']=="Colaborador"){ ?> style="background-color:#C8C8C8;" <?php } ?>>
                    <?php if($list['estado_ingreso']==1){ ?>
                        <span class="label label-success"><?php echo $list['estado_ing']; ?></span>
                    <?php }else if($list['estado_ingreso']==2){ ?>
                        <span class="label label-warning"><?php echo $list['estado_ing']; ?></span>
                    <?php }else{ ?>
                        <span class="label label-danger"><?php echo $list['estado_ing']; ?></span>
                    <?php } ?>
                </td>
                <td <?php if($list['nom_tipo_acceso']=="Colaborador"){ ?> style="background-color:#C8C8C8;" <?php } ?>>
                    <a title="Eliminar" data-toggle="modal" data-target="#acceso_modal_eli" app_crear_eli="<?= site_url('Asistencia/Modal_Delete_Registro_Ingreso') ?>/<?php echo $list['id_registro_ingreso']; ?>">
                        <img style="width:25px" src="<?= base_url() ?>template/img/x.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>