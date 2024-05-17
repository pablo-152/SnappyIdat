<table class="table table-bordered table-striped" id="papeletas">
                                        <thead>
                                            <tr>
                                                 <th colspan="9" style="border: none;"></th>
                                                 <th align="center" colspan="2" bgcolor="#D71E26" style="border: none; color:#fff; text-align:center;">Solicitado</th>
                                                <th align="center" colspan="2" bgcolor="#54813B" style="border: none; color:#fff; text-align:center;">Terminado</th>
                                            </tr>

                                            <tr>
                                            <th><div align="center"><input type="checkbox" id="GL0" name="GL0" value="1"></div></th>
                                            <th><div align="center">Código</div></th>
                                                        <th><div align="center">Status</div></th>
                                                        <th><div align="center">Empresa(s)</div></th>
                                                        <th><div align="center">Tipo</div></th>
                                                        <th><div align="center">SubTipo</div></th>
                                                        <th><div align="center">Descripción</div></th>
                                                        <th><div align="center">Snappy's</div></th>
                                                        <th><div align="center">Agenda</div></th>
                                                        <th><div align="center">Usuario</div></th>
                                                        <th><div align="center">Fecha</div></th>
                                                        <th><div align="center">Usuario</div></th>
                                                        <th><div align="center">Fecha</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_proyecto as $list) {  ?>                                           
                                                <tr <?php if($list['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?> >
                                                        <td align="center" ><input type="checkbox" id="proyecto[]" name="proyecto[]" value="<?php echo $list['id_proyecto']; ?>"></td>
                                                        <td align="center" ><?php echo utf8_encode($list['cod_proyecto']); ?></td>
                                                        <td style="background-color:<?php echo $list['color']; ?>"><?php echo $list['nom_statusp']; ?></td>


                                                        
                                                        <td >
                                                        <?php
                                                        if($list['GL0']==1) {echo "GL0";}
                                                        if($list['GL0']==1 && $list['GL1']==1) {echo ", GL1";} else{ if($list['GL1']==1) {echo "GL1";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1) && $list['GL2']==1) {echo ", GL2";} else{ if($list['GL2']==1) {echo "GL2";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1) && $list['BL1']==1) {echo ", BL1";} else{ if($list['BL1']==1) {echo "BL1";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1) && $list['LL1']==1) {echo ", LL1";} else{ if($list['LL1']==1) {echo "LL1";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1) && $list['LL2']==1) {echo ", LL2";} else{ if($list['LL2']==1) {echo "LL2";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1) && $list['LS1']==1) {echo ", LS1";} else{ if($list['LS1']==1) {echo "LS1";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1 || $list['LS1']==1) && $list['LS2']==1) {echo ", LS2";} else{ if($list['LS2']==1) {echo "LS2";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1 || $list['LS1']==1 || $list['LS2']==1) && $list['EP1']==1) {echo ", EP1";} else{ if($list['EP1']==1) {echo "EP1";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1 || $list['LS1']==1 || $list['LS2']==1 || $list['EP1']==1) && $list['EP2']==1) {echo ", EP2";} else{ if($list['EP2']==1) {echo "EP2";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1 || $list['LS1']==1 || $list['LS2']==1 || $list['EP1']==1 || $list['EP2']==1) && $list['FV1']==1) {echo ", FV1";} else{ if($list['FV1']==1) {echo "FV1";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1 || $list['LS1']==1 || $list['LS2']==1 || $list['EP1']==1 || $list['EP2']==1 || $list['FV1']==1) && $list['FV2']==1) {echo ", FV2";} else{ if($list['FV2']==1) {echo "FV2";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1 || $list['LS1']==1 || $list['LS2']==1 || $list['EP1']==1 || $list['EP2']==1 || $list['FV1']==1 || $list['FV2']==1) && $list['LA0']==1) {echo ", LA0";} else{ if($list['LA0']==1) {echo "LA0";}}
                                                        if(($list['GL0']==1 || $list['GL1']==1 || $list['GL2']==1 || $list['BL1']==1 || $list['LL1']==1 || $list['LL2']==1 || $list['LS1']==1 || $list['LS2']==1 || $list['EP1']==1 || $list['EP2']==1 || $list['FV1']==1 || $list['FV2']==1 || $list['LA0']==1) && $list['VJ1']==1) {echo ", VJ1";} else{ if($list['VJ1']==1) {echo "VJ1";}}
                                                        ?>
                                                    
                                                        </td>
                                                        <td ><?php echo $list['nom_tipo']; ?></td>
                                                        <td ><?php echo $list['nom_subtipo']; ?></td>
                                                        <td ><?php echo $list['descripcion']; ?></td>
                                                        <td align="center" ><?php echo $list['s_artes']+$list['s_redes']; ?></td>
                                                        <td align="center" ><?php if ($list['fec_agenda']!='0000-00-00') echo date('d/m/Y', strtotime($list['fec_agenda'])); ?></td>
                                                        <td ><?php echo $list['ucodigo_solicitado']; ?></td>

                                                        <td align="center" ><?php if ($list['fec_solicitante']!='0000-00-00') echo date('d/m/Y', strtotime($list['fec_solicitante'])); ?></td>
                                                        <td ><?php echo $list['ucodigo_asignado']; ?></td>
                                                        <td align="center" ><?php if ($list['fec_termino']!='0000-00-00 00:00:00') echo date('d/m/Y', strtotime($list['fec_termino'])); ?></td>
                                                    </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>