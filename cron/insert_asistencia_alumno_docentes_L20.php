<meta charset="UTF-8">
<?php
    include 'conexion.php';
    $serverName = "198.38.93.144";
    $connectionInfo = array( "Database"=>"vpssoftd_snappy", "UID"=>"vpssoftd_snappy", "PWD"=>"SnapPY2023@#!","CharacterSet" => "UTF-8");
    $conexion_vps = sqlsrv_connect( $serverName, $connectionInfo); 

    if($conexion_vps) {
        echo "Conexión establecida (vps).<br />";
    }else{
        echo "Conexión no se pudo establecer (vps).<br />";
        die( print_r(sqlsrv_errors(),true));
    }
    
    $hoy=date('Y-m-d');
    $query_0 = mysqli_query($conexion,"SELECT count(*) FROM calendar_festivo a where a.inicio='$hoy' and laborable='NO' and id_empresa=6 and estado=2");
    $row_0=mysqli_fetch_array($query_0);
    $totalRows_0 = mysqli_num_rows($query_0);

    if($row_0[0] > 0){
        $query_1 = mysqli_query($conexion, "SELECT Id,Especialidad,Grupo,Modulo,Seccion,Codigo,Apellido_Paterno,Apellido_Materno,Nombre
        FROM matriculados_l20");
        

        while ($row_1 = mysqli_fetch_assoc($query_1)) { 
            $id_alumno = $row_1['Id'];
            $ingreso = date('Y-m-d H:i:s');
            $salida = 0;
            $hora_salida = null;
            $especialidad=$row_1['Especialidad'];
            $grupo=$row_1['Grupo'];
            $modulo=$row_1['Modulo'];
            $seccion=$row_1['Seccion'];
            $codigo=$row_1['Codigo'];
            $apater=$row_1['Apellido_Paterno'];
            $amater=$row_1['Apellido_Materno'];
            $nombres=$row_1['Nombre'];
            $estado_ingreso=1;
            $estado_reporte=3;
            $fec_reg = date('Y-m-d H:i:s');
            
            $query_2 = sqlsrv_query($conexion_vps,"SELECT COUNT(*) as cantidad FROM registro_ingreso WHERE id_alumno = '$id_alumno' AND CAST(ingreso AS DATE) = '$hoy'");
    
            $row_2 = sqlsrv_fetch_array($query_2,SQLSRV_FETCH_ASSOC);
            if ($row_2['cantidad'] == 0) {
                $query_ap = sqlsrv_query($conexion_vps, "INSERT INTO registro_ingreso (id_alumno, ingreso, especialidad,grupo,modulo,seccion,codigo,apater,amater,
                nombres,estado_ingreso,estado_reporte,estado_asistencia,laborable,estado,fec_reg,user_reg) 
                VALUES ($id_alumno, '$ingreso', '$especialidad','$grupo','$modulo','$seccion','$codigo','$apater','$amater','$nombres','$estado_ingreso',
                '$estado_reporte','No Ingresa','No hay Clases',2,'$fec_reg',0)");

            }
        }
    }else{
        $query_1 = mysqli_query($conexion, "SELECT Id,Especialidad,Grupo,Modulo,Seccion,Codigo,Apellido_Paterno,Apellido_Materno,Nombre
        FROM matriculados_l20");
    
        while ($row_1 = mysqli_fetch_assoc($query_1)) {
            $id_alumno = $row_1['Id'];
            $ingreso = date('Y-m-d H:i:s');
            $salida = 0;
            $hora_salida = null;
            $especialidad=$row_1['Especialidad'];
            $grupo=$row_1['Grupo'];
            $modulo=$row_1['Modulo'];
            $seccion=$row_1['Seccion'];
            $codigo=$row_1['Codigo'];
            $apater=$row_1['Apellido_Paterno'];
            $amater=$row_1['Apellido_Materno'];
            $nombres=$row_1['Nombre'];
            $estado_ingreso=2;
            $estado_reporte=3;
            $fec_reg = date('Y-m-d H:i:s');
            $query_2 = sqlsrv_query($conexion_vps, "SELECT COUNT(*) as cantidad FROM registro_ingreso WHERE id_alumno = '$id_alumno' AND CAST(ingreso AS DATE) = '$hoy'");
            $row_2 = sqlsrv_fetch_array($query_2, SQLSRV_FETCH_ASSOC);
            
            if ($row_2['cantidad'] == 0) {
                $query_ap = sqlsrv_query($conexion_vps, "INSERT INTO registro_ingreso (id_alumno, ingreso, especialidad,grupo,modulo,seccion,codigo,apater,amater,
                nombres,estado_ingreso,estado_reporte,estado_asistencia,laborable,estado,fec_reg,user_reg) 
                VALUES ($id_alumno, '$ingreso', '$especialidad','$grupo','$modulo','$seccion','$codigo','$apater','$amater','$nombres','$estado_ingreso',
                '$estado_reporte','No Ingresa','Falta',2,'$fec_reg',0)");
            }
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    }
?>