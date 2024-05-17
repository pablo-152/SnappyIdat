<?php
    include 'conexion.php';  

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $list_sms_automatizado = mysqli_query($conexion, "SELECT id_sms,id_empresa
                            FROM sms_automatizado
                            WHERE tipo=1 AND estado=2");

    while ($fila = mysqli_fetch_assoc($list_sms_automatizado)){
        $list_cumpleanio_empresa = mysqli_query($conexion, "CALL usp_listado_cumpleanio_empresa (".$fila['id_empresa'].")");
        mysqli_next_result($conexion);

        while($fila_c = mysqli_fetch_assoc($list_cumpleanio_empresa)){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.altiria.net:8443/api/http',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'cmd=sendsms&login=vanessa.hilario%40gllg.edu.pe&passwd=gllg2021&dest=51'.$fila['Celular'].'&msg=¡Hola!%0ATu%20fotocheck%20esta%20listo%20y%20en%20camino%20a%20IFV.%0AContacta%20a%20nuestro%20personal%20para%20que%20lo%20puedas%20recoger.%0AInstituto%20Federico%20Villarreal&concat=true',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                ),
            ));
            
            $response = curl_exec($curl);
    
            curl_close($curl);
    
            mysqli_query($conexion, "INSERT INTO detalle_sms_automatizado (id_sms,id_empresa,tipo,id,celular,
            estado,fec_reg)
            VALUES (".$fila['id_sms'].",".$fila['id_empresa'].",'".$fila_c['tipo']."',".$fila_c['id'].",
            '".$fila_c['celular']."',2,NOW())");
        }
    }
?>