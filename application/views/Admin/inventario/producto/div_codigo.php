<div class="container-fluid" style="max-height:510px; overflow:auto;">
   
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover" id="example2" width="50%">
                    <thead>
                        <tr >
                            <th width="2%"><div align="center"></div></th>
                            <th width="10%"><div align="center">Código</div></th>
                            <th width="10%"><div align="center">Empresa</div></th>
                            <th width="10%"><div align="center">Sede</div></th>
                            <th width="10%"><div align="center">Estado</div></th>
                            <th width="10%"><div align="center">LCheck</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ini=1; foreach($list_productos as $prod){?>
                                    <tr>
                                        <td align="center"><?php echo $ini; ?></td>
                                        <td align="center"><?php echo $prod['codigo_barra']; ?></td>
                                        <td align="center"><?php echo $prod['cod_empresa']; ?></td>
                                        <td align="center"><?php echo $prod['cod_sede']; ?></td>
                                        <td align="center"><?php if($prod['estado']==39){?>
                                            <span class="badge" style="background:#00b050;color: white;"><?php echo $prod['estado_inventario'] ?></span> 
                                                <?php }elseif($prod['estado']==40){?> 
                                                <span class="badge" style="background:#ff0000;color: white;"><?php echo $prod['estado_inventario'] ?></span>
                                                <?php }elseif($prod['estado']==41){?>
                                                <span class="badge" style="background:#bf9000;color: white;"><?php echo $prod['estado_inventario'] ?></span> <?php 
                                                }elseif($prod['estado']==42){?>
                                                <span class="badge" style="background:#7030a0;color: white;"><?php echo $prod['estado_inventario'] ?></span> <?php 
                                                }?>
                                        </td>
                                        <td align="center"><?php if($prod['lcheck']!=0){echo $prod['lcheck']; } ?></td>
                                    </tr>
                                    <?php 
                                 $ini=$ini+1;} ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        /*var a = parseFloat($('#error').val());
        if(a!="0"){
            Swal(
                'Ups!',
                'El código activo tiene como límite '+a+' productos.',
                'warning'
            ).then(function() { });

            $('#cantidad').val(a);
            var p = parseFloat($('#precio_u').val());
            var t = p*a;
            $('#total').val(parseFloat(t));
        }*/
        
        var activos = <?php echo $activo; ?>;
        var sinrevisar = <?php echo $sinrevisar; ?>;
        var revision = <?php echo $revision; ?>;
        var disponibles = <?php echo $disponible; ?>;
        var total = <?php echo $total; ?>;

        if((activos==total || disponibles==total) && sinrevisar>0){
            $('#estado').val('Sin Revisar');
            $('#id_estado').val(40);
        }
        else if((activos==total || disponibles==total) && revision>0){
            $('#estado').val('Revisión');
            $('#id_estado').val(41);
        }else if(activos==total || disponibles==total){
            $('#estado').val('Activo');
            $('#id_estado').val(39);
        }else if(sinrevisar>0){
            $('#estado').val('Sin Revisar');
            $('#id_estado').val(40);
        }else if(revision>0){
            $('#estado').val('Revisión');
            $('#id_estado').val(41);
        }
        /*if($('#id_tipo_inventario').val()!=0){
            var cant =$('#id_tipo_inventario').val();
            Swal(
                'Ups!',
                'El código activo tiene como límite '+ cant +' productos.',
                'warning'
            ).then(function() { });
            return false;
        }*/

        //$('#alum_edad').val(edad);
    });
</script>