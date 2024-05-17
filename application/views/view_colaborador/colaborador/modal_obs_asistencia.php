<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Observaciones:</b></h5>
</div>

<div class="modal-body" style="max-height:520px; overflow:auto;">
    <div class="col-md-12 row">
        <table class="table table-hover table-striped table-bordered" width="100%">
            <thead>
                <tr style="background-color: #E5E5E5;">
                    <th class="text-center">Fecha</th>    
                    <th class="text-center">Tipo</th>    
                    <th class="text-center">Observación</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($list_historico_ingreso as $list) {  ?>
                    <tr class="even pointer text-center">
                        <td><?php echo $list['fecha']; ?></td> 
                        <td><?php echo $list['tipo_desc']; ?></td>    
                        <td class="text-left"><?php echo $list['observacion']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> 

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
    </button>
</div>