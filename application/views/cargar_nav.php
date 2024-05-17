<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="icon-bubble-notification"></i>
    <span class="visible-xs-inline-block position-right">Notificaciones</span>
    <span class="badge bg-warning-400"><?php echo count($list_aviso); ?></span>
</a>

<div class="dropdown-menu dropdown-content width-350"> 
    <div class="dropdown-content-heading">
        Notificaciones
    </div>

    <ul class="media-list dropdown-content-body">
        <?php foreach($list_aviso as $list){ ?>
            <li class="media">
                <div class="media-body">
                    <a href="<?php if($list['link']!=""){ echo $list['link']; }else{ echo "#"; } ?>">
                        <span style="color:black;font-weight:bold;"><?php echo $list['nom_accion']; ?></span>
                        <span style="color:black;"><?php echo " - ".$list['mensaje']; ?></span>
                    </a>
                </div>
            </li>
        <?php } ?>
    </ul>

    <?php if(count($list_aviso)>5){ ?>
        <div class="dropdown-content-footer">
            <a href="<?= site_url($controlador.'/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
        </div>
    <?php } ?>
</div>