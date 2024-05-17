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
    $query_1 = mysqli_query($conexion, "SELECT a.id_colaborador,a.id_empresa,a.apellido_paterno,a.apellido_materno,a.nombres,a.dni,
    left join contrato_colaborador b on a.id_colaborador=b.id_colaborador and b.estado=2
    from colaborador a 
    
    where a.id_empresa=6 and a.estado=2;");
    
    while ($row_1 = mysqli_fetch_assoc($query_1)) { 
        $id_colaborador = $row_1['id_colaborador'];
        $id_especialidad = $row_1['id_especialidad'];
        $turno = $row_1['Turno'];
        $query_2 = sqlsrv_query($conexion_vps,"SELECT id_registro_ingreso,ingreso,estado_asistencia,estado_ingreso,laborable 
        FROM registro_ingreso WHERE id_alumno = '$id_colaborador' AND CAST(ingreso AS DATE) = '$hoy'");

        if(sqlsrv_has_rows($query_2)){
            $row_2 = sqlsrv_fetch_array($query_2,SQLSRV_FETCH_ASSOC);
            $id_registro_ingreso = $row_2['id_registro_ingreso'];
            $ingreso = $row_2['ingreso'];
            $ingreso = $ingreso->format('H:i:s');
            //$estado_registro = $row_2['estado_registro'];
            $estado_asistencia = $row_2['estado_asistencia'];
            $estado_ingreso = $row_2['estado_ingreso'];
           
            
            $id_hora="";
            if($id_especialidad!="" && $id_especialidad!="0" && ($turno=="TR" || $turno=="MN")){
                $nom_turno="Tarde";
                if($turno=="MN"){
                    $nom_turno="Mañana";
                }
                $query_3 = mysqli_query($conexion, "SELECT id_hora,desde,hasta,tolerancia FROM hora where id_especialidad='$id_especialidad' and nom_turno='$nom_turno' and estado=2");    
                //var_dump($query_3test);
                //echo "SELECT id_hora,desde,hasta,tolerancia FROM hora where id_especialidad='$id_especialidad' and nom_turno='$nom_turno' and estado=2";
                
                if (mysqli_num_rows($query_3) > 0) {
                    $row_3 = mysqli_fetch_array($query_3);
                    $id_hora = $row_3['id_hora'];
                    $desde = $row_3['desde'];
                    $hasta = $row_3['hasta'];
                    $tolerancia = $row_3['tolerancia'];
                    $estado_asistencia="Ingresa";
                    $laborable=$row_2['laborable'];
                    $hora_actual = new DateTime($desde); 
                    $minutos_a_sumar = $tolerancia;

                    $hora_actual->add(new DateInterval("PT{$minutos_a_sumar}M"));

                    $hingreso_tolerancia = $hora_actual->format('H:i:s');
                    if($ingreso<=$desde){
                        $laborable="Puntual";
                        $estado_ingreso=1;
                    }elseif($ingreso>$desde && $ingreso<=$hingreso_tolerancia){
                        $laborable="Tolerancia";
                        $estado_ingreso=3;
                    }else{
                        $laborable="Retraso";
                        $estado_ingreso=2;
                    }
                    $query_ap = sqlsrv_query($conexion_vps, "UPDATE registro_ingreso set 
                    estado_ingreso='$estado_ingreso',estado_asistencia='$estado_asistencia',
                    laborable='$laborable',id_hora='$id_hora', desde='$desde', hasta='$hasta',
                    tolerancia='$tolerancia',fec_act=GETDATE(),user_act=0 where id_registro_ingreso=$id_registro_ingreso");
                }
            }
            
        }
        //$row_2 = sqlsrv_fetch_array($query_2,SQLSRV_FETCH_ASSOC);
        
        
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    }
?>