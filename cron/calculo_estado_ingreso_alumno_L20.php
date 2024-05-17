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

    mysqli_set_charset($conexion, "utf8mb4");
    date_default_timezone_set("America/Lima");  
    
    $hoy=date('Y-m-d');
    $query_1 = mysqli_query($conexion, "SELECT a.id_alumno,a.dni,a.codigo,a.id_grupo,b.grupo,c.nom_especialidad,d.modulo,b.id_turno
    FROM alumno_grupo a
    left JOIN grupo_calendarizacion b on a.id_grupo=b.id_grupo
    left JOIN especialidad c on b.id_especialidad=c.id_especialidad
    left JOIN modulo d on b.id_modulo=d.id_modulo
    WHERE a.matricula='Asistiendo' AND a.alumno='Matriculado'");
    
    while ($row_1 = mysqli_fetch_assoc($query_1)) { 
        $id_alumno = $row_1['id_alumno'];
        //$especialidad = $row_1['nom_especialidad'];
        $id_grupo = $row_1['id_grupo'];
        $modulo = $row_1['modulo'];
        $id_turno = $row_1['id_turno'];
        $query_2 = sqlsrv_query($conexion_vps,"SELECT id_registro_asistencia,ingreso,estado_asistencia,estado_ingreso,laborable,id_alumno,
        especialidad,grupo,modulo,id_turno,desde,hasta,tolerancia,fecha,id_grupo
        FROM registro_asistencia 
        WHERE id_alumno = '$id_alumno' AND fecha = '$hoy' and id_grupo='$id_grupo'");

        if(sqlsrv_has_rows($query_2)){
            
            $row_2 = sqlsrv_fetch_array($query_2,SQLSRV_FETCH_ASSOC);
            $id_registro_asistencia = $row_2['id_registro_asistencia'];
            if ($row_2['ingreso'] === null) {
                
                $query_ap = sqlsrv_query($conexion_vps, "UPDATE registro_asistencia SET estado_asistencia='No Ingresa',laborable='Falta',estado_ingreso=2,
                fec_act = GETDATE() WHERE id_registro_asistencia = $id_registro_asistencia;");
            }else{
                
                $marcacion = $row_2['ingreso'];
                $desde = $row_2['desde'];
                $hasta = $row_2['hasta'];
                $minutosTolerancia = $row_2['tolerancia'];
                
                // Calcula la hora límite superior y la hora límite inferior
                $limiteInferior = clone $desde;
                $desde_format = clone $desde;
                $limiteInferior->sub(new DateInterval('PT1M'));
                $limiteInferiorStr = $limiteInferior->format('H:i:s');

                $limiteSuperior = clone $desde;
                $limiteSuperior->add(new DateInterval("PT".$minutosTolerancia."M"));
                $limiteSuperiorStr = $limiteSuperior->format('H:i:s');

                $marcacionStr = $marcacion->format('H:i:s'); // Obtenemos solo la hora

                $limiteInferiorFormatted = $limiteInferiorStr;
                $limiteSuperiorFormatted = $limiteSuperiorStr;
                $marcacionFormatted = $marcacionStr;

                $desde_format=$desde_format->format('H:i:s');
                $query_ap = sqlsrv_query($conexion_vps, "UPDATE registro_asistencia SET 
                        estado_asistencia = CASE 
                                            WHEN flag_sabado=1 THEN 'No Ingresa'
                                            WHEN flag_domingo=1 THEN 'No Ingresa'
                                            WHEN flag_festivo=1 THEN 'No Ingresa'
                                            WHEN CAST('$marcacionFormatted' AS TIME) < CAST('$limiteInferiorFormatted' AS TIME) THEN 'Ingresa'
                                            WHEN CAST('$marcacionFormatted' AS TIME) > CAST('$desde_format' AS TIME) AND CAST('$marcacionFormatted' AS TIME) <= CAST('$limiteSuperiorFormatted' AS TIME) THEN 'Tolerancia'
                                            ELSE 'Retraso'
                                            END,
                        laborable = CASE 
                                    WHEN flag_sabado=1 THEN 'No hay Clases'
                                    WHEN flag_domingo=1 THEN 'No hay Clases'
                                    WHEN flag_festivo=1 THEN 'Festivo'
                                    WHEN CAST('$marcacionFormatted' AS TIME) < CAST('$limiteInferiorFormatted' AS TIME) THEN 'Puntual'
                                    WHEN CAST('$marcacionFormatted' AS TIME) > CAST('$desde_format' AS TIME) AND CAST('$marcacionFormatted' AS TIME) <= CAST('$limiteSuperiorFormatted' AS TIME) THEN 'Tolerancia'
                                    ELSE 'Retraso'
                                    END,
                        estado_ingreso = CASE 
                                        WHEN flag_sabado=1 THEN 1
                                        WHEN flag_domingo=1 THEN 1
                                        WHEN flag_festivo=1 THEN 1
                                        WHEN CAST('$marcacionFormatted' AS TIME) < CAST('$limiteInferiorFormatted' AS TIME) THEN 1
                                        WHEN CAST('$marcacionFormatted' AS TIME) > CAST('$desde_format' AS TIME) AND CAST('$marcacionFormatted' AS TIME) <= CAST('$limiteSuperiorFormatted' AS TIME) THEN 3
                                        ELSE 2
                                        END,
                        fec_act = GETDATE(),
                        user_act = 0
                        WHERE id_registro_asistencia = $id_registro_asistencia
                ");
            }
            
            
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    }
?>