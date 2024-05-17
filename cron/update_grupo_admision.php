<?php
    include 'conexion_arpay.php';

    sqlsrv_query($conexion_arpay,"UPDATE grupo_admision SET estado=39 
    WHERE estado=37 AND inicio_grupo=GETDATE()");

    sqlsrv_query($conexion_arpay,"UPDATE grupo_admision SET estado=41 
    WHERE estado=39 AND fin_grupo=GETDATE()");
?>