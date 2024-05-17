<link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/css/tablaprueba.css">

<table class="fold-table table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">De</th>
            <th class="text-center">A</th>
            <th class="text-center">Dias Laborables</th>
            <th class="text-center">Estado</th> 
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($lista_horario as $list){ ?> 
            <tr class="view text-center">
                <td><?php echo $list['de']; ?></td>
                <td><?php echo $list['a']; ?></td>
                <td><?php echo $list['dias_laborables']; ?></td>
                <td><?php echo $list['estado']; ?></td>
                <td>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_form_vertical" 
                        modal_form_vertical="<?= site_url('Colaborador/Modal_Update_Horario_Colaborador') ?>/<?php echo $list['id_horario']; ?>" title="Editar">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a href="javascript:void(0)" title="Eliminar" onclick="Delete_Horario_Colaborador('<?php echo $list['id_horario']; ?>')"> 
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
            
            <tr class="fold"> 
                <td colspan="5">
                    <div class="fold-content">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Día</th>
                                    <th class="text-center">Ingreso Mañana</th>
                                    <th class="text-center">Salida Mañana</th>
                                    <th class="text-center">Ingreso Almuerzo</th>
                                    <th class="text-center">Salida Almuerzo</th>
                                    <th class="text-center">Ingreso Tarde</th>
                                    <th class="text-center">Salida Tarde</th>
                                    <th class="text-center">Ingreso Cena</th>
                                    <th class="text-center">Salida Cena</th>
                                    <th class="text-center">Ingreso Noche</th>
                                    <th class="text-center">Salida Noche</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($lista_horario_detalle as $horario){ 
                                if($list['id_horario']==$horario['id_horario']){ ?>
                                    <tr class="text-center">
                                        <td><?php echo $horario['dia']; ?></td>
                                        <td><?php echo $horario['ingreso_m']; ?></td>
                                        <td><?php echo $horario['salida_m']; ?></td>
                                        <td><?php echo $horario['ingreso_alm']; ?></td>
                                        <td><?php echo $horario['salida_alm']; ?></td>
                                        <td><?php echo $horario['ingreso_t']; ?></td>
                                        <td><?php echo $horario['salida_t']; ?></td>
                                        <td><?php echo $horario['ingreso_c']; ?></td>
                                        <td><?php echo $horario['salida_c']; ?></td>
                                        <td><?php echo $horario['ingreso_n']; ?></td>
                                        <td><?php echo $horario['salida_n']; ?></td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>          
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(function(){
        $(".fold-table tr.view").on("click", function(){
            $(this).toggleClass("open").next(".fold").toggleClass("open");
        });
    });
</script>