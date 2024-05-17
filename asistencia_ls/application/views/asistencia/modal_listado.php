                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title"><b>Detalles del Alumno</b></h5>
                </div>
                <div class="modal-body" style="max-height:520px; min-height: 400px; overflow:auto;">
                    <div class=" col-md-12 row">
                        <div class="form-group col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:15%;" class="color">Fecha</th>    
                                        <th style="width:25%;" class="color">Tipo</th>    
                                        <th style="width:60%;" class="color">Observaciones</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php foreach($list_historico_ingreso as $list) {  ?>
                                        <tr>
                                            <td><?php echo $list['Fecha']; ?></td> 
                                            <td><?php echo $list['tipo_desc']; ?></td>    
                                            <td style="text-align: left;"><?php echo $list['observacion']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
