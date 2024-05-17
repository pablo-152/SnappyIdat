<?php
    include 'conexion.php';
    include 'conexion_arpay.php';
    include 'conexion_vps.php';

    $query_c = mysqli_query($conexion,"SELECT Id,Fecha_Cumpleanos 
                FROM todos_l20 
                WHERE Tipo=1 ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC");

    while( $fila = mysqli_fetch_assoc( $query_c ) ) { 
        $fec_de = new DateTime($fila['Fecha_Cumpleanos']);
        $fec_hasta = new DateTime(date('Y-m-d'));
        $diff = $fec_de->diff($fec_hasta); 

        $parte = "";
        if($diff->y>17){
            $parte = "AND do.nom_documento NOT LIKE '%menor%'";
        }

        $query_snappy = mysqli_query($conexion, "SELECT do.nom_documento FROM documento_alumno_empresa do
                        WHERE do.id_empresa=6 AND do.estado=2 AND do.obligatorio=1 $parte");

        $i = 0;

        while( $fila_snappy = mysqli_fetch_assoc( $query_snappy ) ) { 
            $query_arpay = sqlsrv_query($conexion_arpay,"SELECT sd.Id FROM Student.StudentDocument sd
                            WHERE sd.ClientId='".$fila['Id']."' AND (sd.DocumentFilePath!='' OR sd.DocumentFilePath IS NOT NULL) AND 
                            sd.Name='".$fila_snappy['nom_documento']."'");

            $i = $i+sqlsrv_num_rows($query_arpay);
        }

        /*$query_arpay = sqlsrv_query($conexion_arpay,"SELECT sd.Name AS Nom_Documento 
                        FROM Student.StudentDocument sd
                        WHERE sd.ClientId='".$fila['Id']."' AND (sd.DocumentFilePath!='' OR sd.DocumentFilePath IS NOT NULL)");*/

        //$i = mysqli_num_rows($query_snappy);

        /*while( $fila_snappy = mysqli_fetch_assoc( $query_snappy ) ) { 
            $busqueda=in_array($fila_snappy['nom_documento'],array_column($query_arpay,'Nom_Documento'));

            if($busqueda!=false){
                $i=$i-1;
            }
        }*/

        /*while( $fila_snappy = mysqli_fetch_assoc( $query_snappy ) ) { 
            while( $fila_arpay = sqlsrv_fetch_array( $query_arpay, SQLSRV_FETCH_ASSOC) ) { 
                if($fila_snappy['nom_documento']==$fila_arpay['Nom_Documento']){
                    $i--;
                }
            }
        }*/

        $query_update = mysqli_query($conexion, "UPDATE todos_l20 SET Documento_Pendiente=$i
                        WHERE Tipo=1 AND Id='".$fila['Id']."'");

        $insert2 = sqlsrv_query($conexion_vps, "UPDATE todos_l20 SET Documento_Pendiente=$i
        WHERE Tipo=1 AND Id='".$fila['Id']."'"); 
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>