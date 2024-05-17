<?php echo $pago[0]['total']; ?> | <span style="font-size: 32px;">
    <?php if ($pago[0]['total'] != "0") {
        $hym = intdiv($pago[0]['minutos'], 60);
        $min_conv = $pago[0]['minutos'] % 60;
        echo ($pago[0]['horas'] + $hym) . "h" . " " . $min_conv . "min";
    } else {
        echo "0h";
    } ?></span>