<?php
class Model_Ca extends CI_Model {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    } 

    public function raw($raw_query, $as_array = false) {
        $query = $this->db->query($raw_query);
        if (is_bool($query)) {
            return true;
        } else {
            if ($as_array) {
                return $query->result_array();
            }
            return $query->result();
        }
    }

    function fondo_index(){
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado(){
        $sql = "SELECT * FROM status WHERE id_status IN (1,2,3,4) ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa(){
        $sql = "SELECT * FROM empresa WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_anio(){
        $sql = "SELECT nom_anio FROM anio WHERE estado=1 ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_mes(){
        $sql = "SELECT cod_mes,nom_mes FROM mes WHERE estado=1 ORDER BY id_mes ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_config($id_config){
        $sql = "SELECT * FROM config 
                WHERE id_config=$id_config";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------DESPESAS------------------------------------------
    function get_saldo_despesa(){
        $sql = "SELECT SUM(valor) AS saldo FROM despesa
                WHERE fec_pago<=CURDATE() AND tipo_despesa NOT IN (4) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_despesa($tipo){ 
        $valor = "";
        if($tipo==2){
            $valor = "WHERE de.estado=2 AND YEAR(de.fec_documento) = YEAR(CURDATE())";
        }
        $sql = "SELECT de.orden,de.fec_pago,de.tipo_despesa,de.estado,de.id_despesa,de.referencia,
                CASE WHEN de.tipo_despesa=1 THEN 'Ingreso' WHEN de.tipo_despesa=2 THEN 'Gasto' 
                WHEN de.tipo_despesa=3 THEN 'Crédito' WHEN de.tipo_despesa=4 THEN 'Black' 
                ELSE '' END AS nom_tipo,
                CASE WHEN de.mes='01' THEN CONCAT('Ene-',de.anio)
                WHEN de.mes='02' THEN CONCAT('Feb-',de.anio) WHEN de.mes='03' THEN 
                CONCAT('Mar-',de.anio) WHEN de.mes='04' THEN CONCAT('Abr-',de.anio)
                WHEN de.mes='05' THEN CONCAT('May-',de.anio) WHEN de.mes='06' THEN 
                CONCAT('Jun-',de.anio) WHEN de.mes='07' THEN CONCAT('Jul-',de.anio)
                WHEN de.mes='08' THEN CONCAT('Ago-',de.anio) WHEN de.mes='09' THEN 
                CONCAT('Set-',de.anio) WHEN de.mes='10' THEN CONCAT('Oct-',de.anio)
                WHEN de.mes='11' THEN CONCAT('Nov-',de.anio) WHEN de.mes='12' THEN 
                CONCAT('Dic-',de.anio) ELSE '' END AS mes_anio,
                CASE WHEN de.id_tipo_pago=1 THEN 'Cuenta Bancaria' WHEN de.id_tipo_pago=2
                THEN 'Efectivo/Transferencia' WHEN de.id_tipo_pago=3 THEN 'Cheque' ELSE '' 
                END AS nom_tipo_pago,ru.nom_rubro,de.descripcion,de.documento,
                CASE WHEN de.fec_documento='0000-00-00' THEN '' ELSE 
                DATE_FORMAT(de.fec_documento,'%d/%m/%Y') END AS fecha_documento,
                CASE WHEN de.fec_pago='0000-00-00' THEN '' ELSE 
                DATE_FORMAT(de.fec_pago,'%d/%m/%Y') END AS fecha_pago,de.valor,
                CASE WHEN de.valor=0 THEN '' ELSE CONCAT('€ ',de.valor) END AS valor_salida,
                CASE WHEN de.tipo_despesa=1 THEN '#009245' 
                WHEN de.tipo_despesa=2 THEN '#C00000' ELSE '#000' END AS color_valor,
                su.nom_subrubro,
                CASE WHEN de.archivo!='' THEN 'Si' ELSE 'No' END AS v_archivo,
                CASE WHEN de.pagamento!='' THEN 'Si' ELSE 'No' END AS v_pagamento,
                CASE WHEN de.doc_pagamento!='' THEN 'Si' ELSE 'No' END AS v_doc_pagamento,
                CASE WHEN de.sin_contabilizar=1 THEN 'Si' ELSE 'No' END AS sin_contabilizar,
                CASE WHEN de.enviado_original=1 THEN 'Si' ELSE 'No' END AS enviado_original,
                CASE WHEN de.sin_documento_fisico=1 THEN 'Si' ELSE 'No' END AS v_sin_documento_fisico,
                CASE WHEN de.estado_d=1 and de.estado=2 THEN 'Registrado' 
                WHEN de.estado_d=2 and de.estado=2 THEN 'Enviado' 
                WHEN de.estado=4 THEN 'Anulado'
                ELSE '' END AS nom_estado,
                CASE WHEN de.archivo='' AND de.pagamento='' and de.estado=2 THEN '#C00000' 
                WHEN de.archivo!='' AND de.pagamento!='' and de.estado=2 THEN '#92D050'
                WHEN de.estado='4' THEN '#C00000'
                ELSE '#0070C0' END AS color_estado,
                de.fec_documento,de.archivo,de.pagamento,de.nom_archivo,de.nom_pagamento,de.doc_pagamento,
                SUBSTRING_INDEX(de.doc_pagamento,'/',-1) AS nom_doc_pagamento,de.observaciones,
                CONCAT(de.anio,'-',de.mes,'-01') AS fecha_mes_anio,de.mes,us.usuario_codigo AS colaborador
                FROM despesa de
                LEFT JOIN rubro_ca ru ON de.id_rubro=ru.id_rubro
                LEFT JOIN subrubro_ca su ON de.id_subrubro=su.id_subrubro
                LEFT JOIN users us ON de.id_colaborador=us.id_usuario
                $valor
                ORDER BY de.orden ASC,de.fec_pago ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_colaborador_despesa(){
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users 
                WHERE id_usuario IN (1,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function ultima_referencia_despesa(){
        $sql = "SELECT * FROM despesa WHERE YEAR(fec_reg)=".date('Y')."";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_despesa($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        //NO QUITAR ES IMPORTANTE
        $valor = $dato['valor'];
        if($dato['tipo_despesa']==2){
            $valor = -abs($dato['valor']);
        }elseif($dato['tipo_despesa']==3){
            $valor = abs($dato['valor']);
        }elseif($dato['tipo_despesa']==4){
            $valor = $dato['valor'];
        }
        
        $sql = "INSERT INTO despesa (referencia,tipo_despesa,id_tipo_pago,id_rubro,descripcion,documento,
                fec_documento,mes,anio,fec_pago,valor,id_subrubro,sin_contabilizar,id_colaborador,
                enviado_original,sin_documento_fisico,observaciones,estado_d,archivo,nom_archivo,pagamento,
                nom_pagamento,doc_pagamento,orden,estado,fec_reg,user_reg)
                VALUES ('".$dato['referencia']."','".$dato['tipo_despesa']."','".$dato['id_tipo_pago']."',
                '".$dato['id_rubro']."','".$dato['descripcion']."','".$dato['documento']."',
                '".$dato['fec_documento']."','".$dato['mes']."','".$dato['anio']."','".$dato['fec_pago']."',
                '$valor','".$dato['id_subrubro']."','".$dato['sin_contabilizar']."',
                '".$dato['id_colaborador']."','".$dato['enviado_original']."',
                '".$dato['sin_documento_fisico']."','".$dato['observaciones']."','".$dato['estado_d']."',
                '".$dato['archivo']."','".$dato['nom_archivo']."','".$dato['pagamento']."',
                '".$dato['nom_pagamento']."','".$dato['doc_pagamento']."','".$dato['orden']."',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_despesa(){
        $sql = "SELECT referencia FROM despesa ORDER BY id_despesa DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_id_despesa($id_despesa){
        $sql = "SELECT *,CASE WHEN mes='01' THEN CONCAT('Ene-',anio) 
                WHEN mes='02' THEN CONCAT('Feb-',anio) WHEN mes='03' THEN CONCAT('Mar-',anio) 
                WHEN mes='04' THEN CONCAT('Abr-',anio) WHEN mes='05' THEN CONCAT('May-',anio) 
                WHEN mes='06' THEN CONCAT('Jun-',anio) WHEN mes='07' THEN CONCAT('Jul-',anio) 
                WHEN mes='08' THEN CONCAT('Ago-',anio) WHEN mes='09' THEN CONCAT('Set-',anio) 
                WHEN mes='10' THEN CONCAT('Oct-',anio) WHEN mes='11' THEN CONCAT('Nov-',anio) 
                WHEN mes='12' THEN CONCAT('Dic-',anio) ELSE '' END AS mes_gasto,
                SUBSTRING_INDEX(doc_pagamento,'/',-1) AS nom_doc_pagamento
                FROM despesa 
                WHERE id_despesa=$id_despesa";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_despesa($dato){ 
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        //NO QUITAR ES IMPORTANTE
        $valor = $dato['valor'];
        if($dato['tipo_despesa']==2){
            $valor = -abs($dato['valor']);
        }elseif($dato['tipo_despesa']==3){
            $valor = abs($dato['valor']);
        }
        $sql = "UPDATE despesa SET tipo_despesa='".$dato['tipo_despesa']."',
                id_tipo_pago='".$dato['id_tipo_pago']."',id_rubro='".$dato['id_rubro']."',
                descripcion='".$dato['descripcion']."',documento='".$dato['documento']."',
                fec_documento='".$dato['fec_documento']."',mes='".$dato['mes']."',anio='".$dato['anio']."',
                fec_pago='".$dato['fec_pago']."',valor='$valor',id_subrubro='".$dato['id_subrubro']."',
                sin_contabilizar='".$dato['sin_contabilizar']."',id_colaborador='".$dato['id_colaborador']."',
                enviado_original='".$dato['enviado_original']."',
                sin_documento_fisico='".$dato['sin_documento_fisico']."',
                observaciones='".$dato['observaciones']."',estado_d='".$dato['estado_d']."',
                archivo='".$dato['archivo']."',pagamento='".$dato['pagamento']."',
                doc_pagamento='".$dato['doc_pagamento']."',nom_archivo='".$dato['nom_archivo']."',
                nom_pagamento='".$dato['nom_pagamento']."',orden='".$dato['orden']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_despesa='".$dato['id_despesa']."'";
        $this->db->query($sql);
    }

    function delete_despesa($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE despesa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_despesa='".$dato['id_despesa']."'";
        $this->db->query($sql);
    }

    function delete_archivo_despesa($id_despesa,$orden){
        if($orden==1){
            $parte = "archivo='',nom_archivo=''";
        }elseif($orden==2){
            $parte = "pagamento='',nom_pagamento=''";
        }else{
            $parte = "doc_pagamento=''";
        }
        $sql = "UPDATE despesa SET $parte
                WHERE id_despesa=$id_despesa";
        $this->db->query($sql);
    }

    function get_list_anio_despesa(){
        $sql = "SELECT YEAR(fec_documento) AS anio 
                FROM despesa 
                WHERE estado=2 AND SUBSTRING(fec_documento,1,1)='2'
                GROUP BY YEAR(fec_documento)
                ORDER BY anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_subrubro_despesa($anio){
        $sql = "SELECT ru.nom_rubro,su.nom_subrubro,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='01' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS enero,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='02' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS febrero,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='03' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS marzo,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='04' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS abril,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='05' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS mayo,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='06' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS junio,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='07' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS julio,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='08' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS agosto,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='09' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS septiembre,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='10' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS octubre,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='11' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS noviembre,
                (SELECT SUM(de.valor) FROM despesa de
                WHERE de.anio='$anio' AND de.mes='12' AND de.id_subrubro=su.id_subrubro AND 
                de.estado=2) AS diciembre
                FROM subrubro_ca su
                LEFT JOIN rubro_ca ru ON su.id_rubro=ru.id_rubro
                WHERE su.id_rubro>0 AND su.estado=2
                ORDER BY ru.nom_rubro ASC,su.nom_subrubro ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------RUBRO------------------------------------------
    function get_list_rubro($id_rubro=null){
        if(isset($id_rubro) && $id_rubro>0){
            $sql = "SELECT * FROM rubro_ca WHERE id_rubro=$id_rubro";
        }else{
            $sql = "SELECT ru.*,st.nom_status,CASE WHEN ru.informe=1 THEN 'Si' ELSE 'No' END
                    AS v_informe
                    FROM rubro_ca ru
                    LEFT JOIN status st ON st.id_status=ru.estado
                    WHERE ru.estado!=4";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_rubro_combo(){
        $sql = "SELECT id_rubro,nom_rubro 
                FROM rubro_ca 
                WHERE estado=2 ORDER BY nom_rubro ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_rubro($dato){
        $sql = "SELECT * FROM rubro_ca WHERE nom_rubro='".$dato['nom_rubro']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_rubro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO rubro_ca (nom_rubro,informe,estado,fec_reg,user_reg) 
                VALUES('".$dato['nom_rubro']."','".$dato['informe']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_rubro($dato){
        $sql = "SELECT * FROM rubro_ca WHERE nom_rubro='".$dato['nom_rubro']."' AND estado=2 AND
                id_rubro!='".$dato['id_rubro']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_rubro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE rubro_ca SET nom_rubro='".$dato['nom_rubro']."',informe='".$dato['informe']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_rubro='".$dato['id_rubro']."'";
        $this->db->query($sql);
    }

    function delete_rubro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE rubro_ca SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_rubro='".$dato['id_rubro']."'";
        $this->db->query($sql);
    }
    //-----------------------------------------------SUB-RUBRO------------------------------------------
    function get_list_subrubro($id_subrubro=null){ 
        if(isset($id_subrubro) && $id_subrubro>0){
            $sql = "SELECT * FROM subrubro_ca 
                    WHERE id_subrubro=$id_subrubro";
        }else{
            $sql = "SELECT su.id_subrubro,ru.nom_rubro,su.nom_subrubro,
                    CASE WHEN su.sin_contabilizar=1 THEN 'Si' ELSE 'No' END AS sin_contabilizar,
                    CASE WHEN su.enviado_original=1 THEN 'Si' ELSE 'No' END AS enviado_original,
                    CASE WHEN su.sin_documento_fisico=1 THEN 'Si' ELSE 'No' END AS sin_documento_fisico,
                    st.nom_status
                    FROM subrubro_ca su
                    LEFT JOIN rubro_ca ru ON ru.id_rubro=su.id_rubro
                    LEFT JOIN status st ON st.id_status=su.estado
                    WHERE su.estado NOT IN (4)
                    ORDER BY ru.nom_rubro ASC,su.nom_subrubro ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_subrubro_combo(){
        $sql = "SELECT id_subrubro,nom_subrubro 
                FROM subrubro_ca
                WHERE estado=2 
                ORDER BY nom_subrubro ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_subrubro_rubro_combo($id_rubro){
        $sql = "SELECT id_subrubro,nom_subrubro 
                FROM subrubro_ca
                WHERE id_rubro=$id_rubro AND estado=2 
                ORDER BY nom_subrubro ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_subrubro($dato){
        $sql = "SELECT id_subrubro FROM subrubro_ca
                WHERE id_rubro='".$dato['id_rubro']."' AND nom_subrubro='".$dato['nom_subrubro']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_subrubro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO subrubro_ca (id_rubro,nom_subrubro,sin_contabilizar,enviado_original,
                sin_documento_fisico,estado,fec_reg,user_reg) 
                VALUES('".$dato['id_rubro']."','".$dato['nom_subrubro']."','".$dato['sin_contabilizar']."',
                '".$dato['enviado_original']."','".$dato['sin_documento_fisico']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_subrubro($dato){
        $sql = "SELECT id_subrubro FROM subrubro_ca 
                WHERE id_rubro='".$dato['id_rubro']."' AND nom_subrubro='".$dato['nom_subrubro']."' AND 
                estado=2 AND id_subrubro!='".$dato['id_subrubro']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_subrubro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE subrubro_ca SET id_rubro='".$dato['id_rubro']."',
                nom_subrubro='".$dato['nom_subrubro']."',sin_contabilizar='".$dato['sin_contabilizar']."',
                enviado_original='".$dato['enviado_original']."',
                sin_documento_fisico='".$dato['sin_documento_fisico']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_subrubro='".$dato['id_subrubro']."'";
        $this->db->query($sql);
    }

    function delete_subrubro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE subrubro_ca SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_subrubro='".$dato['id_subrubro']."'";
        $this->db->query($sql);
    }
    //-----------------------------------------------SALDO BANCO------------------------------------------
    function get_list_saldo_banco($id_estado_bancario=null){
        if(isset($id_estado_bancario) && $id_estado_bancario>0){
            $sql = "SELECT es.*,em.id_empresa,em.nom_empresa,st.nom_status,
                    CASE WHEN es.mes='01' THEN CONCAT('Ene/',es.anio) WHEN es.mes='02' THEN CONCAT('Feb/',es.anio)
                    WHEN es.mes='03' THEN CONCAT('Mar/',es.anio) WHEN es.mes='04' THEN CONCAT('Abr/',es.anio)
                    WHEN es.mes='05' THEN CONCAT('May/',es.anio) WHEN es.mes='06' THEN CONCAT('Jun/',es.anio)
                    WHEN es.mes='07' THEN CONCAT('Jul/',es.anio) WHEN es.mes='08' THEN CONCAT('Ago/',es.anio)
                    WHEN es.mes='09' THEN CONCAT('Sep/',es.anio) WHEN es.mes='10' THEN CONCAT('Oct/',es.anio)
                    WHEN es.mes='11' THEN CONCAT('Nov/',es.anio) WHEN es.mes='12' THEN CONCAT('Dic/',es.anio)
                    ELSE '' END AS inicio
                    FROM estado_bancario es
                    LEFT JOIN empresa em ON em.id_empresa=es.id_empresa
                    LEFT JOIN status st ON st.id_status=es.estado
                    WHERE es.id_estado_bancario=$id_estado_bancario";
        }else{
            $sql = "SELECT es.*,em.id_empresa,em.nom_empresa,st.nom_status,de.movimiento_pdf,de.saldo_bbva,
                    CASE WHEN es.mes='01' THEN CONCAT('Ene/',es.anio) WHEN es.mes='02' THEN CONCAT('Feb/',es.anio)
                    WHEN es.mes='03' THEN CONCAT('Mar/',es.anio) WHEN es.mes='04' THEN CONCAT('Abr/',es.anio)
                    WHEN es.mes='05' THEN CONCAT('May/',es.anio) WHEN es.mes='06' THEN CONCAT('Jun/',es.anio)
                    WHEN es.mes='07' THEN CONCAT('Jul/',es.anio) WHEN es.mes='08' THEN CONCAT('Ago/',es.anio)
                    WHEN es.mes='09' THEN CONCAT('Sep/',es.anio) WHEN es.mes='10' THEN CONCAT('Oct/',es.anio)
                    WHEN es.mes='11' THEN CONCAT('Nov/',es.anio) WHEN es.mes='12' THEN CONCAT('Dic/',es.anio)
                    ELSE '' END AS inicio
                    FROM estado_bancario es
                    LEFT JOIN empresa em ON em.id_empresa=es.id_empresa
                    LEFT JOIN status st ON st.id_status=es.estado
                    LEFT JOIN detalle_estado_bancario de ON de.mes=substring(DATE_ADD(CURDATE(),INTERVAL -1 MONTH),6,2) AND 
                    de.anio=substring(DATE_ADD(CURDATE(),INTERVAL -1 MONTH),1,4) AND de.estado=1 AND 
                    de.id_estado_bancario=es.id_estado_bancario
                    WHERE es.id_estado_bancario=5 AND es.estado!=4";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_banco($id_estado_bancario=null){
        if(isset($id_estado_bancario) && $id_estado_bancario>0){
            $sql = "SELECT es.*,em.id_empresa,em.nom_empresa,st.nom_status,
                    CASE WHEN es.mes='01' THEN CONCAT('Ene/',es.anio) WHEN es.mes='02' THEN CONCAT('Feb/',es.anio)
                    WHEN es.mes='03' THEN CONCAT('Mar/',es.anio) WHEN es.mes='04' THEN CONCAT('Abr/',es.anio)
                    WHEN es.mes='05' THEN CONCAT('May/',es.anio) WHEN es.mes='06' THEN CONCAT('Jun/',es.anio)
                    WHEN es.mes='07' THEN CONCAT('Jul/',es.anio) WHEN es.mes='08' THEN CONCAT('Ago/',es.anio)
                    WHEN es.mes='09' THEN CONCAT('Sep/',es.anio) WHEN es.mes='10' THEN CONCAT('Oct/',es.anio)
                    WHEN es.mes='11' THEN CONCAT('Nov/',es.anio) WHEN es.mes='12' THEN CONCAT('Dic/',es.anio)
                    ELSE '' END AS inicio
                    FROM estado_bancario es
                    LEFT JOIN empresa em ON em.id_empresa=es.id_empresa
                    LEFT JOIN status st ON st.id_status=es.estado
                    WHERE es.id_estado_bancario=$id_estado_bancario";
        }else{
            $sql = "SELECT es.*,em.id_empresa,em.nom_empresa,st.nom_status,
                    CASE WHEN es.mes='01' THEN CONCAT('Ene/',es.anio) WHEN es.mes='02' THEN CONCAT('Feb/',es.anio)
                    WHEN es.mes='03' THEN CONCAT('Mar/',es.anio) WHEN es.mes='04' THEN CONCAT('Abr/',es.anio)
                    WHEN es.mes='05' THEN CONCAT('May/',es.anio) WHEN es.mes='06' THEN CONCAT('Jun/',es.anio)
                    WHEN es.mes='07' THEN CONCAT('Jul/',es.anio) WHEN es.mes='08' THEN CONCAT('Ago/',es.anio)
                    WHEN es.mes='09' THEN CONCAT('Sep/',es.anio) WHEN es.mes='10' THEN CONCAT('Oct/',es.anio)
                    WHEN es.mes='11' THEN CONCAT('Nov/',es.anio) WHEN es.mes='12' THEN CONCAT('Dic/',es.anio)
                    ELSE '' END AS inicio,
                    CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM detalle_estado_bancario de
                            WHERE de.estado=1 AND de.id_estado_bancario=es.id_estado_bancario
                            AND (de.movimiento_pdf IS NULL OR de.saldo_bbva IS NULL)
                        ) THEN 'Pendiente'
                        ELSE 'Completo'
                    END AS estado
                    FROM estado_bancario es
                    LEFT JOIN empresa em ON em.id_empresa=es.id_empresa
                    LEFT JOIN status st ON st.id_status=es.estado
                    WHERE es.id_estado_bancario=5 AND es.estado!=4";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_saldo_banco($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE estado_bancario SET cuenta_bancaria='".$dato['cuenta_bancaria']."',mes='".$dato['mes']."',
                anio='".$dato['anio']."',estado='".$dato['estado']."',observaciones='".$dato['observaciones']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_estado_bancario='".$dato['id_estado_bancario']."'";
        $this->db->query($sql);
    }

    function delete_saldo_banco($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE estado_bancario SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario
                WHERE id_estado_bancario='".$dato['id_estado_bancario']."'";
        $this->db->query($sql);
    }

    function get_list_detalle_saldo_banco($id_estado_bancario){ 
        $sql = "SELECT de.*,CASE WHEN de.mes='01' THEN CONCAT('Ene/',SUBSTRING(de.anio,-2,2)) 
                WHEN de.mes='02' THEN CONCAT('Feb/',SUBSTRING(de.anio,-2,2))
                WHEN de.mes='03' THEN CONCAT('Mar/',SUBSTRING(de.anio,-2,2)) 
                WHEN de.mes='04' THEN CONCAT('Abr/',SUBSTRING(de.anio,-2,2))
                WHEN de.mes='05' THEN CONCAT('May/',SUBSTRING(de.anio,-2,2)) 
                WHEN de.mes='06' THEN CONCAT('Jun/',SUBSTRING(de.anio,-2,2))
                WHEN de.mes='07' THEN CONCAT('Jul/',SUBSTRING(de.anio,-2,2)) 
                WHEN de.mes='08' THEN CONCAT('Ago/',SUBSTRING(de.anio,-2,2))
                WHEN de.mes='09' THEN CONCAT('Sep/',SUBSTRING(de.anio,-2,2)) 
                WHEN de.mes='10' THEN CONCAT('Oct/',SUBSTRING(de.anio,-2,2))
                WHEN de.mes='11' THEN CONCAT('Nov/',SUBSTRING(de.anio,-2,2)) 
                WHEN de.mes='12' THEN CONCAT('Dic/',SUBSTRING(de.anio,-2,2)) END AS mes_anio,
                CASE WHEN de.movimiento_pdf!='' THEN CONCAT('".base_url()."',SUBSTRING_INDEX(de.movimiento_pdf,'/',-1)) 
                ELSE '' END AS link_pdf,
                CASE WHEN de.movimiento_pdf!='' THEN CONCAT('".base_url()."',de.movimiento_pdf) 
                ELSE '' END AS href_pdf,
                CASE WHEN de.movimiento_excel!='' THEN CONCAT('".base_url()."',SUBSTRING_INDEX(de.movimiento_excel,'/',-1)) 
                ELSE '' END AS link_excel,
                CASE WHEN de.movimiento_excel!='' THEN CONCAT('".base_url()."',de.movimiento_excel) 
                ELSE '' END AS href_excel
                FROM detalle_estado_bancario de 
                WHERE de.id_estado_bancario=$id_estado_bancario AND de.estado=1
                ORDER BY de.anio DESC,de.mes DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_mes_detalle_saldo_banco($dato){
        $sql = "SELECT * FROM detalle_estado_bancario WHERE estado=1 AND id_estado_bancario='".$dato['id_estado_bancario']."' AND 
                mes='".$dato['mes']."' AND anio='".$dato['anio']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
      function insert_mes_detalle_saldo_banco($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_estado_bancario (id_estado_bancario,mes,anio,estado,fec_reg,user_reg) VALUES('".$dato['id_estado_bancario']."',
                '".$dato['mes']."','".$dato['anio']."',1,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_detalle_saldo_banco($id_detalle){
        $sql = "SELECT de.*,me.nom_mes,CASE WHEN de.saldo_bbva=0 THEN '' ELSE de.saldo_bbva END AS s_bbva,
                CASE WHEN de.saldo_real=0 THEN '' ELSE de.saldo_real END AS s_real
                FROM detalle_estado_bancario de 
                LEFT JOIN mes me ON me.cod_mes=de.mes
                WHERE de.id_detalle=$id_detalle";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_detalle_saldo_banco($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_estado_bancario SET movimiento_pdf='".$dato['movimiento_pdf']."',movimiento_excel='".$dato['movimiento_excel']."',
                nom_pdf='".$dato['nom_pdf']."',nom_excel='".$dato['nom_excel']."',saldo_bbva='".$dato['saldo_bbva']."',saldo_real='".$dato['saldo_real']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function delete_archivo_saldo_banco($id_detalle,$orden){
        if($orden==1){
          $sql = "UPDATE detalle_estado_bancario SET movimiento_pdf='',nom_pdf=''
                  WHERE id_detalle=$id_detalle";
        }else{
          $sql = "UPDATE detalle_estado_bancario SET movimiento_excel='',nom_excel=''
                  WHERE id_detalle=$id_detalle";
        }
        $this->db->query($sql);
    }
    //-----------------------------------------------DOCUMENTO------------------------------------------
    function get_list_documento($id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_ca 
                    WHERE id_documento=$id_documento";
        }else{
            $parte = "";
            if($_SESSION['usuario'][0]['id_nivel']==13){
                $parte = "AND do.visible=1";
            }
            $sql = "SELECT do.*,CASE WHEN do.documento='' THEN 'No' ELSE 'Si' END AS v_documento,
                    su.nom_subrubro,st.nom_status,
                    CASE WHEN do.documento!='' THEN CONCAT('".base_url()."',do.nom_documento) 
                    ELSE '' END AS link,
                    CONCAT('".base_url()."','documento_ca/',do.id_documento,'/',do.nom_documento) AS href,
                    CASE WHEN do.visible=1 THEN 'Si' ELSE 'No' END AS visible
                    FROM documento_ca do
                    LEFT JOIN subrubro_ca su ON su.id_subrubro=do.id_subrubro
                    LEFT JOIN status st ON st.id_status=do.estado
                    WHERE do.estado NOT IN (4) $parte
                    ORDER BY su.nom_subrubro ASC,do.descripcion ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_cantidad_documento(){
        $sql = "SELECT id_documento FROM documento_ca";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_ca (id_subrubro,descripcion,nom_documento,documento,visible,estado,fec_reg,user_reg) 
                VALUES('".$dato['id_subrubro']."','".$dato['descripcion']."','".$dato['nom_documento']."',
                '".$dato['documento']."','".$dato['visible']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_ca SET id_subrubro='".$dato['id_subrubro']."',descripcion='".$dato['descripcion']."',
                nom_documento='".$dato['nom_documento']."',documento='".$dato['documento']."',visible='".$dato['visible']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }

    function delete_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_ca SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }

    function delete_documento_ca($id_documento){
        $sql = "UPDATE documento_ca SET documento='' WHERE id_documento=$id_documento";
        $this->db->query($sql);
    }
    //-----------------------------------------------INFORME DESPESA------------------------------------------
    function get_list_informe_despesa(){
            $sql = "SELECT ru.nom_rubro AS Rubro,(SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='01' AND d_ene.anio=2022) AS Enero,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='02' AND d_ene.anio=2022) AS Febrero,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='03' AND d_ene.anio=2022) AS Marzo,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='04' AND d_ene.anio=2022) AS Abril,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='05' AND d_ene.anio=2022) AS Mayo,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='06' AND d_ene.anio=2022) AS Junio,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='07' AND d_ene.anio=2022) AS Julio,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='08' AND d_ene.anio=2022) AS Agosto,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='09' AND d_ene.anio=2022) AS Septiembre,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='10' AND d_ene.anio=2022) AS Octubre,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='11' AND d_ene.anio=2022) AS Noviembre,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.mes='12' AND d_ene.anio=2022) AS Diciembre,
                    (SELECT IFNULL(SUM(d_ene.valor),0) FROM despesa d_ene 
                    WHERE d_ene.id_rubro=ru.id_rubro AND d_ene.estado=2 AND d_ene.anio=2022) AS Total
                    FROM rubro_ca ru
                    WHERE ru.informe=1 AND ru.estado=2 order by ru.nom_rubro";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------CARGO------------------------------------------
    function get_list_cargo($id=null,$tipo=null){
        if(isset($id)){
            $sql = "SELECT ca.*,up.usuario_email AS correo_1,up.num_celp AS celular_1,
                    us.usuario_email AS correo_2,us.num_celp AS celular_2,ep.cod_empresa AS cod_empresa_1,
                    es.cod_empresa AS cod_empresa_2,sg.nom_status
                    FROM cargo_ca ca
                    LEFT JOIN users up ON ca.id_usuario_1=up.id_usuario
                    LEFT JOIN users us ON ca.id_usuario_2=us.id_usuario
                    LEFT JOIN empresa ep ON ca.id_empresa_1=ep.id_empresa
                    LEFT JOIN empresa es ON ca.id_empresa_2=es.id_empresa
                    LEFT JOIN (SELECT id_cargo,COUNT(1) AS cantidad 
                    FROM cargo_ca_archivo cr
                    GROUP BY id_cargo) cr ON ca.id=cr.id_cargo
                    LEFT JOIN (SELECT id_cargo,MAX(id) AS id 
                    FROM cargo_ca_historial
                    GROUP BY id_cargo) chm ON ca.id=chm.id_cargo
                    LEFT JOIN cargo_ca_historial ch ON chm.id=ch.id
                    LEFT JOIN status_general sg ON ch.estado_c=sg.id_status_general
                    WHERE ca.id=$id";
        }else{
            $parte = "";
            if($tipo==1){ 
                $parte = "WHERE (SELECT ch.estado_c FROM cargo_ca_historial ch
                        WHERE ch.id_cargo=ca.id AND ch.estado=2 
                        ORDER BY ch.id DESC 
                        LIMIT 1) IN (43,45,46)";
            }

            $sql = "SELECT ca.id,ca.codigo,DATE_FORMAT(ca.fec_reg,'%d-%m-%Y') AS fecha,
                    ud.usuario_codigo AS usuario_de,sp.cod_sede AS sede_1,up.usuario_codigo AS usuario_1,
                    ru.nom_rubro,ca.descripcion,CASE WHEN cr.cantidad>0 THEN 'Si' ELSE 'No' END AS doc,
                    sg.nom_status,sg.color,em.cod_empresa AS empresa_1
                    FROM cargo_ca ca
                    LEFT JOIN users ud ON ca.id_usuario_de=ud.id_usuario
                    LEFT JOIN sede sp ON ca.id_sede_1=sp.id_sede
                    LEFT JOIN users up ON ca.id_usuario_1=up.id_usuario
                    LEFT JOIN rubro_gl ru ON ca.id_rubro=ru.id_rubro
                    LEFT JOIN (SELECT id_cargo,COUNT(1) AS cantidad 
                    FROM cargo_ca_archivo cr
                    GROUP BY id_cargo) cr ON ca.id=cr.id_cargo
                    LEFT JOIN (SELECT id_cargo,MAX(id) AS id 
                    FROM cargo_ca_historial
                    GROUP BY id_cargo) chm ON ca.id=chm.id_cargo
                    LEFT JOIN cargo_ca_historial ch ON chm.id=ch.id
                    LEFT JOIN status_general sg ON ch.estado_c=sg.id_status_general
                    LEFT JOIN empresa em ON ca.id_empresa_1=em.id_empresa
                    $parte
                    ORDER BY doc DESC, ca.codigo DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function limpiar_temporal_cargo_archivos(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM cargo_ca_archivo_temporal 
                WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function get_list_usuario_cargo($id_usuario=null){
        if(isset($id_usuario)){
            $sql = "SELECT * FROM users
                    WHERE id_usuario=$id_usuario";
        }else{
            $sql = "SELECT id_usuario,usuario_codigo
                    FROM users
                    WHERE tipo=1 AND id_nivel!=6 AND estado=2
                    ORDER BY usuario_codigo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_rubro_cargo(){
        $sql = "SELECT id_rubro,nom_rubro FROM rubro_gl
                WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa_cargo(){
        $sql = "SELECT id_empresa,cod_empresa FROM empresa
                WHERE estado=2
                ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_sede_cargo($id_empresa){
        $sql = "SELECT id_sede,cod_sede FROM sede
                WHERE id_empresa=$id_empresa AND estado=2
                ORDER BY cod_sede ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_cargo_archivo_temporal($nombre=null){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        if(isset($nombre)){
            $sql = "SELECT id FROM cargo_ca_archivo_temporal 
                    WHERE id_usuario=$id_usuario AND nombre='$nombre'";
        }else{
            $sql = "SELECT id FROM cargo_ca_archivo_temporal 
                    WHERE id_usuario=$id_usuario";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_cargo_archivo_temporal($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_ca_archivo_temporal (id_usuario,nombre,archivo) 
                VALUES ($id_usuario,'".$dato['nombre']."','".$dato['archivo']."')";
        $this->db->query($sql);
    }

    function get_list_cargo_archivo_temporal($id=null){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        if(isset($id)){
            $sql = "SELECT * FROM cargo_ca_archivo_temporal
                    WHERE id=$id";
        }else{
            $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo
                    FROM cargo_ca_archivo_temporal
                    WHERE id_usuario=$id_usuario";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_cargo_archivo_temporal($id){
        $sql = "DELETE FROM cargo_ca_archivo_temporal 
                WHERE id=$id";
        $this->db->query($sql);
    }

    function valida_usuario_para($id_usuario){ 
        $sql = "SELECT c.id FROM cargo_ca c
                WHERE c.id_usuario_1=$id_usuario AND 
                (SELECT ch.estado_c 
                FROM cargo_ca_historial ch
                WHERE ch.id_cargo=c.id 
                ORDER BY ch.id DESC 
                LIMIT 1) IN (43,45,46)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_nuevo_codigo_cargo(){
        $sql = "SELECT CONCAT('CAR',RIGHT(YEAR(NOW()),2),'-',LPAD((SELECT COUNT(id) FROM cargo_ca)+1,5,'0')) AS codigo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_cargo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_ca (codigo,id_usuario_de,descripcion,id_empresa_1,id_sede_1,id_usuario_1,
                otro_1,id_empresa_2,id_sede_2,id_usuario_2,otro_2,empresa_transporte,referencia,observacion,
                id_rubro,estado,fec_reg,user_reg,fec_act,user_act) 
                VALUES ('".$dato['codigo']."','".$dato['id_usuario_de']."','".$dato['descripcion']."',
                '".$dato['id_empresa_1']."','".$dato['id_sede_1']."','".$dato['id_usuario_1']."',
                '".$dato['otro_1']."','".$dato['id_empresa_2']."','".$dato['id_sede_2']."',
                '".$dato['id_usuario_2']."','".$dato['otro_2']."','".$dato['empresa_transporte']."',
                '".$dato['referencia']."','".$dato['observacion']."','".$dato['id_rubro']."',2,NOW(),
                $id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    function insert_delete_cargo_archivo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_ca_archivo (id_cargo,nombre,archivo) 
                VALUES ('".$dato['id_cargo']."','".$dato['nombre']."','".$dato['archivo']."')";
        $this->db->query($sql);

        $sql2 = "DELETE FROM cargo_ca_archivo_temporal 
                WHERE id=".$dato['id'];
        $this->db->query($sql2);
    }

    function insert_historial_cargo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_ca_historial (id_cargo,estado_c,aprobado,estado,fec_reg,user_reg) 
                VALUES ('". $dato['id_cargo']."','". $dato['estado_c']."','". $dato['aprobado']."',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function get_list_cargo_historial($id=null,$id_cargo=null){
        if(isset($id)){
            $sql = "SELECT ch.*,ch.observacion AS observacion_h,up.usuario_email AS correo_1,ca.codigo,
                    ep.cod_empresa AS cod_empresa_1,ca.descripcion,ca.observacion,ca.id_usuario_2,
                    us.usuario_email AS correo_2
                    FROM cargo_ca_historial ch
                    LEFT JOIN cargo_ca ca ON ch.id_cargo=ca.id
                    LEFT JOIN users up ON ca.id_usuario_1=up.id_usuario
                    LEFT JOIN empresa ep ON ca.id_empresa_1=ep.id_empresa
                    LEFT JOIN users us ON ca.id_usuario_2=us.id_usuario
                    WHERE ch.id=$id";
        }else{
            $sql = "SELECT ch.id,sg.nom_status,sg.color,
                    u.usuario_codigo AS usuario_registro,
                    DATE_FORMAT(ch.fec_reg,'%d/%m/%Y %H:%i') AS fecha_registro,
                    CASE WHEN ch.estado_c=43 THEN 'De' WHEN ch.estado_c=44 THEN 'De'
                    WHEN ch.estado_c=45 THEN 'Transportista/Intermediario' 
                    WHEN ch.estado_c=46 THEN 'Para' WHEN ch.estado_c=47 THEN 'Para' ELSE '' END AS informacion,
                    ch.estado_c
                    FROM cargo_ca_historial ch 
                    LEFT JOIN status_general sg ON ch.estado_c=sg.id_status_general
                    LEFT JOIN users u ON ch.user_reg=u.id_usuario
                    WHERE ch.id_cargo=$id_cargo AND ch.estado=2
                    ORDER BY ch.id ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_observacion_cargo_historial($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cargo_ca_historial SET observacion='".$dato['observacion']."' 
                WHERE id=".$dato['id'];
        $this->db->query($sql);
    }

    function get_list_cargo_archivo($id=null,$id_cargo=null){
        if(isset($id)){
            $sql = "SELECT * FROM cargo_ca_archivo 
                    WHERE id=$id";
        }else{
            $sql = "SELECT * FROM cargo_ca_archivo 
                    WHERE id_cargo=$id_cargo";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_cargo_archivo($nombre=null,$id_cargo=null){
        if(isset($nombre)){
            $sql = "SELECT id FROM cargo_ca_archivo 
                    WHERE id_cargo=$id_cargo AND nombre='$nombre'";
        }else{
            $sql = "SELECT id FROM cargo_ca_archivo 
                    WHERE id_cargo=$id_cargo";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_cargo_archivo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_ca_archivo (id_cargo,nombre,archivo) 
                VALUES ('".$dato['id_cargo']."','".$dato['nombre']."','".$dato['archivo']."')";
        $this->db->query($sql);
    }

    function delete_cargo_archivo($id){
        $sql = "DELETE FROM cargo_ca_archivo 
                WHERE id=$id";
        $this->db->query($sql);
    }

    function update_cargo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cargo_ca SET id_usuario_de='".$dato['id_usuario_de']."',
                descripcion='". $dato['descripcion']."',id_empresa_1='".$dato['id_empresa_1']."',
                id_sede_1='". $dato['id_sede_1']."',id_usuario_1='". $dato['id_usuario_1']."',
                otro_1='". $dato['otro_1']."',id_empresa_2='". $dato['id_empresa_2']."',
                id_sede_2='". $dato['id_sede_2']."',id_usuario_2='". $dato['id_usuario_2']."',
                otro_2='". $dato['otro_2']."',empresa_transporte='". $dato['empresa_transporte']."',
                referencia='". $dato['referencia']."',id_rubro='". $dato['id_rubro']."',
                observacion='". $dato['observacion']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id=".$dato['id']; 
        $this->db->query($sql);
    }
    
    function delete_cargo($id){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_ca_historial (id_cargo,estado_c,aprobado,estado,fec_reg,
                user_reg,fec_act,user_act)
                VALUES ($id,63,0,2,NOW(),$id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_estado_cargo_historial($dato){
        $sql = "SELECT * FROM cargo_ca_historial
                WHERE id_cargo='".$dato['id_cargo']."' AND estado_c=".$dato['estado_c']." AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
}