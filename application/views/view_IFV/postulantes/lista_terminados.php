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
            <th width="2%"><div align="center" style="Cursor:help" title="Puntaje de Evaluación">Eval.</div></th>
            <th width="2%"><div align="center" style="Cursor:help" title="Puntaje de Evaluación Equivalente">Eval&nbsp;Eq.</div></th>
            <th width="2%"><div align="center" style="Cursor:help" title="Fecha y hora cuando terminó el examen">Termino</div></th>
            <th width="2%"><div align="center" style="Cursor:help" title="Tiempo que tomó resolver el examen">Tiempo</div></th>
            <td><div ></div></td>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_postulantes as $list) {  ?>                                           
            <tr class="even pointer">
                <!--<td align="center" ><input required type="checkbox" id="id_postulante[]" name="id_postulante[]" value="<?php echo $list['id_postulante']; ?>"></td>-->
                <td align="center"><?php echo $list['codigo']; ?></td>
                <td align="center" nowrap><?php echo $list['grupo']; ?></td>
                <td  nowrap><?php echo substr($list['nom_carrera'],0,25); ?></td>
                <td ><?php echo $list['nr_documento']; ?></td>
                <td ><?php echo $list['apellido_pat']." ".$list['apellido_mat'].", ".substr($list['nombres'],0,13); ?></td>
                <!--<td ><?php echo $list['apellido_mat']; ?></td>
                <td ><?php echo $list['nombres']; ?></td>-->
                <td  nowrap><?php echo $list['fecha_inscripcion']; ?></td>
                <td ><?php echo substr($list['email'],0,32); ?></td>
                <td ><?php echo $list['celular']; ?></td>
                <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                <td  nowrap ><?php echo $list['fecha_envio']; ?></td>
                
                <td nowrap><?php
                $busqueda=in_array($list['id_postulante'],array_column($list_resultados,'id_postulante'));
                if($busqueda!=false){
                    $posicion = array_search($list['id_postulante'], array_column($list_resultados, 'id_postulante'));
                    $list_resultados[$posicion]['tiempo_ini'];
                    //$list['tiempo_ini']
                    $mifecha = new DateTime($list_resultados[$posicion]['tiempo_ini']); 
                    //$mifecha->modify('+3 hours'); 
                    echo $mifecha->format('d/m/Y H:i');
                } ?>
                </td>
                <td ><?php
                if($busqueda!=false){
                    echo $list_resultados[$posicion]['puntaje'];//$list['puntaje'];
                }
                 ?></td>
                <td ><?php 
                if($busqueda!=false){
                    echo $list_resultados[$posicion]['puntaje_arpay'];//echo $list['puntaje_arpay'];
                }
                 ?></td>
                <!--<td  ><?php if(substr($list['fecha_termino'],11,2)>=12){ $algo="PM"; }else{ $algo="AM"; } echo substr($list['fecha_termino'],0,16)." ".$algo; ?></td>-->
                <td nowrap><?php 
                if($busqueda!=false){
                    $mifecha = new DateTime($list_resultados[$posicion]['fec_termino']);
                    //$mifecha->modify('+3 hours'); 
                    echo $mifecha->format('d/m/Y H:i');
                }
                 ?></td>
                <td nowrap><?php 
                if($busqueda!=false){
                    $mifecha = new DateTime($list_resultados[$posicion]['minutos_t']);
                    if($list_resultados[$posicion]['minutos_t']!=""){
                        echo substr($list_resultados[$posicion]['minutos_t'],1,5)." hr m"; }
                }  ?></td>
                <td >
                    <img title="Editar Datos Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Postulante') ?>/<?php echo $list["id_postulante"]; ?>"  src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"/>
                    <?php if($sesion['id_usuario']==1){ ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Postulante('<?php echo $list['id_postulante']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/></a>
                    <?php } ?>
                </td>
            </tr>

        <?php } ?>
    </tbody>
    </table>
    <!--<div class="row col-12 mt-2 mb-3">
        <label class="text-bold">Cantidad de Registros:</label>&nbsp;&nbsp;&nbsp;
        <label class="text-bold"><?php echo count($list_postulantes); ?></label>
    </div>-->
</form>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table=$('#example').DataTable( {
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 13 ]
        } ]
        } );
    } );
</script>