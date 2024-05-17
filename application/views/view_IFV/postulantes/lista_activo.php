<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form  method="post" id="postulantexls" enctype="multipart/form-data" action="<?= site_url('AppIFV/Excel_Postulante')?>" class="formulario">
    <input type="hidden" name="parametro" id="parametro" value="<?php echo $parametro?> "> 
</form>

<form  method="post" id="frm_snappy" enctype="multipart/form-data"  class="formulario">
    <table id="example" class="table table-hover table-bordered table-striped">
    <thead >
        <tr style="background-color: #E5E5E5;">
            <th><div align="center"><input type="checkbox" id="total" name="total"  value="1"></div></th>
            <th width="2%"><div align="center" style="Cursor:help" title="Código">Cod</div></th>
            <th width="2%"><div align="center">Grupo</div></th>
            <th><div align="center">Carrera</div></th>
            <th width="2%"><div align="center" style="Cursor:help">DNI</div></th>
            <th><div align="center">Apellidos&nbsp;y&nbsp;Nombres</div></th>
            
            <th width="2%"><div align="center" style="Cursor:help" title="Fecha de Inscripción">Inscrip.</div></th>
            <th><div align="center" style="Cursor:help" title="Correo de postulante">Correo</div></th>
            <th width="2%"><div align="center" >Celular</div></th>
            <th width="2%"><div align="center">Estado</div></th>
            <th width="2%"><div align="center" style="Cursor:help" title="Fecha de envío de invitación">F.&nbsp;Envío</div></th>
            <th width="2%"><div align="center" style="Cursor:help" title="Fecha y hora cuando inició el examen">Inicio</div></th>
            <th><div align="center" style="Cursor:help" title="Puntaje de Evaluación">Eval.</div></th>
            <th><div align="center" style="Cursor:help" title="Fecha y hora cuando terminó el examen">Termino</div></th>
            <th><div align="center" style="Cursor:help" title="Tiempo que tomó resolver el examen">Tiempo</div></th>
            <td><div ></div></td>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_postulantes as $list) {  ?>                                           
            <tr class="even pointer">
                <td  ><input required type="checkbox" id="id_postulante[]" name="id_postulante[]" value="<?php echo $list['id_postulante']; ?>"></td>
                <td  ><?php echo $list['codigo']; ?></td>
                <td  ><?php echo $list['grupo']; ?></td>
                <td   nowrap><?php echo substr($list['nom_carrera'],0,25); ?></td>
                <td  ><?php echo $list['nr_documento']; ?></td>
                <td  nowrap><?php echo $list['apellido_pat']." ".$list['apellido_mat'].", ".substr($list['nombres'],0,13); ?></td>
                <!--<td  ><?php echo $list['apellido_mat']; ?></td>
                <td  ><?php echo $list['nombres']; ?></td>-->
                <td  nowrap><?php echo $list['fecha_inscripcion']; ?></td>
                <td ><?php echo substr($list['email'],0,32); ?></td>
                <td ><?php echo $list['celular']; ?></td>
                <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                <td  nowrap ><?php echo $list['fecha_envio']; ?></td>
                <td  nowrap><?php if($list['estado_postulante']==31){ echo $list['tiempo_ini']; }  ?></td>
                <td ><?php  if($list['estado_postulante']==31){ echo $list['puntaje']; }  ?></td>
                <td  nowrap><?php if($list['estado_postulante']==31){ echo $list['fecha_termino']; }  ?></td>
                <td ><?php if($list['estado_postulante']==31){ echo substr($list['minutos_t'],1,8); }  ?></td>
                <td>
                    <img title="Editar Datos Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Postulante') ?>/<?php echo $list["id_postulante"]; ?>"  src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"/>
                    <?php if($sesion['id_usuario']==1){ ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Postulante('<?php echo $list['id_postulante']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/></a>
                    <?php } ?>
                </td>
            </tr>

        <?php } ?>
    </tbody>
    </table>
    <input type="hidden" id="cadena" name="cadena" class="form-control"  value="" />
                        <input type="hidden" id="cantidad" name="cantidad" class="form-control"  value="0" />
    <!--<div class="row col-12 mt-2 mb-3">
        <label class="text-bold">Cantidad de Registros:</label>&nbsp;&nbsp;&nbsp;
        <label class="text-bold"><?php echo count($list_postulantes); ?></label>
    </div>-->
</form>

<script>

    $(document).ready(function(){
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
            }
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        let $dt = $('#example');
        var table=$('#example').DataTable( {
            ordering:false,
            "order": [[ 1, "asc" ]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0,14 ]
        } ]
        } );
        let $total = $('#total');
        let $cadena = $('#cadena');
        let $cantidad = $('#cantidad');
  
        // Cuando hacen click en el checkbox del thead
        $dt.on('change', 'thead input', function (evt) {
            let checked = this.checked;
            let total = 0;
            let data = [];
            let cadena='';
            
            table.data().each(function (info) {
            var txt = info[0];
            
            if (checked) {
                total += 1;
                txt = txt.substr(0, txt.length - 1) + ' checked>';
                cadena += info[1]+",";
            } else {
                txt = txt.replace(' checked', '');
            }
            info[0] = txt;
            data.push(info);
            });
            
            table.clear().rows.add(data).draw();
            $cantidad.val(total);
            $cadena.val(cadena);
        });
  
        // Cuando hacen click en los checkbox del tbody
        $dt.on('change', 'tbody input', function() {
            let q= $('#cadena').val();
            let cantidad= $('#cantidad').val();
            let info = table.row($(this).closest('tr')).data();
            let total = parseFloat($total.val());
            let cadena = $cadena.val();
            let price = parseFloat(info[1]);
            let cadena2 = info[1]+",";
            //total += this.checked ? price : price * -1;
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
            //cadena += this.checked ? cadena2 : info[1]+", ";
            
        });
    });
</script>