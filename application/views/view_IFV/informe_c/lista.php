<style>
    .ver_title{
        cursor: help;
    }

    #tabla_mrd{
        border-spacing: 1px;
        border-collapse: separate;
    }

    .th_titulo {
        background-color: white;
    }

    .th_lista {
        border: 1px solid #000;
        height: 35px;
        text-align: center;
        vertical-align: middle;
    }

    .td_lista {
        /*border: 1px solid #000;*/
        height: 35px;
        text-align: center;
        vertical-align: middle;
        color: white;
    }

    .invisible{
        color: transparent;
    }
</style>

<?php
    function semanas($a) {   // $a -> año
        return date("W", mktime(0,0,0,12,28,$a));
    }

    $semanas = semanas($anio);
?>

<table id="tabla_mrd" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="ver_title th_titulo"></th>
            <?php $i = 1;
            while ($i <= $semanas) { ?>
                <th class="th_lista"><?php echo "S".$i; ?></th>
            <?php $i++;
            } ?>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_informe as $list){ ?>
            <tr class="even pointer">
                <td class="ver_title td_lista" title="<?php echo $list['abreviatura']; ?>" style="background-color:<?php echo $list['color']; ?>"><span class="invisible">Ho</span><?php echo $list['abreviatura']; ?><span class="invisible">Ho</span></td>
                <?php $i = 1;
                while ($i <= $semanas) { ?>
                    <td class="td_lista" <?php if($list['inicio_clase']<=$i && $list['fin_clase']>=$i){ $fecha = new DateTime(date('Y-m-d'));
                        $semana = $fecha->format('W');
                        if($semana==$i){ ?> style="background-color:#617c8b" <?php }else{ ?> title="Hola" style="background-color:#617c8b" <?php } } ?>><?php //echo $i; ?></td>
                <?php $i++;
                } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>