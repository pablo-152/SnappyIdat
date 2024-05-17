<?php
    include 'conexion.php';

    $query_m = mysqli_query($conexion_arpay,"SELECT Id,Dni FROM matriculados_l20
                WHERE Tipo=1
                ORDER BY Apellido_Paterno ASC, Apellido_Materno ASC, Nombre ASC"); 

    while( $fila = mysqli_fetch_assoc( $query_m ) ) {
        $comercial = mysqli_query($conexion, "SELECT id_registro FROM registro_mail 
                        WHERE id_empresa=6 AND dni='".$fila['Dni']."' 
                        ORDER BY id_registro DESC");
        $dato_comercial = mysqli_fetch_assoc($comercial);
        $total_comercial = mysqli_num_rows($comercial);

        if($total_comercial>0){
            $valida_historico = mysqli_query($conexion, "SELECT id_historial FROM historial_registro_mail 
                                WHERE id_registro='".$dato_comercial['id_registro']."' AND id_accion=13 AND estado=15");
            $total_valida_historico = mysqli_num_rows($valida_historico);
            if($total_valida_historico==0){
                $historico = mysqli_query($conexion, "SELECT comentario FROM historial_registro_mail 
                            WHERE id_registro='".$dato_comercial['id_registro']."' ORDER BY id_historial DESC");
                $dato_historico = mysqli_fetch_assoc($historico);
                $query_h = mysqli_query($conexion, "INSERT INTO historial_registro_mail (id_registro,comentario,id_accion,fecha_accion,estado,fec_reg,user_reg) 
                            VALUES ('".$dato_comercial['id_registro']."','".$dato_historico['comentario']."',13,NOW(),15,NOW(),0)");
            }
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>