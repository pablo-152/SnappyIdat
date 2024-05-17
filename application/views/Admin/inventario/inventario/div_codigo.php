<div class="container-fluid" style="max-height:510px; overflow:auto;">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                <thead>
                    <tr >
                        <th width="10%"><div align="center"></div></th>
                        <th width="20%"><div align="center">Código</div></th>
                        <th width="20%"><div align="center">Sede</div></th>
                        <th width="10%"><div align="center">Estado</div></th>
                        <th width="10%"><div align="center">LCheck</div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 

                          if($cantidad>($get_referencia[0]['num_fin']-$get_referencia[0]['cant_actual']+1)){
                            $ini=$get_referencia[0]['cant_actual'];
                            $fin=$get_referencia[0]['num_fin'];

                            while($ini<=$fin){?>
                                <tr>
                                    <td ><?php echo $ini; ?></td>
                                    <td ><?php echo $get_referencia[0]['letra']."/".$ini ?></td>
                                    <td ><?php echo "Sede"; ?></td>
                                    <td ><?php echo "Estado"; ?></td>
                                    <td ><?php echo "LCheck"; ?></td>
                                </tr>
                                
                            <?php $ini=$ini+1; }
                          }else{

                            $ini=$get_referencia[0]['cant_actual'];
                            $fin=$cantidad;
                            $contador=1;

                            while($contador<=$fin){?>
                                <tr>
                                    <td ><?php echo $ini; ?></td>
                                    <td ><?php echo $get_referencia[0]['letra']."/".$ini ?></td>
                                    <td ><?php echo "Sede"; ?></td>
                                    <td ><?php echo "Estado"; ?></td>
                                    <td ><?php echo "LCheck"; ?></td>
                                </tr>
                                
                            <?php $contador =$contador+1;$ini =$ini+1; }
                          }
                         ?>
                </tbody>
            </table>
        </div>
    </div>
</div>