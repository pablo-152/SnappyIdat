<?php
class Model_BabyLeaders extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->db5 = $this->load->database('db5', true);
        $this->load->database();
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
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nav_sede(){
        $sql = "SELECT * FROM sede WHERE id_empresa=3 AND estado=2 AND aparece_menu=1 ORDER BY orden_menu ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado(){
        $sql = "SELECT * FROM status 
                WHERE id_status IN (1,2,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_anio(){
        $sql = "SELECT * FROM anio WHERE estado=1 ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_mes(){
        $sql = "SELECT * FROM mes WHERE estado=1 ORDER BY cod_mes ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_departamento(){ 
        $sql = "SELECT * FROM departamento 
                ORDER BY nombre_departamento ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function get_list_provincia($id_departamento){
        $sql = "SELECT * FROM provincia 
                WHERE id_departamento=$id_departamento 
                ORDER BY nombre_provincia ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_distrito($id_provincia){
        $sql = "SELECT * FROM distrito 
                WHERE id_provincia=$id_provincia 
                ORDER BY nombre_distrito ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estadop(){
        $sql = "SELECT * from estadop ORDER BY nom_estadop ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_contabilidad($id_contabilidad=null){
        if(isset($id_contabilidad) && $id_contabilidad > 0){
            $sql = "SELECT * FROM contabilidad WHERE id_contabilidad=$id_contabilidad";
        }else{
            $sql = "SELECT * FROM contabilidad WHERE estado=1";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_api_maestra($dato){
        $documento="";
        if($dato['tipo_api']==1){
            $documento=",case when ".$dato['tipo_doc']."=1 then 'dni/'
            when ".$dato['tipo_doc']."=2 then 'ruc/'
            end as documento ";
        }
        if($dato['tipo_api']==2 || $dato['tipo_api']==3){
            $documento=",case 
            when ".$dato['tipo_doc']."=1 then 'send'
            when ".$dato['tipo_doc']."=2 then 'xml'
            when ".$dato['tipo_doc']."=3 then 'pdf'
            end as documento ";
        }
        $sql = "SELECT a.* $documento FROM api_maestra a 
                WHERE a.estado=1 AND a.tipo_api=".$dato['tipo_api'];
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------CLIENTE-------------------------------------
    function get_list_cliente(){ 
        $sql = "SELECT al.n_documento,al.alum_apater,al.alum_amater,al.alum_nom,di.nombre_distrito 
                FROM alumno al
                LEFT JOIN distrito di ON di.id_distrito=al.id_distrito
                WHERE al.id_sede=6 AND al.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------ARTÍCULOS------------------------------------------
    function get_list_articulo($tipo){ 
        if($tipo==1){
            $parte = "ar.estado=2";
        }else{
            $parte = "ar.estado NOT IN (4)";
        }
        $sql = "SELECT ar.*,CASE WHEN id_tipo=1 THEN 'Administrativos' WHEN id_tipo=2 THEN 'Puntuales' 
                WHEN id_tipo=3 THEN 'Regulares' ELSE '' END AS nom_tipo,CASE WHEN id_publico=1 
                THEN 'Adultos' WHEN id_publico=2 THEN 'Bebes' WHEN id_publico=3 
                THEN 'Directo' ELSE '' END AS nom_publico,CASE WHEN ar.monto>0 THEN ar.monto ELSE '' 
                END AS monto,CASE WHEN ar.desc_porcentaje>0 THEN ar.desc_porcentaje ELSE '' 
                END AS desc_porcentaje,CASE WHEN ar.desc_monto>0 THEN ar.desc_monto ELSE '' 
                END AS desc_monto,CASE WHEN ar.desc_resultado>0 THEN ar.desc_resultado ELSE '' 
                END AS desc_resultado,CASE WHEN ar.obligatorio_dia=1 THEN 'Si' ELSE 'No' END obligatorio_dia,
                st.nom_status,st.color
                FROM articulo ar 
                LEFT JOIN status st ON st.id_status=ar.estado
                WHERE $parte
                ORDER BY st.nom_status ASC,ar.anio DESC,ar.nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_articulo_todo(){
        $sql = "SELECT id_articulo,nombre,CASE WHEN id_tipo=1 THEN 'Administrativos' WHEN id_tipo=2 THEN 'Puntuales' 
                WHEN id_tipo=3 THEN 'Regulares' ELSE '' END AS nom_tipo,monto,desc_resultado 
                FROM articulo";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_articulo_combo(){
        $sql = "SELECT id_articulo,nombre,CASE WHEN id_tipo=1 THEN 'Administrativos' WHEN id_tipo=2 THEN 'Puntuales' 
                WHEN id_tipo=3 THEN 'Regulares' ELSE '' END AS nom_tipo,monto,desc_resultado
                FROM articulo 
                WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_articulo($dato){
        $sql = "SELECT * FROM articulo 
                WHERE anio='".$dato['anio']."' AND referencia='".$dato['referencia']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_articulo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO articulo (anio,nombre,referencia,id_tipo,id_publico,
                monto,obligatorio_dia,desc_referencia,desc_porcentaje,desc_monto,
                desc_resultado,estado,fec_reg,user_reg) 
                VALUES('".$dato['anio']."','".$dato['nombre']."','".$dato['referencia']."',
                '".$dato['id_tipo']."','".$dato['id_publico']."','".$dato['monto']."',
                '".$dato['obligatorio_dia']."','".$dato['desc_referencia']."',
                '".$dato['desc_porcentaje']."','".$dato['desc_monto']."',
                '".$dato['desc_resultado']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_articulo($id_articulo){
        $sql = "SELECT *,CASE WHEN monto>0 THEN monto ELSE '' END AS monto,
                CASE WHEN desc_porcentaje>0 THEN desc_porcentaje ELSE '' END AS desc_porcentaje,
                CASE WHEN desc_monto>0 THEN desc_monto ELSE '' END AS desc_monto,
                CASE WHEN desc_resultado>0 THEN desc_resultado ELSE '' END AS desc_resultado 
                FROM articulo 
                WHERE id_articulo=$id_articulo";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_update_articulo($dato){
        $sql = "SELECT * FROM articulo 
                WHERE anio='".$dato['anio']."' AND referencia='".$dato['referencia']."' AND 
                estado=2 AND id_articulo!='".$dato['id_articulo']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_articulo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE articulo SET anio='".$dato['anio']."',nombre='".$dato['nombre']."',referencia='".$dato['referencia']."',
                id_tipo='".$dato['id_tipo']."',id_publico='".$dato['id_publico']."',monto='".$dato['monto']."',
                obligatorio_dia='".$dato['obligatorio_dia']."',desc_referencia='".$dato['desc_referencia']."',
                desc_porcentaje='".$dato['desc_porcentaje']."',desc_monto='".$dato['desc_monto']."',
                desc_resultado='".$dato['desc_resultado']."',estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_articulo='".$dato['id_articulo']."'";
        $this->db->query($sql);
    }

    function delete_articulo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE articulo SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_articulo='".$dato['id_articulo']."'";
        $this->db->query($sql);
    }
    //-----------------------------------------------PRODUCTOS------------------------------------------
    function get_list_producto($tipo){
        if($tipo==1){
            $parte = "pr.estado=2";
        }else{
            $parte = "pr.estado NOT IN (4)";
        }
        $sql = "SELECT pr.*,CASE WHEN pr.id_publico=1 THEN 'Adultos' WHEN pr.id_publico=2 THEN 'Bebes' 
                WHEN pr.id_publico=3 THEN 'Directo' ELSE '' END AS nom_publico,
                DATE_FORMAT(pr.inicio_pag,'%d/%m/%Y') as inicio,
                DATE_FORMAT(pr.fin_pag,'%d/%m/%Y') as fin,gr.nom_grado,st.nom_status,st.color
                FROM producto_articulo pr
                LEFT JOIN grado_bl gr ON gr.id_grado=pr.id_grado
                LEFT JOIN status st ON st.id_status=pr.estado
                WHERE $parte
                ORDER BY st.nom_status ASC,gr.nom_grado ASC,pr.anio DESC,pr.nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_producto_combo($id_grado){
        $sql = "SELECT id_producto,nombre AS nom_producto FROM producto_articulo 
                WHERE id_grado=$id_grado AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_producto($dato){
        $sql = "SELECT * FROM producto_articulo 
                WHERE anio='".$dato['anio']."' AND referencia='".$dato['referencia']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO producto_articulo (id_grado,anio,nombre,referencia,id_articulo,
                id_publico,inicio_pag,fin_pag,estado,fec_reg,user_reg) 
                VALUES('".$dato['id_grado']."','".$dato['anio']."','".$dato['nombre']."',
                '".$dato['referencia']."','".$dato['id_articulo']."',
                '".$dato['id_publico']."','".$dato['inicio_pag']."','".$dato['fin_pag']."',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_producto($id_producto){
        $sql = "SELECT * FROM producto_articulo
                WHERE id_producto=$id_producto";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_update_producto($dato){
        $sql = "SELECT * FROM producto_articulo 
                WHERE anio='".$dato['anio']."' AND referencia='".$dato['referencia']."' AND 
                estado=2 AND id_producto!='".$dato['id_producto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_articulo SET id_grado='".$dato['id_grado']."',
                anio='".$dato['anio']."',nombre='".$dato['nombre']."',
                referencia='".$dato['referencia']."',id_articulo='".$dato['id_articulo']."',
                id_publico='".$dato['id_publico']."',inicio_pag='".$dato['inicio_pag']."',
                fin_pag='".$dato['fin_pag']."',estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_producto='".$dato['id_producto']."'";
        $this->db->query($sql);
    }

    function delete_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_articulo SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_producto='".$dato['id_producto']."'";
        $this->db->query($sql);
    }
    //-----------------------------------------------PROFESOR------------------------------------------
    function get_list_profesor(){
        $sql = "SELECT pe.FatherSurname,pe.MotherSurname,pe.FirstName,ep.InternalEmployeeId,pe.IdentityCardNumber,
                rh.Description,FORMAT(em.StartDate,'dd-MM-yyyy') AS StartDate,em.EndDate,'Activo' AS Estado
                FROM EmployeeEnterpriseActivity em
                LEFT JOIN Employee ep ON ep.Id=em.EmployeeId
                LEFT JOIN Person pe ON pe.Id=ep.PersonId
                LEFT JOIN RHContractTypeTranslation rh ON rh.RHContractTypeId=em.RHContractTypeId
                WHERE em.EmployeeRoleId=6 AND em.EnterpriseHeadquarterId=4 AND em.EndDate IS NULL
                ORDER BY pe.FatherSurname ASC,pe.MotherSurname ASC,pe.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }
    //------------------------------------------------------MATRICULADOS------------------------------------------
    function get_list_matriculados($tipo){
        $empresa = 4;
        if($tipo==1){
            $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombres,
                    per.IdentityCardNumber AS Documento,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
                    END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
                    FROM Matriculation oldMat  
                    JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
                    JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
                    WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS Alumno,
                    ISNULL(cc.Name, 'N/D') AS 'Class',Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
                    (SELECT TOP 1 FORMAT(PurchaseDate,'dd/MM/yyyy') FROM ClientProductPurchaseRegistry 
                    WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                    ClientProductPurchaseRegistry.Description='Matricula') AS Matricula,(SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
                    INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
                    WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                    ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,per.BirthDate AS Fecha_Cumpleanos,
                    FORMAT(per.BirthDate,'dd/MM/yyyy') AS Cumpleanos,
                    (SELECT COUNT(*) FROM Student.StudentDocument st 
                    WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1 AND st.DocumentFilePath!='') AS Cantidad_Subida,
                    (SELECT COUNT(*) FROM Student.StudentDocument st 
                    WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1) AS Cantidad_Obligatorio,
                    CASE WHEN cc.Name IS NULL THEN 'N/D' WHEN mat.StatusId IN (2,3,4,6,7) THEN 'N/D' ELSE cc.Name END AS Seccion,
                    mst.Description AS MatriculationStatusName
                    FROM Client cli
                    JOIN Person per ON per.Id = cli.PersonId  
                    LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                    WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                    LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
                    LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                    LEFT JOIN Course c ON c.Id = pi.CourseId  
                    LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
                    LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                    WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                    ORDER BY ccs2.Id DESC)  
                    LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                    LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                    WHERE cli.EnterpriseHeadquarterId = $empresa AND cli.InternalStudentId IS NOT NULL AND cli.StudentStatusId=5 AND YEAR(mat.StartDate)=2022
                    ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId";
        }else{
            $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombres,
                    per.IdentityCardNumber AS Documento,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
                    END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
                    FROM Matriculation oldMat  
                    JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
                    JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
                    WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS Alumno,
                    ISNULL(cc.Name, 'N/D') AS 'Class',Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
                    (SELECT TOP 1 FORMAT(PurchaseDate,'dd/MM/yyyy') FROM ClientProductPurchaseRegistry 
                    WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                    ClientProductPurchaseRegistry.Description='Matricula') AS Matricula,(SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
                    INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
                    WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                    ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,per.BirthDate AS Fecha_Cumpleanos,
                    FORMAT(per.BirthDate,'dd/MM/yyyy') AS Cumpleanos,
                    (SELECT COUNT(*) FROM Student.StudentDocument st 
                    WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1 AND st.DocumentFilePath!='') AS Cantidad_Subida,
                    (SELECT COUNT(*) FROM Student.StudentDocument st 
                    WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1) AS Cantidad_Obligatorio,
                    CASE WHEN cc.Name IS NULL THEN 'N/D' WHEN mat.StatusId IN (2,3,4,6,7) THEN 'N/D' ELSE cc.Name END AS Seccion,
                    mst.Description AS MatriculationStatusName
                    FROM Client cli
                    JOIN Person per ON per.Id = cli.PersonId  
                    LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                    WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                    LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
                    LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                    LEFT JOIN Course c ON c.Id = pi.CourseId  
                    LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
                    LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                    WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                    ORDER BY ccs2.Id DESC)  
                    LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                    LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                    WHERE cli.EnterpriseHeadquarterId = $empresa AND cli.InternalStudentId IS NOT NULL AND cli.StudentStatusId=5 AND YEAR(mat.StartDate)=2022
                    ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId";
        }
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function get_id_matriculados($id_alumno){
        $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombres,
                per.IdentityCardNumber AS Documento,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
                END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
                FROM Matriculation oldMat  
                JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
                JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
                WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS Alumno,
                ISNULL(cc.Name, 'N/D') AS 'Class',Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
                (SELECT TOP 1 FORMAT(PurchaseDate,'dd/MM/yyyy') FROM ClientProductPurchaseRegistry 
                WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                ClientProductPurchaseRegistry.Description='Matricula') AS Matricula,(SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
                INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
                WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,per.BirthDate AS Fecha_Cumpleanos,
                FORMAT(per.BirthDate,'dd/MM/yyyy') AS Cumpleanos,
                CONCAT(per.FatherSurname,' ',per.MotherSurname,', ',per.FirstName) AS Nombre_Completo,per.MobilePhone AS Celular
                FROM Client cli
                JOIN Person per ON per.Id = cli.PersonId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
                LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                LEFT JOIN Course c ON c.Id = pi.CourseId  
                LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
                LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                ORDER BY ccs2.Id DESC)  
                LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                WHERE cli.Id=$id_alumno";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }

    function get_list_pago_matriculados($id_alumno){
        $sql = "SELECT prod.Name AS 'Producto',pst.Description AS 'Estado',cppr.Description AS 'Descripcion',cppr.PaymentDueDate AS 'Fecha_VP',
                cppr.Cost AS 'Monto',cppr.TotalDiscount AS 'Descuento',cppr.PenaltyAmountPaid AS 'Penalidad',(ISNULL(cppr.Cost,0)-
                ISNULL(cppr.TotalDiscount,0)+ISNULL(cppr.PenaltyAmountPaid,0)) AS 'SubTotal'
                FROM ClientProductPurchaseRegistry cppr,Client cli,Person p,EnterpriseHeadquarter eh,Headquarter he,Product prod,ProductItem prodItem,  
                PaymentStatusTranslation pst   
                WHERE cli.Id=$id_alumno AND cppr.PaymentStatusId IN (1,2,3) AND cppr.ClientId = cli.Id AND cli.PersonId = p.Id AND cli.EnterpriseHeadquarterId = eh.Id AND 
                eh.HeadquarterId = he.Id AND cppr.ProductId = prod.Id AND cppr.ProductItemId = prodItem.Id AND cppr.PaymentStatusId = pst.PaymentStatusId AND 
                pst.[Language] = 'es-PE'  
                ORDER BY prod.Name, cli.InternalStudentId";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }

    function get_list_documento_matriculados($id_alumno){ 
        $sql = "SELECT st.Id,st.Name,st.Year,ap.Name AS Usuario_Entrega,FORMAT(st.DeliveryDate,'dd/MM/yyyy HH:mm') AS Fecha_Entrega,
                CASE WHEN st.DocumentTemplateFilledRequired=1 THEN 'Si' ELSE 'No' END AS Obligatorio_Documento,st.DocumentFilePath
                FROM Student.StudentDocument st
                LEFT JOIN AspNetUsers ap ON ap.Id=st.DeliveredBy
                WHERE st.ClientId=$id_alumno";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------ALUMNOS------------------------------------------
    function get_informe_matriculados(){
        $anio = date('Y');
        $sql = "SELECT (SELECT COUNT(*) FROM ultima_matricula_bl 
                WHERE anio=$anio AND estado_matricula NOT IN ('Retirado(a)') AND 
                pagos_pendientes=0) AS total_al_dia,
                (SELECT COUNT(*) FROM ultima_matricula_bl 
                WHERE anio=$anio AND estado_matricula NOT IN ('Retirado(a)') AND 
                pagos_pendientes=1) AS total_p1,
                (SELECT COUNT(*) FROM ultima_matricula_bl 
                WHERE anio=$anio AND estado_matricula NOT IN ('Retirado(a)') AND 
                pagos_pendientes=2) AS total_p2,
                (SELECT COUNT(*) FROM ultima_matricula_bl 
                WHERE anio=$anio AND estado_matricula NOT IN ('Retirado(a)') AND 
                pagos_pendientes>=3) AS total_p3";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }
    
    function get_list_alumno($id_alumno=null,$tipo=null){  
        if(isset($id_alumno) && $id_alumno>0){
            $anio = date('Y');
            $sql = "SELECT al.*,
                    CASE WHEN um.nom_grado IS NULL THEN gr.nom_grado ELSE um.nom_grado END AS nom_grado,
                    CASE WHEN um.nom_seccion IS NULL THEN se.nom_seccion ELSE um.nom_seccion END AS nom_seccion,
                    DATE_FORMAT(al.fecha_nacimiento,'%d/%m/%Y') AS fec_nacimiento,de.nombre_departamento,
                    pr.nombre_provincia,di.nombre_distrito,pp.nom_parentesco AS parentesco_1,
                    ps.nom_parentesco AS parentesco_2,us.usuario_codigo AS Usuario,
                    CASE WHEN um.id_matricula IS NULL THEN 'Registrado' 
                    WHEN um.estado_matricula='Retirado(a)' THEN 'Retirado'
                    WHEN um.pago_matricula=0 THEN 'Asignado' 
                    WHEN um.pago_matricula>0 THEN 'Matriculado'
                    ELSE '' END AS estado_alumno,um.anio,um.estado_matricula
                    FROM alumno al
                    LEFT JOIN grado_bl gr ON gr.id_grado=al.id_grado
                    LEFT JOIN seccion se ON se.id_seccion=al.id_seccion
                    LEFT JOIN departamento de ON de.id_departamento=al.id_departamento
                    LEFT JOIN provincia pr ON pr.id_provincia=al.id_provincia
                    LEFT JOIN distrito di ON di.id_distrito=al.id_distrito
                    LEFT JOIN parentesco pp ON pp.id_parentesco=al.titular1_parentesco
                    LEFT JOIN parentesco ps ON ps.id_parentesco=al.titular2_parentesco
                    LEFT JOIN users us ON us.id_usuario=al.user_reg
                    LEFT JOIN ultima_matricula_bl um ON um.id_alumno=al.id_alumno
                    WHERE al.id_alumno=$id_alumno"; 
        }else{
            $anio = date('Y');
            $prox_anio = $anio+1;
            $parte = "";
            if($tipo==1){
                /*$parte = "AND (SELECT COUNT(*) FROM pago_matricula_alumno_bl pa 
                        LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                        WHERE pa.nom_pago='Matrícula' AND pa.estado_pago=2 AND ma.id_alumno=al.id_alumno AND 
                        YEAR(ma.fec_matricula)=$anio AND ma.estado=2 AND pa.estado=2
                        ORDER BY pa.id_matricula DESC
                        LIMIT 1)>0";*/
                $parte = "AND um.anio=$anio AND um.pago_matricula>0 AND um.estado_matricula NOT IN ('Retirado(a)')";
            }elseif($tipo==2){
                /*$parte = "AND (SELECT COUNT(*) FROM pago_matricula_alumno_bl pa 
                        LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                        WHERE pa.nom_pago='Matrícula' AND pa.estado_pago=2 AND ma.id_alumno=al.id_alumno AND 
                        YEAR(ma.fec_matricula)=$prox_anio AND ma.estado=2 AND pa.estado=2
                        ORDER BY pa.id_matricula DESC
                        LIMIT 1)>0";*/
                $parte = "AND um.anio=$prox_anio AND um.pago_matricula>0 AND um.estado_matricula NOT IN ('Retirado(a)')";
            }elseif($tipo==4){
                /*$parte = "AND (SELECT COUNT(*) FROM pago_matricula_alumno_bl pa 
                        LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                        WHERE pa.nom_pago='Matrícula' AND pa.estado_pago=1 AND ma.id_alumno=al.id_alumno AND 
                        ma.estado=2 AND pa.estado=2
                        ORDER BY pa.id_matricula DESC
                        LIMIT 1)>0";*/
                $parte = "AND um.anio=$anio AND um.pago_matricula=0 AND um.estado_matricula NOT IN ('Retirado(a)')";
            }elseif($tipo==5){
                $parte = "AND um.estado_matricula='Retirado(a)'";
            } 

            /*CASE WHEN (SELECT COUNT(*) FROM pago_matricula_alumno_bl pa 
            LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
            WHERE pa.nom_pago='Matrícula' AND pa.estado_pago=1 AND ma.id_alumno=al.id_alumno AND 
            ma.estado=2 AND pa.estado=2
            ORDER BY pa.id_matricula DESC
            LIMIT 1)>0 THEN 'Asignado'
            WHEN (SELECT COUNT(*) FROM pago_matricula_alumno_bl pa 
            LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
            WHERE pa.nom_pago='Matrícula' AND pa.estado_pago=2 AND ma.id_alumno=al.id_alumno AND 
            YEAR(ma.fec_matricula)=$anio AND ma.estado=2 AND pa.estado=2
            ORDER BY pa.id_matricula DESC
            LIMIT 1)>0 THEN 'Matriculado'
            ELSE 'Registrado' END AS estado_alumno */

            $sql = "SELECT al.id_alumno,al.alum_apater,al.alum_amater,al.alum_nom,al.cod_alum, 
                    CASE WHEN um.nom_grado IS NULL THEN gr.nom_grado ELSE um.nom_grado END AS nom_grado,
                    um.nom_curso,CASE WHEN um.nom_seccion IS NULL THEN se.nom_seccion 
                    ELSE um.nom_seccion END AS nom_seccion,
                    um.estado_matricula,
                    CASE WHEN um.id_matricula IS NULL THEN 'Registrado' 
                    WHEN um.estado_matricula='Retirado(a)' THEN 'Retirado'
                    WHEN um.pago_matricula=0 THEN 'Asignado' 
                    WHEN um.pago_matricula>0 THEN 'Matriculado'
                    ELSE '' END AS estado_alumno,
                    um.anio,
                    CASE WHEN um.pagos_pendientes=0 THEN 'Al Día' 
                    WHEN um.pagos_pendientes=1 THEN 'Pendiente 1' 
                    WHEN um.pagos_pendientes=2 THEN 'Pendiente 2' 
                    WHEN um.pagos_pendientes IS NULL THEN 'Sin Pagos'
                    ELSE 'Pendiente 3+'
                    END AS nom_pago_pendiente,
                    CASE WHEN um.pagos_pendientes=0 THEN '#92D050' 
                    WHEN um.pagos_pendientes=1 THEN '#7F7F7F' 
                    WHEN um.pagos_pendientes=2 THEN '#F8CBAD' 
                    WHEN um.pagos_pendientes IS NULL THEN '#000'
                    ELSE '#C00000' 
                    END AS color_pago_pendiente,
                    CASE WHEN um.nom_grado IS NULL THEN documentos_obligatorios_bl(al.id_grado) 
                    ELSE documentos_obligatorios_bl(um.id_grado) END AS documentos_obligatorios,
                    CASE WHEN um.nom_grado IS NULL THEN documentos_subidos_bl(al.id_grado,al.id_alumno) 
                    ELSE documentos_subidos_bl(um.id_grado,al.id_alumno) END AS documentos_subidos,
                    (SELECT dd.id_detalle FROM detalle_alumno_empresa dd 
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=dd.id_documento
                    WHERE dd.id_alumno=al.id_alumno AND da.id_empresa=3 AND da.cod_documento='D00' AND 
                    dd.archivo!='' AND dd.estado=2 
                    ORDER BY dd.anio DESC,dd.id_detalle DESC 
                    LIMIT 1) AS id_foto,al.titular1_apater,al.titular1_amater,al.titular1_nom,
                    al.titular1_correo,al.titular1_celular,al.titular2_apater,al.titular2_amater,
                    al.titular2_nom,al.titular2_correo,al.titular2_celular,
                    (SELECT ar.id_alumno_retirado FROM alumno_retirado ar 
                    WHERE ar.Id=al.id_alumno AND ar.id_empresa=3 AND ar.estado=2) AS id_alumno_retirado,
                    um.estado_matricula
                    FROM alumno al 
                    LEFT JOIN grado_bl gr ON al.id_grado=gr.id_grado 
                    LEFT JOIN seccion se ON al.id_seccion=se.id_seccion 
                    LEFT JOIN ultima_matricula_bl um ON al.id_alumno=um.id_alumno
                    WHERE al.id_sede=6 AND al.estado=2 $parte
                    ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC";
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_alumno_combo(){ 
        $sql = "SELECT id_alumno,CONCAT(alum_apater,' ',alum_amater,', ',alum_nom) AS nom_alumno,
                id_grado
                FROM alumno
                WHERE id_sede=6 AND estado=2
                ORDER BY alum_nom ASC,alum_apater ASC,alum_amater ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_alumno_grado_combo($id_grado){ 
        $sql = "SELECT id_alumno,CONCAT(alum_apater,' ',alum_amater,', ',alum_nom) AS nom_alumno,
                id_grado
                FROM alumno
                WHERE id_sede=6 AND id_grado=$id_grado AND estado=2
                ORDER BY alum_nom ASC,alum_apater ASC,alum_amater ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_total_enadmision(){
        $sql = "SELECT COUNT(*) AS total FROM alumno WHERE id_sede=6 AND estado_alumno=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_enadmision(){
        $sql = "SELECT g.nom_grado,(SELECT COUNT(*) FROM alumno a 
                WHERE a.id_grado=g.id_grado AND a.estado_alumno=1) AS total 
                FROM grado_bl g 
                WHERE g.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_seguimiento(){
        $sql = "SELECT COUNT(*) AS total FROM alumno WHERE id_sede=6 AND estado_alumno IN (9,10,11)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_seguimiento(){
        $sql = "SELECT g.nom_grado, 
                (SELECT COUNT(*) FROM alumno a WHERE a.id_grado=g.id_grado AND a.estado_alumno=9) AS total_s1,
                (SELECT COUNT(*) FROM alumno a WHERE a.id_grado=g.id_grado AND a.estado_alumno=10) AS total_s2,
                (SELECT COUNT(*) FROM alumno a WHERE a.id_grado=g.id_grado AND a.estado_alumno=11) AS total_s3
                FROM grado_bl g WHERE g.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_sinefecto(){
        $sql = "SELECT COUNT(*) AS total FROM alumno WHERE id_sede=6 AND estado_alumno=8";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_sinefecto(){
        $sql = "SELECT g.nom_grado, (SELECT COUNT(*) FROM alumno a 
                WHERE a.id_grado=g.id_grado AND a.estado_alumno=8) AS total 
                FROM grado_bl g 
                WHERE g.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_graduado(){
        $sql = "SELECT COUNT(*) AS total FROM alumno WHERE id_sede=6 AND estado_alumno=17";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_graduado(){
        $sql = "SELECT g.nom_grado, (SELECT COUNT(*) FROM alumno a 
                WHERE a.id_grado=g.id_grado AND a.estado_alumno=17) AS total 
                FROM grado_bl g 
                WHERE g.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_matriculado(){
        $sql = "SELECT COUNT(*) AS total FROM alumno WHERE id_sede=6 AND estado_alumno=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_matriculado(){
        $sql = "SELECT gr.nom_grado,
                (SELECT COUNT(*) FROM alumno al
                LEFT JOIN hingresoceba hi ON hi.id_alumno=al.id_alumno
                WHERE al.id_sede=6 AND al.estado_alumno=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=5 AND al.id_grado=gr.id_grado) AS activos,
                (SELECT COUNT(*) as total FROM alumno al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.id_sede=6 AND al.estado_alumno=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>5 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=10 AND 
                al.id_grado=gr.id_grado) AS asistiendo,
                (SELECT COUNT(*) as total FROM alumno al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.id_sede=6 AND al.estado_alumno=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>10 AND al.id_grado=gr.id_grado) AS inactivos,
                (SELECT COUNT(DISTINCT p.id_alumno) FROM pago p
                LEFT JOIN alumno al ON al.id_alumno=p.id_alumno
                WHERE al.id_sede=6 AND p.id_grado=gr.id_grado and p.estado=2 and p.id_prod_final<>8 AND 
                (SELECT COUNT(*) FROM pago pp WHERE pp.terminado=1 and pp.id_alumno=p.id_alumno and pp.id_grado=p.id_grado)=6) AS promovidos
                FROM grado_bl gr
                WHERE gr.estado=2 ORDER BY gr.nom_grado ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_alumno($dato){
        $sql = "SELECT id_alumno FROM alumno WHERE id_sede=6 AND n_documento='".$dato['n_documento']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function ultimo_cod_alumno($anio){
        $sql = "SELECT id_alumno FROM alumno WHERE id_sede=6 AND YEAR(fec_reg)='".$anio."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno (id_sede,cod_alum,n_documento,alum_apater,alum_amater,alum_nom,fecha_nacimiento,
                direccion,id_departamento,id_provincia,id_distrito,titular1_dni,titular1_parentesco,titular1_apater,
                titular1_amater,titular1_nom,titular1_celular,titular1_departamento,titular1_provincia,titular1_distrito,
                titular2_dni,titular2_parentesco,titular2_apater,titular2_amater,titular2_nom,titular2_celular,
                titular2_departamento,titular2_provincia,titular2_distrito,id_grado,id_seccion,tipo,id_medio,
                estado_alumno,estado,fec_reg,user_reg)  
                VALUES(6,'".$dato['cod_alum']."','".$dato['n_documento']."','".$dato['alum_apater']."',
                '".$dato['alum_amater']."','".$dato['alum_nom']."','".$dato['fecha_nacimiento']."',
                '".$dato['direccion']."','".$dato['id_departamento']."','".$dato['id_provincia']."',
                '".$dato['id_distrito']."','".$dato['titular1_dni']."','".$dato['titular1_parentesco']."',
                '".$dato['titular1_apater']."','".$dato['titular1_amater']."','".$dato['titular1_nom']."',
                '".$dato['titular1_celular']."',0,0,0,'".$dato['titular2_dni']."','".$dato['titular2_parentesco']."',
                '".$dato['titular2_apater']."','".$dato['titular2_amater']."','".$dato['titular2_nom']."',
                '".$dato['titular2_celular']."',0,0,0,'".$dato['id_grado']."','".$dato['id_seccion']."','".$dato['tipo']."',
                '".$dato['id_medio']."',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_documentos_asignados($id_grado){  
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                WHERE id_empresa=3 AND nom_grado IN (0,$id_grado) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documentos_alumno($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,anio,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."',3,'".$dato['anio']."',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function get_list_estadoa(){ 
        $sql = "SELECT id_estadoa,nom_estadoa FROM estadoa WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_alumno($dato){
        $sql = "SELECT * FROM alumno 
                WHERE id_sede=6 AND n_documento='".$dato['n_documento']."' AND 
                estado=2 AND id_alumno!='".$dato['id_alumno']."'";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function valida_cod_arpay($dato){
        $sql = "SELECT * FROM alumno WHERE id_sede=6 AND cod_arpay='".$dato['cod_arpay']."' AND 
                id_alumno!='".$dato['id_alumno']."' AND estado_alumno!=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;  
    }

    function update_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno SET n_documento='".$dato['n_documento']."',
                cod_arpay='".$dato['cod_arpay']."',alum_apater='".$dato['alum_apater']."',
                alum_amater='".$dato['alum_amater']."',alum_nom='".$dato['alum_nom']."',
                fecha_nacimiento='".$dato['fecha_nacimiento']."',sexo='".$dato['sexo']."',
                correo_corporativo='".$dato['correo_corporativo']."',
                direccion='".$dato['direccion']."',
                id_departamento='".$dato['id_departamento']."',
                id_provincia='".$dato['id_provincia']."',
                id_distrito='".$dato['id_distrito']."',titular1_dni='".$dato['titular1_dni']."',
                titular1_parentesco='".$dato['titular1_parentesco']."',
                titular1_apater='".$dato['titular1_apater']."',
                titular1_amater='".$dato['titular1_amater']."',
                titular1_nom='".$dato['titular1_nom']."',
                titular1_celular='".$dato['titular1_celular']."',
                titular1_direccion='".$dato['titular1_direccion']."',
                titular1_departamento='".$dato['titular1_departamento']."',
                titular1_provincia='".$dato['titular1_provincia']."',
                titular1_distrito='".$dato['titular1_distrito']."',
                titular1_telf_casa='".$dato['titular1_telf_casa']."',
                titular1_correo='".$dato['titular1_correo']."',
                titular1_fecha_nacimiento='".$dato['titular1_fecha_nacimiento']."',
                titular1_ocupacion='".$dato['titular1_ocupacion']."',
                titular1_centro_labor='".$dato['titular1_centro_labor']."',
                titular1_nombre_sunat='".$dato['titular1_nombre_sunat']."',
                titular1_correo_boleta='".$dato['titular1_correo_boleta']."',
                titular1_no_mailing='".$dato['titular1_no_mailing']."',
                titular2_dni='".$dato['titular2_dni']."',
                titular2_parentesco='".$dato['titular2_parentesco']."',
                titular2_apater='".$dato['titular2_apater']."',
                titular2_amater='".$dato['titular2_amater']."',
                titular2_nom='".$dato['titular2_nom']."',
                titular2_direccion='".$dato['titular2_direccion']."',
                titular2_departamento='".$dato['titular2_departamento']."',
                titular2_provincia='".$dato['titular2_provincia']."',
                titular2_distrito='".$dato['titular2_distrito']."',
                titular2_celular='".$dato['titular2_celular']."',
                titular2_telf_casa='".$dato['titular2_telf_casa']."',
                titular2_correo='".$dato['titular2_correo']."',
                titular2_fecha_nacimiento='".$dato['titular2_fecha_nacimiento']."',
                titular2_ocupacion='".$dato['titular2_ocupacion']."',
                titular2_centro_labor='".$dato['titular2_centro_labor']."',
                titular2_nombre_sunat='".$dato['titular2_nombre_sunat']."',
                titular2_correo_boleta='".$dato['titular2_correo_boleta']."',
                titular2_no_mailing='".$dato['titular2_no_mailing']."',
                id_grado='".$dato['id_grado']."',id_seccion='".$dato['id_seccion']."',
                tipo='".$dato['tipo']."',id_medio='".$dato['id_medio']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_alumno='".$dato['id_alumno']."'";
        $this->db->query($sql);
    }

    function delete_alumno($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_alumno='".$dato['id_alumno']."'";
        $this->db->query($sql);
    }

    function get_list_foto_matriculados($id_alumno){ 
        $sql = "SELECT de.id_detalle,SUBSTRING_INDEX(de.archivo,'/',-1) AS nom_archivo,de.archivo
                FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=3 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND 
                de.archivo!='' AND de.estado=2
                ORDER BY de.anio DESC,de.id_detalle DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_motivo($id_motivo=null){ 
        if(isset($id_motivo) && $id_motivo>0){
            $sql = "SELECT * FROM motivo_retiro 
                    WHERE id_motivo=$id_motivo";
        }else{
            $sql = "SELECT * FROM motivo_retiro 
                    WHERE estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_alumno_retirado($id_alumno){ 
        $sql = "SELECT a.*,u.usuario_codigo,DATE_FORMAT(a.fec_reg,'%d/%m/%Y %H:%i %p') as fecha_actualizacion
                FROM alumno_retirado a 
                LEFT JOIN users u on a.user_reg=u.id_usuario
                WHERE a.id_empresa=3 AND a.Id='$id_alumno'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_retiro_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_retirado (id_empresa,Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,
                fecha_nasiste,id_motivo,otro_motivo,fut,fecha_fut,tkt_boleta,pago_pendiente,monto,contacto,
                fecha_contacto,hora_contacto,resumen,p_reincorporacion,obs_retiro,estado,fec_reg,user_reg)
                SELECT 3,id_alumno,alum_apater,alum_amater,alum_nom,cod_alum,'".$dato['fecha_nasiste']."',
                '".$dato['id_motivo']."','".$dato['otro_motivo']."','".$dato['fut']."','".$dato['fecha_fut']."',
                '".$dato['tkt_boleta']."','".$dato['pago_pendiente']."','".$dato['monto']."','".$dato['contacto']."',
                '".$dato['fecha_contacto']."','".$dato['hora_contacto']."','".$dato['resumen']."',
                '".$dato['p_reincorporacion']."','".$dato['obs_retiro']."',2,NOW(),$id_usuario 
                FROM alumno 
                WHERE id_alumno='".$dato['id_alumno']."' ";
        $this->db->query($sql);
    }

    function update_retiro_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_retirado SET fecha_nasiste='".$dato['fecha_nasiste']."',
                id_motivo='".$dato['id_motivo']."',otro_motivo='".$dato['otro_motivo']."',fut='".$dato['fut']."',
                fecha_fut='".$dato['fecha_fut']."',tkt_boleta='".$dato['tkt_boleta']."',
                pago_pendiente='".$dato['pago_pendiente']."',monto='".$dato['monto']."',contacto='".$dato['contacto']."',
                fecha_contacto='".$dato['fecha_contacto']."',hora_contacto='".$dato['hora_contacto']."',
                resumen='".$dato['resumen']."',p_reincorporacion='".$dato['p_reincorporacion']."',
                obs_retiro='".$dato['obs_retiro']."',aprobado=0,fec_act=NOW(),user_act=$id_usuario
                WHERE Id='".$dato['id_alumno']."' AND estado=2";
        $this->db->query($sql);
    }

    function get_list_alumno_retirado($id_alumno_retirado=null){  
        if(isset($id_alumno_retirado) && $id_alumno_retirado>0){
            $sql = "SELECT id_alumno_retirado,obs_retiro,Codigo
                    FROM alumno_retirado a 
                    WHERE id_alumno_retirado=$id_alumno_retirado";
        }else{
            $sql = "SELECT * FROM alumno_retirado 
                    WHERE id_empresa=2 AND estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_obs_motivo_retiro($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_retirado SET obs_retiro='".$dato['obs_retiro']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_alumno_retirado='".$dato['id_alumno_retirado']."'";
        $this->db->query($sql);
    }
    //-----------------------------------GRADO-------------------------------------
    function get_list_grado($id_grado=null){
        if(isset($id_grado) && $id_grado>0){
            $sql = "SELECT * FROM grado_bl WHERE id_grado=$id_grado";
        }else{
            $sql = "SELECT g.*,s.nom_status FROM grado_bl g
                    LEFT JOIN status s ON g.estado=s.id_status
                    WHERE g.estado NOT IN (4)";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grado_combo(){
        $sql = "SELECT id_grado,nom_grado FROM grado_bl 
                WHERE estado=2
                ORDER BY nom_grado ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_grado($dato){
        $sql = "SELECT id_grado FROM grado_bl WHERE nom_grado='".$dato['nom_grado']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_grado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO grado_bl (nom_grado,estado,fec_reg,user_reg) 
                VALUES ('".$dato['nom_grado']."','".$dato['estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_grado($dato){
        $sql = "SELECT id_grado FROM grado_bl WHERE id_grado!='".$dato['id_grado']."' AND nom_grado='".$dato['nom_grado']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_grado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grado_bl SET nom_grado='".$dato['nom_grado']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_grado='". $dato['id_grado']."'";
        $this->db->query($sql);
    }

    function delete_grado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grado_bl SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_grado='".$dato['id_grado']."'";
        $this->db->query($sql);
    }
    //-----------------------------------SECCIÓN-------------------------------------
    function get_list_seccion($id_seccion=null){
        if(isset($id_seccion) && $id_seccion>0){
            $sql = "SELECT * FROM seccion WHERE id_seccion=$id_seccion";
        }else{
            $sql = "SELECT se.*,gr.nom_grado,st.nom_status FROM seccion se
                    LEFT JOIN grado_bl gr ON gr.id_grado=se.id_grado
                    LEFT JOIN status st ON st.id_status=se.estado
                    WHERE se.estado NOT IN (4)";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_seccion_combo($id_grado){
        $sql = "SELECT id_seccion,nom_seccion 
                FROM seccion 
                WHERE estado=2 AND id_grado=$id_grado
                ORDER BY nom_seccion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_seccion($dato){
        $sql = "SELECT id_seccion FROM seccion WHERE id_grado='".$dato['id_grado']."' AND nom_seccion='".$dato['nom_seccion']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_seccion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO seccion (id_grado,nom_seccion,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_grado']."','".$dato['nom_seccion']."','".$dato['estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_seccion($dato){
        $sql = "SELECT id_seccion FROM seccion WHERE id_seccion!='".$dato['id_seccion']."' AND id_grado='".$dato['id_grado']."' AND 
                nom_seccion='".$dato['nom_seccion']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_seccion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE seccion SET id_grado='".$dato['id_grado']."',nom_seccion='".$dato['nom_seccion']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_seccion='". $dato['id_seccion']."'";
        $this->db->query($sql);
    }

    function delete_seccion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE seccion SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_seccion='".$dato['id_seccion']."'";
        $this->db->query($sql);
    }
    //-----------------------------------------------DOCUMENTO------------------------------------------
    function get_list_documento($id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_alumno_empresa 
                    WHERE id_documento=$id_documento";
        }else{
            $sql = "SELECT do.*,CASE WHEN do.obligatorio=0 THEN 'No' 
                    WHEN do.obligatorio=1 THEN 'Si'
                    WHEN do.obligatorio=2 THEN 'Mayores de 4 (>4)' 
                    WHEN do.obligatorio=3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,
                    CASE WHEN do.nom_grado=0 THEN 'Todos' ELSE gr.nom_grado END AS nom_grado,
                    st.nom_status,CASE WHEN do.validacion=1 THEN 'Si' ELSE 'No' END AS validacion
                    FROM documento_alumno_empresa do
                    LEFT JOIN grado_bl gr ON gr.id_grado=do.nom_grado
                    LEFT JOIN status st ON st.id_status=do.estado
                    WHERE do.id_empresa=3 AND do.estado!=4
                    ORDER BY do.nom_documento ASC,do.descripcion_documento ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_documento_combo($id_grado){
        $sql = "SELECT id_documento,CONCAT(nom_documento,' - ',descripcion_documento) AS nom_documento 
                FROM documento_alumno_empresa
                WHERE id_empresa=3 AND nom_grado IN (0,$id_grado) AND estado=2
                ORDER BY nom_documento ASC,descripcion_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_documento($dato){
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=3 AND cod_documento='".$dato['cod_documento']."' AND estado=2"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_alumno_empresa (id_empresa,cod_documento,nom_grado,nom_documento,
                descripcion_documento,obligatorio,digital,aplicar_todos,validacion,estado,fec_reg,user_reg) 
                VALUES (3,'".$dato['cod_documento']."','".$dato['id_grado']."','".$dato['nom_documento']."',
                '".$dato['descripcion_documento']."','".$dato['obligatorio']."','".$dato['digital']."',
                '".$dato['aplicar_todos']."','".$dato['validacion']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_documento(){
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                WHERE id_empresa=3 ORDER BY id_documento DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_update_documento($dato){
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=3 AND cod_documento='".$dato['cod_documento']."' AND estado=2 AND 
                id_documento!='".$dato['id_documento']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET cod_documento='".$dato['cod_documento']."',
                nom_grado='".$dato['id_grado']."',nom_documento='".$dato['nom_documento']."',
                descripcion_documento='".$dato['descripcion_documento']."',
                obligatorio='".$dato['obligatorio']."',digital='".$dato['digital']."',
                aplicar_todos='".$dato['aplicar_todos']."',validacion='".$dato['validacion']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }

    function delete_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
 
    function valida_insert_documento_todos($dato){
        $sql = "SELECT * FROM detalle_alumno_empresa 
                WHERE id_alumno='".$dato['id_alumno']."' AND
                id_documento='".$dato['id_documento']."' AND id_empresa=3 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_todos($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,anio,
                estado,fec_reg,user_reg)
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."',3,
                '".$dato['anio']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    //-----------------------------------MATRÍCULA-------------------------------------
    function get_list_matricula($parametro){
        if($parametro==1){
            $sql = "SELECT al.*,de.nombre_departamento,pr.nombre_provincia,DATE_FORMAT(al.fec_reg,'%d/%m/%Y') AS fecha_registro,
                    gr.nom_grado,es.nom_estadoa
                    FROM alumno al
                    LEFT JOIn grado_bl gr ON gr.id_grado=al.id_grado
                    LEFT JOIN departamento de ON de.id_departamento=al.id_departamento
                    LEFT JOIN provincia pr ON pr.id_provincia=al.id_provincia
                    LEFT JOIN estadoa es ON es.id_estadoa=al.estado_alumno
                    WHERE al.id_sede=6 AND al.estado_alumno=2 AND al.estado=2";
        }else{
            $sql = "SELECT al.*,de.nombre_departamento,pr.nombre_provincia,DATE_FORMAT(al.fec_reg,'%d/%m/%Y') AS fecha_registro,
                    gr.nom_grado,es.nom_estadoa
                    FROM alumno al
                    LEFT JOIn grado_bl gr ON gr.id_grado=al.id_grado
                    LEFT JOIN departamento de ON de.id_departamento=al.id_departamento
                    LEFT JOIN provincia pr ON pr.id_provincia=al.id_provincia
                    LEFT JOIN estadoa es ON es.id_estadoa=al.estado_alumno
                    WHERE al.id_sede=6 AND al.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_parentesco(){
        $sql = "SELECT * FROM parentesco ORDER BY nom_parentesco ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_medios(){
        $sql = "SELECT * FROM medios_sociales ORDER BY nom_medio ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function busca_provincia($id_departamento){ 
        $sql = "SELECT * FROM provincia WHERE estado=2 AND id_departamento='$id_departamento' ORDER BY nombre_provincia ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function busca_distrito($id_departamento,$id_provincia){ 
        $sql = "SELECT * FROM distrito WHERE estado=2 AND id_departamento='$id_departamento' AND id_provincia='$id_provincia'
                ORDER BY nombre_distrito ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function validar_temporal_datos_alumno(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT id_temporal FROM temporal_datos_alumno_bl WHERE id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_datos_alumno(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT ta.*,de.nombre_departamento AS dep_alum,pr.nombre_provincia AS pro_alum,di.nombre_distrito AS dis_alum,
                DATE_FORMAT(ta.fec_nac_alum,'%d/%m/%Y') AS fecha_nacimiento,pa.nom_parentesco,
                CONCAT(ta.nombres_prin,' ',ta.apater_prin,' ',ta.amater_prin) AS nom_principal,dip.nombre_distrito AS dis_prin,
                CASE WHEN ta.id_sexo_alum=1 THEN 'Femenino' WHEN ta.id_sexo_alum=2 THEN 'Masculino' ELSE '' END AS nom_sexo,
                CONCAT(ta.nombres_suc,' ',ta.apater_suc,' ',ta.amater_suc) AS nom_principal_secu,
                ps.nom_parentesco AS nom_parentesco_secu,ds.nombre_distrito AS dis_secu
                FROM temporal_datos_alumno_bl ta
                LEFT JOIN departamento de ON de.id_departamento=ta.id_departamento_alum
                LEFT JOIN provincia pr ON pr.id_provincia=ta.id_provincia_alum
                LEFT JOIN distrito di ON di.id_distrito=ta.id_distrito_alum
                LEFT JOIN parentesco pa ON pa.id_parentesco=ta.parentesco_prin
                LEFT JOIN distrito dip ON dip.id_distrito=ta.id_distrito_prin
                LEFT JOIN parentesco ps ON ps.id_parentesco=ta.parentesco_secu
                LEFT JOIN distrito ds ON ds.id_distrito=ta.id_distrito_secu 
                WHERE ta.id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_datos_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_alumno_bl (id_usuario,id_tipo_documento_alum,n_doc_alum,fec_nac_alum,
                id_sexo_alum,apater_alum,amater_alum,nombres_alum,direccion_alum,id_departamento_alum,id_provincia_alum,
                id_distrito_alum,correo_corporativo_alum) 
                VALUES ($id_usuario,'".$dato['id_tipo_documento_alum']."','".$dato['n_doc_alum']."',
                '".$dato['fec_nac_alum']."','".$dato['id_sexo_alum']."',
                '".$dato['apater_alum']."','".$dato['amater_alum']."','".$dato['nombres_alum']."',
                '".$dato['direccion_alum']."','".$dato['id_departamento_alum']."',
                '".$dato['id_provincia_alum']."','".$dato['id_distrito_alum']."','".$dato['correo_corporativo_alum']."')"; 
        $this->db->query($sql);
    }

    function update_datos_alumno($dato){
        $sql = "UPDATE temporal_datos_alumno_bl SET id_tipo_documento_alum='".$dato['id_tipo_documento_alum']."',
                n_doc_alum='".$dato['n_doc_alum']."',fec_nac_alum='".$dato['fec_nac_alum']."',
                id_sexo_alum='".$dato['id_sexo_alum']."',apater_alum='".$dato['apater_alum']."',
                amater_alum='".$dato['amater_alum']."',nombres_alum='".$dato['nombres_alum']."',
                direccion_alum='".$dato['direccion_alum']."',id_departamento_alum='".$dato['id_departamento_alum']."',
                id_provincia_alum='".$dato['id_provincia_alum']."',id_distrito_alum='".$dato['id_distrito_alum']."',
                correo_corporativo_alum='".$dato['correo_corporativo_alum']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function insert_datos_tutor($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_alumno_bl (id_usuario,id_tipo_documento_prin,n_doc_prin,fec_nac_prin,parentesco_prin,
                apater_prin,amater_prin,nombres_prin,vive_alumno_prin,direccion_prin,id_departamento_prin,id_provincia_prin,
                id_distrito_prin,celular_prin,telf_casa_prin,correo_personal_prin,ocupacion_prin,centro_empleo_prin,
                id_tipo_documento_secu,n_doc_secu,fec_nac_secu,parentesco_secu,apater_secu,amater_secu,nombres_secu,
                vive_alumno_secu,direccion_secu,id_departamento_secu,id_provincia_secu,id_distrito_secu,celular_secu,
                telf_casa_secu,correo_personal_secu,ocupacion_secu,centro_empleo_secu) 
                VALUES ($id_usuario,'".$dato['id_tipo_documento_prin']."','".$dato['n_doc_prin']."','".$dato['fec_nac_prin']."',
                '".$dato['parentesco_prin']."','".$dato['apater_prin']."','".$dato['amater_prin']."','".$dato['nombres_prin']."',
                '".$dato['vive_alumno_prin']."','".$dato['direccion_prin']."','".$dato['id_departamento_prin']."',
                '".$dato['id_provincia_prin']."','".$dato['id_distrito_prin']."','".$dato['celular_prin']."',
                '".$dato['telf_casa_prin']."','".$dato['correo_personal_prin']."','".$dato['ocupacion_prin']."',
                '".$dato['centro_empleo_prin']."','".$dato['id_tipo_documento_secu']."',
                '".$dato['n_doc_secu']."','".$dato['fec_nac_secu']."','".$dato['parentesco_secu']."','".$dato['apater_secu']."',
                '".$dato['amater_secu']."','".$dato['nombres_secu']."','".$dato['vive_alumno_secu']."','".$dato['direccion_secu']."',
                '".$dato['id_departamento_secu']."','".$dato['id_provincia_secu']."','".$dato['id_distrito_secu']."',
                '".$dato['celular_secu']."','".$dato['telf_casa_secu']."','".$dato['correo_personal_secu']."',
                '".$dato['ocupacion_secu']."','".$dato['centro_empleo_secu']."')"; 
        $this->db->query($sql);
    }

    function update_datos_tutor($dato){
        $sql = "UPDATE temporal_datos_alumno_bl SET id_tipo_documento_prin='".$dato['id_tipo_documento_prin']."',
                n_doc_prin='".$dato['n_doc_prin']."',fec_nac_prin='".$dato['fec_nac_prin']."',
                parentesco_prin='".$dato['parentesco_prin']."',apater_prin='".$dato['apater_prin']."',
                amater_prin='".$dato['amater_prin']."',nombres_prin='".$dato['nombres_prin']."',
                vive_alumno_prin='".$dato['vive_alumno_prin']."',direccion_prin='".$dato['direccion_prin']."',
                id_departamento_prin='".$dato['id_departamento_prin']."',id_provincia_prin='".$dato['id_provincia_prin']."',
                id_distrito_prin='".$dato['id_distrito_prin']."',celular_prin='".$dato['celular_prin']."',
                telf_casa_prin='".$dato['telf_casa_prin']."',correo_personal_prin='".$dato['correo_personal_prin']."',
                ocupacion_prin='".$dato['ocupacion_prin']."',centro_empleo_prin='".$dato['centro_empleo_prin']."',
                id_tipo_documento_secu='".$dato['id_tipo_documento_secu']."',
                n_doc_secu='".$dato['n_doc_secu']."',fec_nac_secu='".$dato['fec_nac_secu']."',
                parentesco_secu='".$dato['parentesco_secu']."',apater_secu='".$dato['apater_secu']."',
                amater_secu='".$dato['amater_secu']."',nombres_secu='".$dato['nombres_secu']."',
                vive_alumno_secu='".$dato['vive_alumno_secu']."',direccion_secu='".$dato['direccion_secu']."',
                id_departamento_secu='".$dato['id_departamento_secu']."',id_provincia_secu='".$dato['id_provincia_secu']."',
                id_distrito_secu='".$dato['id_distrito_secu']."',celular_secu='".$dato['celular_secu']."',
                telf_casa_secu='".$dato['telf_casa_secu']."',correo_personal_secu='".$dato['correo_personal_secu']."',
                ocupacion_secu='".$dato['ocupacion_secu']."',centro_empleo_secu='".$dato['centro_empleo_secu']."'
                WHERE id_temporal='".$dato['id_temporal']."'"; 
        $this->db->query($sql);
    }

    function insert_datos_informacion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_alumno_bl (id_usuario,donde_conocio) 
                VALUES ($id_usuario,'".$dato['donde_conocio']."')"; 
        $this->db->query($sql);
    }

    function update_datos_informacion($dato){
        $sql = "UPDATE temporal_datos_alumno_bl SET donde_conocio='".$dato['donde_conocio']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function get_id_datos_documento(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM temporal_datos_documento_bl WHERE id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_datos_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_documento_bl (id_usuario,id_documento,archivo) 
                VALUES ($id_usuario,'".$dato['id_documento']."','".$dato['archivo']."')"; 
        $this->db->query($sql);
    }

    function valida_insert_datos_documento($id_documento){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM temporal_datos_documento_bl WHERE id_usuario=$id_usuario AND id_documento=$id_documento"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_datos_documento($id_documento){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM temporal_datos_documento_bl WHERE id_usuario=$id_usuario AND id_documento=$id_documento";
        $this->db->query($sql);
    }

    function validar_temporal_datos_matricula(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT id_temporal FROM temporal_datos_matricula_bl WHERE id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_datos_matricula(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT tm.*,gr.nom_grado FROM temporal_datos_matricula_bl tm
                LEFT JOIN grado_bl gr ON gr.id_grado=tm.id_grado
                WHERE tm.id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_datos_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_matricula_bl (id_usuario,id_grado,id_producto,fec_matricula,observaciones) 
                VALUES ($id_usuario,'".$dato['id_grado']."','".$dato['id_producto']."','".$dato['fec_matricula']."',
                '".$dato['observaciones']."')"; 
        $this->db->query($sql);
    }

    function update_datos_matricula($dato){
        $sql = "UPDATE temporal_datos_matricula_bl SET id_grado='".$dato['id_grado']."',id_producto='".$dato['id_producto']."',
                fec_matricula='".$dato['fec_matricula']."',observaciones='".$dato['observaciones']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function insert_datos_confirmacion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_matricula_bl (id_usuario,codigo_confirmacion,hoja_matricula,contrato,reglamento_interno,forma_pago,cero_efectivo,contacto) 
                VALUES ($id_usuario,'".$dato['codigo_confirmacion']."','".$dato['hoja_matricula']."','".$dato['contrato']."',
                '".$dato['reglamento_interno']."','".$dato['forma_pago']."','".$dato['cero_efectivo']."','".$dato['contacto']."')"; 
        $this->db->query($sql);
    }

    function update_datos_confirmacion($dato){
        $sql = "UPDATE temporal_datos_matricula_bl SET codigo_confirmacion='".$dato['codigo_confirmacion']."',hoja_matricula='".$dato['hoja_matricula']."',
                contrato='".$dato['contrato']."',reglamento_interno='".$dato['reglamento_interno']."',
                forma_pago='".$dato['forma_pago']."',cero_efectivo='".$dato['cero_efectivo']."',contacto='".$dato['contacto']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function insert_alumno_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno (id_sede,cod_alum,tipo_documento,n_documento,fecha_nacimiento,
                sexo,alum_apater,alum_amater,alum_nom,direccion,id_departamento,id_provincia,
                id_distrito,correo_corporativo,titular1_tipo_documento,titular1_dni,titular1_fec_nac,
                titular1_parentesco,titular1_apater,titular1_amater,titular1_nom,titular1_vive,titular1_direccion,
                titular1_departamento,titular1_provincia,titular1_distrito,titular1_celular,titular1_telf_casa,
                titular1_correo,titular1_ocupacion,titular1_centro_labor,titular2_tipo_documento,
                titular2_dni,titular2_fec_nac,titular2_parentesco,titular2_apater,titular2_amater,titular2_nom,
                titular2_vive,titular2_direccion,titular2_departamento,titular2_provincia,titular2_distrito,
                titular2_celular,titular2_telf_casa,titular2_correo,titular2_ocupacion,titular2_centro_labor,
                id_medio,estado_alumno,id_grado,estado,fec_reg,user_reg) 
                SELECT 6,'".$dato['cod_alum']."',id_tipo_documento_alum,n_doc_alum,fec_nac_alum,
                id_sexo_alum,apater_alum,amater_alum,nombres_alum,direccion_alum,id_departamento_alum,
                id_provincia_alum,id_distrito_alum,correo_corporativo_alum,id_tipo_documento_prin,n_doc_prin,
                fec_nac_prin,parentesco_prin,apater_prin,amater_prin,nombres_prin,vive_alumno_prin,direccion_prin,
                id_departamento_prin,id_provincia_prin,id_distrito_prin,celular_prin,telf_casa_prin,
                correo_personal_prin,ocupacion_prin,centro_empleo_prin,id_tipo_documento_secu,n_doc_secu,fec_nac_secu,
                parentesco_secu,apater_secu,amater_secu,nombres_secu,vive_alumno_secu,direccion_secu,id_departamento_secu,
                id_provincia_secu,id_distrito_secu,celular_secu,telf_casa_secu,correo_personal_secu,ocupacion_secu,
                centro_empleo_secu,donde_conocio,1,(SELECT id_grado FROM temporal_datos_matricula_bl WHERE id_usuario=$id_usuario),2,NOW(),
                $id_usuario 
                FROM temporal_datos_alumno_bl
                WHERE id_usuario=$id_usuario"; 
        $this->db->query($sql);
    }

    function ultimo_id_alumno(){
        $sql = "SELECT id_alumno FROM alumno WHERE id_sede=6 ORDER BY id_alumno DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function insert_documento_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,archivo,user_subido,fec_subido,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."','".$dato['archivo']."',$id_usuario,NOW(),2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }*/

    function ultimo_id_matricula(){
        $sql = "SELECT ma.id_matricula,ma.id_grado,ma.fec_matricula,pr.id_articulo
                FROM matricula_alumno_bl ma
                LEFT JOIN producto_articulo pr ON pr.id_producto=ma.id_producto
                ORDER BY ma.id_matricula DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_matricula_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO matricula_alumno_bl (id_alumno,id_grado,id_producto,fec_matricula,observaciones,
                codigo_confirmacion,hoja_matricula,contrato,reglamento_interno,forma_pago,cero_efectivo,
                contacto,estado_matricula,estado,fec_reg,user_reg) 
                SELECT '".$dato['id_alumno']."',id_grado,id_producto,fec_matricula,observaciones,
                codigo_confirmacion,'".$dato['hoja_matricula']."','".$dato['contrato']."',reglamento_interno,
                forma_pago,cero_efectivo,contacto,11,2,NOW(),$id_usuario
                FROM temporal_datos_matricula_bl
                WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function delete_temporales(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM temporal_datos_alumno_bl WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
        $sql2 = "DELETE FROM temporal_datos_documento_bl WHERE id_usuario=$id_usuario";
        $this->db->query($sql2);
        $sql3 = "DELETE FROM temporal_datos_matricula_bl WHERE id_usuario=$id_usuario";
        $this->db->query($sql3);
    }

    function get_list_mes_matricula($fec_matricula){
        $sql = "SELECT id_mes,cod_mes,nom_mes FROM mes 
                WHERE estado=1 AND MONTH('$fec_matricula')<=cod_mes 
                ORDER BY id_mes ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_pago_matricula_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO pago_matricula_alumno_bl (id_matricula,orden,nom_pago,monto,
                fec_vencimiento,estado_pago,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_matricula']."','".$dato['orden']."',
                '".$dato['nom_pago']."','".$dato['monto']."','".$dato['fec_vencimiento']."',
                1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_matricula_alumno($id_alumno){     
        $sql = "SELECT ma.id_matricula,pr.nombre AS nom_producto,pr.id_articulo,pr.anio,
                CASE WHEN ma.fec_matricula IS NULL OR ma.fec_matricula='0000-00-00' THEN ''
                ELSE DATE_FORMAT(ma.fec_matricula,'%d/%m/%Y') END AS fecha_matricula,
                CASE WHEN ma.fin_matricula IS NULL OR ma.fin_matricula='0000-00-00' THEN ''
                ELSE DATE_FORMAT(ma.fin_matricula,'%d/%m/%Y') END AS fin_matricula,
                us.usuario_codigo,ma.observaciones,
                gr.nom_grado,
                CASE WHEN (SELECT COUNT(1) FROM pago_matricula_alumno_bl pa 
                WHERE pa.id_matricula=ma.id_matricula AND pa.estado_pago=2 AND 
                pa.estado=2)=(SELECT COUNT(1) FROM pago_matricula_alumno_bl pm 
                WHERE pm.id_matricula=ma.id_matricula AND pm.estado_pago NOT IN (3) AND 
                pm.estado=2) THEN 'Completado' ELSE 'Por Completar' END AS estado_pago_matricula,
                CASE WHEN ma.compra=0 THEN es.nom_estado ELSE '' END AS nom_estado,
                DATE_FORMAT(ma.fec_reg,'%d/%m/%Y') AS fecha_registro,cu.nom_curso
                FROM matricula_alumno_bl ma
                LEFT JOIN producto_articulo pr ON pr.id_producto=ma.id_producto
                LEFT JOIN users us ON us.id_usuario=ma.user_reg
                LEFT JOIN grado_bl gr ON gr.id_grado=ma.id_grado
                LEFT JOIN estado_matricula es ON es.id_estado=ma.estado_matricula
                LEFT JOIN curso_bl cu ON cu.id_curso=ma.id_curso
                WHERE ma.id_alumno=$id_alumno AND ma.estado=2
                ORDER BY ma.id_matricula DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_matricula_alumno($dato){
        $sql = "SELECT id_matricula FROM matricula_alumno_bl 
                WHERE id_alumno='".$dato['id_alumno']."' AND estado_matricula IN (2,3,4,6,11) AND 
                compra=0 AND estado=2
                ORDER BY id_matricula DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_matricula_alumno_detalle($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO matricula_alumno_bl (id_alumno,id_grado,id_producto,fec_matricula,
                compra,observaciones,estado_matricula,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_grado']."','".$dato['id_producto']."',
                '".$dato['fec_matricula']."','".$dato['compra']."','".$dato['observaciones']."',
                2,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    
    function get_list_estado_matricula(){
        $sql = "SELECT * FROM estado_matricula WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_matricula_alumno($dato){ 
        $sql = "SELECT id_matricula FROM matricula_alumno_bl 
                WHERE id_matricula!='".$dato['id_matricula']."' AND id_alumno='".$dato['id_alumno']."' AND 
                compra=0 AND estado_matricula IN (2,3,4,6,11) AND estado=2
                ORDER BY id_matricula DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_pago_alumno_retirado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_matricula_alumno_bl SET estado_pago=3
                WHERE id_matricula='".$dato['id_matricula']."' AND estado_pago=1 AND 
                orden>MONTH('".$dato['fin_matricula']."')";
        $this->db->query($sql);
    }

    function update_matricula_alumno_detalle($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE matricula_alumno_bl SET id_grado='".$dato['id_grado']."',id_producto='".$dato['id_producto']."',
                fec_matricula='".$dato['fec_matricula']."',fin_matricula='".$dato['fin_matricula']."',
                observaciones='".$dato['observaciones']."',estado_matricula='".$dato['estado_matricula']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_matricula='".$dato['id_matricula']."'";
        $this->db->query($sql);
    }

    function delete_matricula_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE matricula_alumno_bl SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_matricula='".$dato['id_matricula']."'";
        $this->db->query($sql);
    }

    function get_list_pago_matricula_alumno($id_alumno){  
        $sql = "SELECT pa.id_pago,pa.id_matricula,pa.nom_pago,pa.monto,pa.descuento,
                (pa.monto-pa.descuento) AS sub_total,(pa.monto-pa.descuento+pa.penalidad) AS total,
                CASE WHEN pa.fec_pago='0000-00-00' THEN '' ELSE 
                DATE_FORMAT(pa.fec_pago,'%d/%m/%Y') END AS fec_pago,
                pa.estado_pago,es.nom_estadop,us.usuario_codigo AS creado_por,
                CASE WHEN pa.fec_vencimiento='0000-00-00' THEN '' ELSE
                DATE_FORMAT(pa.fec_vencimiento,'%d/%m/%Y') END AS fec_vencimiento,
                CASE WHEN pa.estado_pago=1 AND pa.fec_vencimiento<=CURDATE() THEN '#E0ECF4' 
                WHEN pa.estado_pago=1 THEN '#FFECDC' WHEN pa.estado_pago=2 THEN '#F0F4DC' 
                ELSE '#FFF' END AS color_fondo,
                CASE WHEN pa.id_tipo_pago=1 THEN 'Efectivo' WHEN pa.id_tipo_pago=2 THEN 'Recaudo' 
                WHEN pa.id_tipo_pago=3 THEN 'Transferencia' ELSE '' END AS nom_tipo_pago,
                pa.operacion,(SELECT dp.cod_documento FROM documento_pago_alumno_bl dp 
                WHERE dp.id_pago=pa.id_pago AND dp.tipo=1 AND dp.estado=2
                ORDER BY dp.id_documento DESC
                LIMIT 1) AS recibo,
                CASE WHEN pa.tipo_boleta=1 THEN (SELECT dp.cod_documento FROM documento_pago_alumno_bl dp 
                WHERE dp.id_pago=pa.id_pago AND dp.tipo=2 AND dp.estado=2
                ORDER BY dp.id_documento DESC
                LIMIT 1) WHEN pa.tipo_boleta=2 THEN 'Manual' ELSE '' END AS boleta,
                (SELECT dp.cod_documento FROM documento_pago_alumno_bl dp 
                WHERE dp.id_pago=pa.id_pago AND dp.tipo=3 AND dp.estado=2
                ORDER BY dp.id_documento DESC
                LIMIT 1) AS nota_debito,
                pa.penalidad,(SELECT dp.cod_documento FROM documento_pago_alumno_bl dp 
                WHERE dp.id_pago=pa.id_pago AND dp.tipo=4 AND dp.estado=2
                ORDER BY dp.id_documento DESC
                LIMIT 1) AS nota_credito,pr.nombre AS nom_producto,pa.tipo_boleta
                FROM pago_matricula_alumno_bl pa
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN estadop es ON es.id_estadop=pa.estado_pago
                LEFT JOIN users us ON us.id_usuario=pa.user_pago
                LEFT JOIN producto_articulo pr ON pr.id_producto=ma.id_producto
                WHERE ma.id_alumno=$id_alumno AND pa.estado=2
                ORDER BY pa.id_matricula DESC,pa.orden ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_matricula_alumno($id_matricula){
        $sql = "SELECT ma.id_matricula,al.cod_alum,al.fecha_nacimiento,gr.nom_grado,al.alum_nom,al.alum_apater,
                al.alum_amater,DATE_FORMAT(al.fecha_nacimiento,'%d/%m/%Y') AS fec_nacimiento,
                CASE WHEN al.sexo=1 THEN 'Femenino' WHEN al.sexo=2 THEN 'Masculino' ELSE ''
                END AS nom_sexo,al.n_documento,da.nombre_distrito AS dis_alum,pa.nom_parentesco,
                CONCAT(al.titular1_nom,' ',al.titular1_apater,' ',al.titular1_amater) AS nom_principal,
                al.titular1_direccion,dp.nombre_distrito AS dis_prin,al.titular1_celular,al.titular1_telf_casa,
                al.titular1_centro_labor,al.titular1_ocupacion,al.titular1_correo,al.correo_corporativo,
                ma.id_alumno,ma.id_grado,ma.id_producto,ma.fec_matricula,ma.fin_matricula,ma.estado_matricula,
                ma.observaciones,al.titular2_dni,pr.nom_parentesco AS parentesco_secu,
                CONCAT(al.titular2_nom,' ',al.titular2_apater,' ',al.titular2_amater) AS nom_principal_secu,
                al.titular2_direccion,ds.nombre_distrito AS dis_secu,al.titular2_telf_casa,al.titular2_celular,
                al.titular2_centro_labor,al.titular2_ocupacion,al.titular2_correo,ma.compra
                FROM matricula_alumno_bl ma  
                LEFT JOIN grado_bl gr ON gr.id_grado=ma.id_grado
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                LEFT JOIN distrito da ON da.id_distrito=al.id_distrito
                LEFT JOIN parentesco pa ON pa.id_parentesco=al.titular1_parentesco
                LEFT JOIN distrito dp ON dp.id_distrito=al.titular1_distrito
                LEFT JOIN parentesco pr ON pr.id_parentesco=al.titular2_parentesco
                LEFT JOIN distrito ds ON ds.id_distrito=al.titular2_distrito
                WHERE ma.id_matricula=$id_matricula";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_pago($id_pago){    
        $sql = "SELECT pa.*,
                DATE_FORMAT(pa.fec_pago,'%Y-%m-%d') AS fec_pago_u,
                DATE_FORMAT(pa.fec_pago,'%d/%m/%Y') AS fecha_pago,
                DATE_FORMAT(pa.fec_pago,'%H:%i') AS hora_pago,ma.id_alumno,
                DATE_FORMAT(pa.fec_reg,'%d/%m/%Y') AS fecha_emision,
                CONCAT(al.alum_apater,' ',al.alum_amater,', ',al.alum_nom) AS nom_alumno,
                CASE WHEN al.titular1_nombre_sunat=1 THEN 
                CONCAT(al.titular1_apater,' ',al.titular1_amater,', ',al.titular1_nom) 
                WHEN titular2_nombre_sunat=1 THEN CONCAT(al.titular2_apater,' ',al.titular2_amater,', ',al.titular2_nom)
                ELSE '' END AS nom_apoderado,CASE WHEN al.titular1_nombre_sunat=1 THEN al.titular1_dni
                WHEN titular2_nombre_sunat=1 THEN al.titular2_dni ELSE '' END AS dni_apoderado,
                al.n_documento,gb.nom_grado,se.nom_seccion,al.cod_alum,al.cod_arpay,
                us.usuario_codigo AS usuario_pago,
                CASE WHEN pa.id_tipo_pago=1 THEN 'Efectivo' WHEN pa.id_tipo_pago=2 THEN 'Recaudo' 
                WHEN pa.id_tipo_pago=3 THEN 'Transferencia' ELSE '' END AS nom_tipo_pago, 
                pa.operacion,pa.recibo,pa.boleta,
                DATE_FORMAT(pa.fec_vencimiento,'%d/%m/%Y') AS fecha_vencimiento,al.n_documento,
                (SELECT dp.cod_documento FROM documento_pago_alumno_bl dp 
                WHERE dp.id_pago=pa.id_pago AND dp.tipo=2 AND dp.estado=2
                ORDER BY dp.id_documento DESC
                LIMIT 1) AS cod_boleta,
                CASE WHEN pa.tipo_boleta=1 THEN 'Boleta Sunat Snappy' 
                WHEN pa.tipo_boleta=2 THEN 'Boleta Sunat Web' ELSE 'Sin boleta' END AS nom_tipo_boleta
                FROM pago_matricula_alumno_bl pa
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                LEFT JOIN grado_bl gb ON gb.id_grado=al.id_grado
                LEFT JOIN seccion se ON se.id_seccion=al.id_seccion
                LEFT JOIN users us ON us.id_usuario=pa.user_pago
                WHERE pa.id_pago=$id_pago";
        $query = $this->db->query($sql)->result_Array();    
        return $query;
    }

    function valida_cierre_caja(){ 
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa
                WHERE id_empresa=3 AND fecha=CURDATE() AND estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function valida_apoderado($id_pago){ 
        $sql = "SELECT al.titular1_nombre_sunat,al.titular2_nombre_sunat 
                FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                WHERE pm.id_pago=$id_pago";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function update_pago($dato){
        /*boleta='".$dato['boleta']."',recibo='".$dato['recibo']."',
                xml='".$dato['xml']."',cdrZip='".$dato['cdrZip']."',
                id='".$dato['id']."',code='".$dato['code']."',
                description='".$dato['description']."',*/
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_matricula_alumno_bl SET monto='".$dato['monto']."',
                descuento='".$dato['descuento']."',estado_pago='".$dato['estado_pago']."',
                fec_vencimiento='".$dato['fec_vencimiento']."',
                fec_pago='".$dato['fec_pago']."',user_pago=$id_usuario,
                id_tipo_pago='".$dato['id_tipo_pago']."',operacion='".$dato['operacion']."',
                tipo_boleta='".$dato['tipo_boleta']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_pago='".$dato['id_pago']."'"; 
        $this->db->query($sql);
    }

    function contar_recibos_cancelados(){ 
        $sql = "SELECT id_documento FROM documento_pago_alumno_bl 
                WHERE tipo=1";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function contar_boletas_canceladas(){ 
        $sql = "SELECT id_documento FROM documento_pago_alumno_bl 
                WHERE tipo=2 AND web=0";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function contar_notas_debito_canceladas(){ 
        $sql = "SELECT id_documento FROM documento_pago_alumno_bl 
                WHERE tipo=3";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function contar_notas_credito_canceladas(){ 
        $sql = "SELECT id_documento FROM documento_pago_alumno_bl 
                WHERE tipo=4";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function insert_documento_pago($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_pago_alumno_bl (id_pago,tipo,cod_documento,xml,
                cdrZip,id,code,description,documento,web,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_pago']."','".$dato['tipo']."','".$dato['cod_documento']."',
                '".$dato['xml']."','".$dato['cdrZip']."','".$dato['id']."','".$dato['code']."',
                '".$dato['description']."','".$dato['documento']."','".$dato['web']."',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function valida_nota_debito($dato){ 
        $sql = "SELECT TIMESTAMPDIFF(DAY,'".$dato['fecha_vencimiento']."','".$dato['fecha_pago']."') AS dias";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function update_pago_penalidad($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_matricula_alumno_bl SET penalidad='".$dato['penalidad']."'
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function update_pago_devolucion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_matricula_alumno_bl SET estado_pago=4
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function delete_pago_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_matricula_alumno_bl SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function get_list_documento_pago_alumno($id_pago){ 
        $sql = "SELECT id_documento,CASE WHEN tipo=1 THEN 'Recibo Electrónico' 
                WHEN tipo=2 THEN 'Boleta' WHEN tipo=3 THEN 'Nota Débito' 
                WHEN tipo=4 THEN 'Nota Crédito' ELSE '' END AS nom_documento,
                cod_documento,DATE_FORMAT(fec_reg,'%d/%m/%Y') AS fecha,
                CASE WHEN tipo=1 THEN 'Recibo_Electronico' 
                WHEN tipo=2 THEN 'Boleta' WHEN tipo=3 THEN 'Nota_Debito' 
                WHEN tipo=4 THEN 'Nota_Credito' ELSE '' END AS url_documento,
                documento
                FROM documento_pago_alumno_bl 
                WHERE id_pago=$id_pago";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_id_documento_pago_alumno($id_documento){ 
        $sql = "SELECT dp.cod_documento,us.usuario_codigo AS usuario_pago,
                DATE_FORMAT(pm.fec_pago,'%d/%m/%Y') AS fecha_pago,
                DATE_FORMAT(pm.fec_pago,'%H:%i') AS hora_pago,al.cod_alum,
                CONCAT(al.alum_apater,' ',al.alum_amater,', ',al.alum_nom) AS nom_alumno,
                CASE WHEN al.titular1_nombre_sunat=1 THEN 
                CONCAT(al.titular1_apater,' ',al.titular1_amater,', ',al.titular1_nom) 
                WHEN titular2_nombre_sunat=1 THEN CONCAT(al.titular2_apater,' ',al.titular2_amater,', ',al.titular2_nom)
                ELSE '' END AS nom_apoderado,pm.nom_pago,pm.monto,pm.descuento,
                DATE_FORMAT(dp.fec_reg,'%d/%m/%Y') AS fecha_emision,
                al.n_documento,CASE WHEN um.nom_grado IS NULL THEN gr.nom_grado 
                ELSE um.nom_grado END AS nom_grado,
                CASE WHEN um.nom_seccion IS NULL THEN se.nom_seccion 
                ELSE um.nom_seccion END AS nom_seccion,al.cod_arpay,pm.operacion,
                CASE WHEN pm.id_tipo_pago=1 THEN 'Efectivo' WHEN pm.id_tipo_pago=2 THEN 'Recaudo' 
                WHEN pm.id_tipo_pago=3 THEN 'Transferencia' ELSE '' END AS nom_tipo_pago,
                DATE_FORMAT(pm.fec_vencimiento,'%d/%m/%Y') AS fecha_vencimiento,
                pm.penalidad,(SELECT da.cod_documento FROM documento_pago_alumno_bl da 
                WHERE da.id_pago=dp.id_pago AND da.tipo=2 AND da.estado=2 
                ORDER BY da.id_documento DESC LIMIT 1) AS documento_modificado,
                SUBSTRING(al.cod_alum,-5) AS cod_interno,dp.documento,
                (pm.monto-pm.descuento)/1.18 AS gravada,
                (pm.monto-pm.descuento)-((pm.monto-pm.descuento)/1.18) AS igv
                FROM documento_pago_alumno_bl dp
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                LEFT JOIN users us ON us.id_usuario=pm.user_pago
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                LEFT JOIN grado_bl gr ON gr.id_grado = al.id_grado 
                LEFT JOIN seccion se ON se.id_seccion = al.id_seccion 
                LEFT JOIN ultima_matricula_bl um ON um.id_alumno=al.id_alumno
                WHERE dp.id_documento=$id_documento";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;  
    }

    function get_list_documento_alumno($id_alumno){
        $sql = "SELECT dd.id_detalle,CASE WHEN da.obligatorio=0 THEN 'No' 
                WHEN da.obligatorio=1 THEN 'Si' WHEN da.obligatorio=2 
                THEN 'Mayores de 4 (>4)' WHEN da.obligatorio=3 
                THEN 'Menores de 18 (<18)' ELSE '' END AS v_obligatorio,
                dd.anio,da.cod_documento,
                CONCAT(da.nom_documento,' - ',da.descripcion_documento) AS 
                nom_documento,dd.archivo,
                CASE WHEN da.cod_documento='D54' THEN 
                (CASE WHEN (SELECT COUNT(*) FROM documento_firma df 
                WHERE df.id_alumno=dd.id_alumno AND df.id_empresa=3 AND 
                df.estado_d=3 AND df.estado=2)>0 THEN 'Firmado' ELSE 'Pendiente' END)
                ELSE SUBSTRING_INDEX(dd.archivo,'/',-1) END AS nom_archivo,
                us.usuario_codigo AS usuario_subido,
                DATE_FORMAT(dd.fec_subido,'%d-%m-%Y') AS fec_subido
                FROM detalle_alumno_empresa dd
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=dd.id_documento
                LEFT JOIN users us ON us.id_usuario=dd.user_subido
                WHERE dd.id_alumno=$id_alumno AND dd.id_empresa=3 AND dd.estado=2
                ORDER BY dd.anio DESC,da.obligatorio DESC,da.cod_documento ASC,
                da.nom_documento ASC,da.descripcion_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_documento_alumno($dato){
        $sql = "SELECT id_detalle FROM detalle_alumno_empresa 
                WHERE id_alumno='".$dato['id_alumno']."' AND id_documento='".$dato['id_documento']."' AND 
                anio='".$dato['anio']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,anio,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."','".$dato['anio']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_detalle_alumno_empresa($id_detalle){
        $sql = "SELECT * FROM detalle_alumno_empresa 
                WHERE id_detalle=$id_detalle";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documento_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_alumno_empresa SET archivo='".$dato['archivo']."',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function delete_documento_alumno($dato){
        $sql = "UPDATE detalle_alumno_empresa SET archivo='',fec_subido=NULL,user_subido=0
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function get_list_contrato_alumno($id_alumno){     
        $sql = "SELECT df.id_documento_firma,SUBSTRING_INDEX(cc.mes_anio,'/',-1) AS anio,
                cc.referencia,cc.descripcion,
                CASE WHEN df.id_apoderado=1 THEN pa.nom_parentesco 
                WHEN df.id_apoderado=2 THEN pb.nom_parentesco ELSE '' END AS Parentesco,
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma,
                CASE WHEN df.vencido=1 THEN 'Si' ELSE 'No' END AS vencido,
                CASE WHEN df.estado_d=1 THEN 'Anulado' WHEN df.estado_d=2 THEN 'Enviado' 
                WHEN df.estado_d=3 THEN 'Firmado' WHEN df.estado_d=4 THEN 'Validado' 
                END AS nom_status,CASE WHEN df.estado_d=1 THEN '#C00000' 
                WHEN df.estado_d=2 THEN '#0070c0' WHEN df.estado_d=3 THEN '#00C000' 
                WHEN df.estado_d=4 THEN '#7F7F7F' END AS color_status,
                df.fecha_firma,df.fecha_envio
                FROM documento_firma df
                LEFT JOIN c_contrato cc ON cc.id_c_contrato=df.id_contrato
                LEFT JOIN alumno al ON al.id_alumno=df.id_alumno
                LEFT JOIN parentesco pa ON pa.id_parentesco=al.titular1_parentesco
                LEFT JOIN parentesco pb ON pb.id_parentesco=al.titular2_parentesco
                WHERE df.id_alumno=$id_alumno AND df.id_empresa=3 AND df.estado=2
                ORDER BY df.fecha_firma DESC,df.fecha_envio DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_contrato_matriculados($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET vencido='".$dato['vencido']."'
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql);
    }

    function get_id_boleta_web($id_pago){ 
        $sql = "SELECT dp.id_documento,dp.id_pago,dp.documento,pm.nom_pago,
                SUBSTRING_INDEX(dp.documento,'/',-1) AS nom_documento 
                FROM documento_pago_alumno_bl dp
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.id_pago=$id_pago AND dp.tipo=2 AND dp.estado=2
                ORDER BY dp.id_documento DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documento_pago($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_pago_alumno_bl SET documento='".$dato['documento']."'
                WHERE id_documento='".$dato['id_documento']."'"; 
        $this->db->query($sql);
    }
    
    function get_list_observacion_alumno($id_alumno=null,$id_observacion=null){
        if(isset($id_observacion) && $id_observacion>0){
            $sql = "SELECT * FROM alumno_observaciones_general 
                    WHERE id_observacion=$id_observacion"; 
        }else{
            $sql = "SELECT ao.id_observacion,DATE_FORMAT(ao.fecha_obs,'%d-%m-%Y') AS fecha,ti.nom_tipo,
                    us.usuario_codigo AS usuario,ao.observacion,ao.fecha_obs AS orden
                    FROM alumno_observaciones_general ao
                    LEFT JOIN tipo_observacion ti ON ti.id_tipo=ao.id_tipo
                    LEFT JOIN users us ON us.id_usuario=ao.usuario_obs
                    WHERE ao.id_alumno=$id_alumno AND ao.id_empresa=3 AND ao.estado=2
                    ORDER BY ao.fecha_obs DESC"; 
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_tipo_obs(){
        $sql = "SELECT * FROM tipo_observacion
                WHERE estado=2 
                ORDER BY nom_tipo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_observacion(){
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users
                WHERE tipo=1 AND id_nivel NOT IN (6,9) AND estado=2
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_alumno($dato){
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=3 AND id_alumno='".$dato['id_alumno']."' AND 
                id_tipo='".$dato['id_tipo']."' AND observacion='".$dato['observacion']."' AND 
                fecha_obs='".$dato['fecha']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_observaciones_general (id_empresa,id_alumno,id_tipo,observacion,
                fecha_obs,usuario_obs,estado,fec_reg,user_reg) 
                VALUES (3,'".$dato['id_alumno']."','".$dato['id_tipo']."','".$dato['observacion']."',
                '".$dato['fecha']."','".$dato['usuario']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_observacion_alumno($dato){
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=3 AND id_alumno='".$dato['id_alumno']."' AND 
                id_tipo='".$dato['id_tipo']."' AND observacion='".$dato['observacion']."' AND 
                fecha_obs='".$dato['fecha']."' AND estado=2 AND 
                id_observacion!='".$dato['id_observacion']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET id_tipo='".$dato['id_tipo']."',
                fecha_obs='".$dato['fecha']."',usuario_obs='".$dato['usuario']."',
                observacion='".$dato['observacion']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }

    function delete_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }
    //-----------------------------------CURSO-------------------------------------
    function get_list_curso($id_curso=null){
        if(isset($id_curso) && $id_curso>0){
            $sql = "SELECT cu.*,gr.nom_grado,an.nom_anio,st.nom_status,
                    DATE_FORMAT(cu.fec_inicio, '%d/%m/%Y') AS fec_inicio,
                    DATE_FORMAT(cu.fec_fin, '%d/%m/%Y') AS fec_fin,
                    DATE_FORMAT(cu.inicio_curso,'%d/%m/%Y') AS inicio_curso,
                    DATE_FORMAT(cu.fin_curso,'%d/%m/%Y') AS fin_curso
                    FROM curso_bl cu
                    LEFT JOIN grado_bl gr ON gr.id_grado=cu.id_grado
                    LEFT JOIN anio an ON an.id_anio=cu.id_anio
                    LEFT JOIN status st ON st.id_status=cu.estado
                    WHERE cu.id_curso=$id_curso";
        }else{
            $sql = "SELECT cu.id_curso,cu.nom_curso,gr.nom_grado,an.nom_anio,
                    DATE_FORMAT(cu.fec_inicio, '%d/%m/%Y') AS fec_inicio,
                    DATE_FORMAT(cu.fec_fin, '%d/%m/%Y') AS fec_fin,
                    DATE_FORMAT(cu.inicio_curso,'%d/%m/%Y') AS inicio_curso,
                    DATE_FORMAT(cu.fin_curso,'%d/%m/%Y') AS fin_curso,cu.grupo,cu.unidad,
                    CASE WHEN cu.turno=1 THEN 'L-M-V' ELSE '' 
                    END AS nom_turno,st.nom_status,st.color
                    FROM curso_bl cu
                    LEFT JOIN grado_bl gr ON gr.id_grado=cu.id_grado
                    LEFT JOIN anio an ON an.id_anio=cu.id_anio
                    LEFT JOIN status st ON st.id_status=cu.estado
                    WHERE cu.estado NOT IN (4)
                    ORDER BY st.nom_status ASC,an.nom_anio DESC,cu.nom_curso ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_curso_combo(){
        $sql = "SELECT c.id_curso,CONCAT(g.nom_grado,' - ',a.nom_anio) AS nom_curso 
                FROM curso_bl c
                LEFT JOIN grado_bl g ON g.id_grado=c.id_grado
                LEFT JOIN anio a ON a.id_anio=c.id_anio
                WHERE c.estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function valida_insert_curso($dato){
        $sql = "SELECT id_curso FROM curso_bl 
                WHERE id_grado='".$dato['id_grado']."' AND id_anio='".$dato['id_anio']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function insert_curso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        //grupo,unidad,turno,
        //'".$dato['grupo']."','".$dato['unidad']."','".$dato['turno']."',
        $sql = "INSERT INTO curso_bl (nom_curso,id_grado,id_anio,id_copiar,fec_inicio,
                fec_fin,inicio_curso,fin_curso,estado,fec_reg,user_reg) 
                VALUES ('".$dato['nom_curso']."','".$dato['id_grado']."','".$dato['id_anio']."',
                '".$dato['id_copiar']."','".$dato['fec_inicio']."','".$dato['fec_fin']."',
                '".$dato['inicio_curso']."','".$dato['fin_curso']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_curso($dato){
        $sql = "SELECT id_curso FROM curso_bl 
                WHERE id_grado='".$dato['id_grado']."' AND id_anio='".$dato['id_anio']."' AND 
                estado=2 AND id_curso!='".$dato['id_curso']."'";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function update_curso($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        //grupo='".$dato['grupo']."',unidad='".$dato['unidad']."',turno='".$dato['turno']."',
        $sql = "UPDATE curso_bl SET nom_curso='".$dato['nom_curso']."',
                id_anio='".$dato['id_anio']."',id_grado='".$dato['id_grado']."',
                fec_inicio='".$dato['fec_inicio']."',fec_fin='".$dato['fec_fin']."',
                inicio_curso='".$dato['inicio_curso']."',fin_curso='".$dato['fin_curso']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                where id_curso='". $dato['id_curso']."'";
        $this->db->query($sql);
    }

    function get_list_seccion_curso($id_curso){ 
        $sql = "SELECT um.id_matricula,al.id_alumno,al.alum_apater,al.alum_amater,
                al.alum_nom,al.cod_alum,um.nom_seccion,um.estado_matricula
                FROM ultima_matricula_bl um
                LEFT JOIN alumno al ON al.id_alumno=um.id_alumno
                WHERE um.id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_asignar_seccion($id_grado){
        $sql = "SELECT um.id_alumno,um.id_matricula,al.alum_apater,al.alum_amater,
                al.alum_nom,al.cod_alum
                FROM ultima_matricula_bl um
                LEFT JOIN alumno al ON al.id_alumno=um.id_alumno
                WHERE um.id_curso=0 AND um.anio=".date('Y')." AND 
                um.estado_matricula NOT IN ('Retirado(a)') AND um.id_grado=$id_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_curso_matricula_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE matricula_alumno_bl SET id_curso='".$dato['id_curso']."',
                id_seccion='".$dato['id_seccion']."'
                WHERE id_matricula='". $dato['id_matricula']."'";
        $this->db->query($sql);
    }

    function delete_asignar_seccion($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE matricula_alumno_bl SET id_curso=0,id_seccion=0
                WHERE id_matricula='". $dato['id_matricula']."'";
        $this->db->query($sql);
    }

    function get_list_requisito_curso($id_curso){
        $sql = "SELECT r.id_requisito,r.desc_requisito,tr.nom_tipo_requisito,s.nom_status,s.color
                FROM requisito_bl r
                LEFT JOIN tipo_requisito tr on r.id_tipo_requisito=tr.id_tipo_requisito
                LEFT JOIN status s on r.estado=s.id_status
                WHERE id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_tipo_requisito(){
        $sql = "SELECT * FROM tipo_requisito";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_requisito($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO requisito_bl (id_curso,id_grado,id_tipo_requisito,desc_requisito,
                estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_curso']."','".$dato['id_grado']."',
                '".$dato['id_tipo_requisito']."','".$dato['desc_requisito']."',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function get_id_requisito($id_requisito){
        if(isset($id_requisito) && $id_requisito > 0){
            $sql = "SELECT * FROM requisito_bl WHERE id_requisito=$id_requisito";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_requisito($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE requisito_bl SET id_tipo_requisito='".$dato['id_tipo_requisito']."',desc_requisito='".$dato['desc_requisito']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario  
                WHERE id_requisito='". $dato['id_requisito']."'";
        $this->db->query($sql);
    }

    function get_list_alumno_curso($id_curso){
        $sql = "SELECT al.cod_alum,al.alum_apater,al.alum_amater,al.alum_nom,ea.nom_estadoa
                FROM alumno_curso_bl ac
                LEFT JOIN alumno al ON al.id_alumno=ac.id_alumno
                LEFT JOIN estadoa ea on ea.id_estadoa=al.estado_alumno
                WHERE ac.id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_alumno_curso($dato){
        $sql = "SELECT * FROM alumno_curso_bl 
                WHERE id_curso='".$dato['id_curso']."' AND id_alumno='".$dato['id_alumno']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_alumno_curso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_curso_bl (id_curso,id_alumno) 
                VALUES ('".$dato['id_curso']."','".$dato['id_alumno']."')";
        $this->db->query($sql);
    }


    /*function valida_cerrar_curso($id_curso){
        $sql = "SELECT c.* FROM alumno_asociar c 
                LEFT JOIN alumnos al ON al.id_alumno=c.id_alumno
                WHERE c.id_curso=$id_curso AND al.estado_alum=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }*/

    function cerrar_curso($id_curso){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE curso_bl SET estado_cierre=1,fec_cierre=NOW(),user_cierre=$id_usuario 
                WHERE id_curso=$id_curso";
        $this->db->query($sql);
    }
    //-----------------------------------EXPORTACIÓN BBVA-------------------------------------
    function get_list_exportacion_bbva($id_exportacion_bbva=null){
        if(isset($id_exportacion_bbva) && $id_exportacion_bbva>0){
            $sql = "SELECT *,DATE_FORMAT(fec_reg,'%d%m%Y') AS fecha_creacion 
                    FROM exportacion_bbva 
                    WHERE id_exportacion=$id_exportacion_bbva";
        }else{
            $sql = "SELECT eb.id_exportacion,CASE WHEN eb.tipo_operacion=1 THEN 'P: Actualización Parcial' 
                    WHEN eb.tipo_operacion=2 THEN 'T: Actualización Total' ELSE '' END AS nom_tipo_operacion,
                    DATE_FORMAT(eb.fec_reg,'%d-%m-%Y %H:%i') AS fecha_creacion,
                    DATE_FORMAT(eb.fec_inicio,'%d-%m-%Y') AS fecha_inicio,
                    DATE_FORMAT(eb.fec_fin,'%d-%m-%Y') AS fecha_fin,us.usuario_codigo,
                    (SELECT COUNT(*) FROM pago_matricula_alumno_bl pm WHERE pm.estado=2 AND pm.estado_pago=1 AND
                    pm.fec_vencimiento BETWEEN eb.fec_inicio AND eb.fec_fin)
                    AS numero_pagos,eb.fec_reg
                    FROM exportacion_bbva eb
                    LEFT JOIN users us ON us.id_usuario=eb.user_reg";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_exportacion_bbva($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO exportacion_bbva (tipo_operacion,fec_inicio,fec_fin,estado,fec_reg,user_reg) 
                VALUES ('".$dato['tipo_operacion']."','".$dato['fec_inicio']."','".$dato['fec_fin']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_archivo_txt($fec_inicio,$fec_fin){
        $sql = "SELECT LEFT(CONCAT('02',al.alum_apater,' ',al.alum_amater,' ',al.alum_nom),32) AS primera_columna,
                CONCAT(al.n_documento,' ',pa.nom_pago) AS segunda_columna,
                CONCAT(DATE_FORMAT(pa.fec_vencimiento,'%Y%m%d'),'20301231000000000000550000000000000550000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000') AS tercera_columna
                FROM pago_matricula_alumno_bl pa
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                WHERE pa.estado=2 AND ma.estado=2 AND pa.estado_pago=1 AND pa.fec_vencimiento BETWEEN '$fec_inicio' AND '$fec_fin'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //---------------------------------------------DOC ALUMNOS-------------------------------------------
    function get_list_todos_alumno(){ 
        $sql = "SELECT al.alum_apater,al.alum_amater,al.alum_nom,al.cod_alum,
                CASE WHEN um.nom_grado IS NULL THEN gr.nom_grado 
                ELSE um.nom_grado END AS nom_grado,
                CASE WHEN um.nom_seccion IS NULL THEN se.nom_seccion 
                ELSE um.nom_seccion END AS nom_seccion,
                um.estado_matricula,
                CASE WHEN um.id_matricula IS NULL THEN 'Registrado' 
                WHEN um.estado_matricula='Retirado(a)' THEN 'Retirado'
                WHEN um.pago_matricula=0 THEN 'Asignado' 
                WHEN um.pago_matricula>0 THEN 'Matriculado'
                ELSE '' END AS estado_alumno,
                um.anio,al.fecha_nacimiento,al.n_documento,
                CASE WHEN um.nom_grado IS NULL THEN documentos_obligatorios_bl(al.id_grado) 
                ELSE documentos_obligatorios_bl(um.id_grado) END AS documentos_obligatorios,
                CASE WHEN um.nom_grado IS NULL THEN documentos_subidos_bl(al.id_grado,al.id_alumno) 
                ELSE documentos_subidos_bl(um.id_grado,al.id_alumno) END AS documentos_subidos,
                CASE WHEN (foto_bl(al.id_alumno))>0 THEN 'Si' ELSE 'No' END AS foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=3 AND da.cod_documento='D00' AND de.id_alumno=al.id_alumno AND 
                de.archivo!='' AND de.estado=2) AS link_foto
                FROM alumno al
                LEFT JOIN ultima_matricula_bl um ON um.id_alumno=al.id_alumno
                LEFT JOIN grado_bl gr ON gr.id_grado=al.id_grado
                LEFT JOIN seccion se ON se.id_seccion=al.id_seccion
                WHERE al.id_sede=6 AND al.estado=2
                ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_doc_alumnos(){ 
        $sql = "SELECT id_documento,cod_documento FROM documento_alumno_empresa
                WHERE id_empresa=3 AND estado!=4
                ORDER BY cod_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_detalle_doc_alumnos($id_alumno,$cod_documento){
        $sql = "SELECT us.usuario_codigo,de.fec_subido 
                FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                LEFT JOIN users us ON us.id_usuario=de.user_subido
                WHERE da.cod_documento='$cod_documento' AND da.id_empresa=3 AND da.estado=2 AND 
                de.id_alumno=$id_alumno AND de.archivo!='' AND de.estado=2
                ORDER BY de.id_detalle DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //---------------------------------------------ALUMNOS OBS-------------------------------------------
    function get_list_alumno_obs(){ 
        $sql = "SELECT al.alum_apater,al.alum_amater,al.alum_nom,al.cod_alum,e.nom_empresa,
                DATE_FORMAT(ao.fec_reg, '%d-%m-%Y') AS fecha_registro,ao.usuario_obs,ao.observacion,
                u.usuario_codigo,ao.id_empresa,gr.nom_grado,se.nom_seccion
                FROM alumno_observaciones_general ao
                LEFT JOIN alumno al ON al.id_alumno=ao.id_alumno
                LEFT JOIN empresa e ON e.id_empresa=ao.id_empresa
                LEFT JOIN users u ON u.id_usuario=ao.user_reg
                LEFT JOIN grado_bl gr ON gr.id_grado=al.id_grado
                LEFT JOIN seccion se ON se.id_seccion=al.id_seccion
                WHERE ao.id_empresa = 3 AND ao.estado = 2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------SOPORTE DOCS------------------------------------------
    function get_list_soporte_doc($id_soporte_doc=null){ 
        if(isset($id_soporte_doc) && $id_soporte_doc>0){
            $sql = "SELECT * FROM soporte_doc WHERE id_soporte_doc=$id_soporte_doc";
        }else{
            $sql = "SELECT so.id_soporte_doc,em.cod_empresa,so.descripcion,SUBSTRING_INDEX(so.documento,'/',-1) AS nom_documento,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',SUBSTRING_INDEX(so.documento,'/',-1)) ELSE '' END AS link,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',so.documento) ELSE '' END AS href,us.usuario_codigo,
                    DATE_FORMAT(so.fec_act,'%d-%m-%Y') AS fecha,CASE WHEN so.documento='' THEN 'No' ELSE 'Si' END AS v_documento,
                    CASE WHEN so.visible=1 THEN 'Si' ELSE 'No' END AS visible,st.nom_status,so.documento
                    FROM soporte_doc so
                    LEFT JOIN empresa em ON em.id_empresa=so.id_empresa
                    LEFT JOIN users us ON us.id_usuario=so.user_act
                    LEFT JOIN status st ON st.id_status=so.estado
                    WHERE so.id_empresa=3 AND so.estado!=4
                    ORDER BY em.cod_empresa ASC,so.descripcion ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_usuario(){
        $sql = "SELECT u.id_usuario,n.nom_nivel,u.id_nivel,u.estado,s.nom_status,
                DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i') AS ultimo_ingreso,u.usuario_codigo,u.codigo,
                u.usuario_apater,u.usuario_amater,u.usuario_nombres,u.codigo_gllg,u.ini_funciones,u.fin_funciones,
                h.fec_ingreso AS ultimo_ingreso_excel,
                DATE_FORMAT(u.ini_funciones,'%d/%m/%Y') AS inicio_funcion,
                DATE_FORMAT(u.fin_funciones,'%d/%m/%Y') AS fin_funcion
                from users u 
                left join nivel n on u.id_nivel=n.id_nivel
                left join status s on u.estado=s.id_status
                left join hingreso_ultimo h on h.id_usuario=u.id_usuario
                where u.id_nivel!=6 and u.id_nivel in (12)   and u.estado=2 or u.id_usuario in (1,7)
                group by u.id_usuario  
                ORDER BY u.usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function listar_mail_emprea($tipo){
        $sql = 
            "             
                SELECT C.*,
                s.nom_status,s.id_status
                
                FROM correos_empresas C
                LEFT JOIN status S ON C.estado=S.id_status
                WHERE C.estado in (1,2,3) and C.id_empresa='".$tipo."';
                    
            ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function listar_mail_alumnos($tipo){
        $sql = 
            "             
                SELECT 
            
                id_alumno ,id_grado, id_seccion

                FROM correos_empresas 
                WHERE id_correo_empre='".$tipo."';
                    
            ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function listar_mail_alumnos_nombres($tipo){

        $anio=date('Y');

        
        $sql = 
            "             
                SELECT *              
                FROM alumno 
                WHERE  estado_alumno=2  AND id_alumno='".$tipo."';
                    
            ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
       
    function listado_correos_alumno($alumno_col,$anio,$grado_col,$seccion_col){



            if (is_null($alumno_col)) {


                if($grado_col==='todos' && $seccion_col!='todos'){

                    $sql = 
                    "             
                        SELECT titular1_correo FROM alumno
        
                        WHERE  estado_alumno=2  
                        AND  id_seccion='".$seccion_col."' 
                        
                        ;
                            
                    ";
    

                }else if($seccion_col==='todos' && $grado_col !='todos' ){

                    $sql = 
                    "             
                        SELECT titular1_correo FROM alumno
        
                        WHERE  estado_alumno=2  
                        AND id_grado='".$grado_col."'  
                        
                        ;
                            
                    ";

                }else if ($grado_col==='todos' && $seccion_col==='todos'){
                    $sql = 
                    "             
                        SELECT titular1_correo FROM alumno
        
                        WHERE  estado_alumno=2  
                        
                        ;
                            
                    ";
                }elseif ($grado_col==='0' && $seccion_col==='0'){
                    $sql = 
                    "             
                        SELECT titular1_correo FROM alumno
        
                        WHERE  estado_alumno=2  
                        
                        ;
                            
                    ";
    
                }else{
                    $sql = 
                    "             
                        SELECT titular1_correo FROM alumno
                            WHERE  estado_alumno=2 
                            AND  id_seccion='".$seccion_col."' 
                            AND id_grado='".$grado_col."'  

                            ;

                            
                    ";
    
                }



            }else{

                $sql = 
                "             
                    SELECT titular1_correo FROM alumno
    
                    WHERE  estado_alumno=2  
                    and id_alumno in ('".$alumno_col."')

                    ;
                        
                ";
           
            }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_status_combo(){
        $sql = "SELECT * FROM status 
                WHERE id_status in (1,2,3) ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumnos_ll(){
        $sql = "SELECT * FROM alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumnos_id($seccion,$grado){
        $anio=date('Y');


                
                    if($seccion=='todos'){
                        $sec =  null;
                    }else{
                        $sec = "id_seccion='".$seccion."'";
                    }

                    
                            
                    if($grado=='todos'){
                        $gra =  null;
                    }else{
                        $gra =  "id_grado='".$grado."'";
                    }



        if( $sec ==null &&  $gra ==null ){

            $sql = 
            "             
                    SELECT id_alumno,alum_nom,alum_apater,alum_amater
                    FROM 
                    alumno where  estado_alumno=2  
                     ;
            ";

        }else if( $sec != null &&  $gra !=null){

            $sql = 
            "             
                    SELECT id_alumno,alum_nom,alum_apater,alum_amater
                    FROM 
                    alumno 
                    where   estado_alumno=2   AND  ".$sec." AND ".$gra."  ;
            ";
        }else if( $sec != null &&  $gra ==null){

            $sql = 
            "             
                    SELECT id_alumno,alum_nom,alum_apater,alum_amater
                    FROM 
                    alumno 
                    where  estado_alumno=2   AND  ".$sec."  ;

            ";


        }else if( $sec == null &&  $gra !=null){

            $sql =      "             
                                SELECT id_alumno,alum_nom,alum_apater,alum_amater
                                FROM 
                                alumno 
                                where   estado_alumno=2   AND  ".$gra."  ;

                        ";


        }


        //  print_r($sql);


        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
        
    function delete_email_empresa($dato){

        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE correos_empresas SET estado=4, fec_eli=NOW() ,user_eli=$id_usuario
                WHERE id_correo_empre='".$dato['id_correo_empre']."'";
        $this->db->query($sql); 
    }

    function insert_correos_empresas($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql =   "
            
                    INSERT INTO correos_empresas 
                    (
                        id_empresa,
                        codigo,
                        id_alumno,
                        id_grado,
                        id_seccion,
                  
                        envio_por,
                        anio,
                        fecha_envio_por,

                        titulo_mail,
                        text_mail,
                        estado,

                        fec_reg,
                        user_reg
            
                    ) 

                    VALUES 
                    
                    (
                        'ls',
                        '".$dato['codigo']."',
                        '".$dato['alumno_col']."',
                        '".$dato['grado_col']."',
                        '".$dato['seccion_col']."',

                        '".$dato['envio_por']."',
                        '".$dato['anio']."',
                        '".$dato['fecha']."',

                        '".$dato['titulo_mailing']."',
                        '".$dato['text_mailing']."',
                        '".$dato['estado']."',

                        NOW(),
                        $id_usuario
                    
                    );


                
                ";
        $this->db->query($sql);


                    $sqlselect = 'SELECT LAST_INSERT_ID() as id;';

        $query = $this->db->query($sqlselect)->result_Array();
        return $query;


    }

    function insert_correos_empresas_arch($nombre_arch,$id,$nombre){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql =   "
            
                    INSERT INTO archivos_correos_empresas 
                    (
                        nombre,
                        ruta,
                        id_correo_empre,
                        empresa,
                  

                        estado,

                        fec_reg,
                        user_reg
            
                    ) 

                    VALUES 
                    
                    (
                        '".$nombre."',
                        '".$nombre_arch."',
                        '".$id."',
                        'ls',

                        '2',

                        NOW(),
                        $id_usuario
                    
                    )


                
                ";
        $this->db->query($sql);
    }

    function get_list_seccion_id($data){
         

                
        if($data=='todos'){
            $sql = "
                       SELECT * FROM seccion

                    ";
        }else{
            $sql = 
            "      

                select 

                    id_seccion,
                    nom_seccion
                from seccion
                WHERE
                id_grado=".$data.";   
            ";
        }

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grado_ll(){
        $sql =  "SELECT * FROM grado_bl";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_seccion_ll(){
        $sql =  "SELECT * FROM seccion";
                $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //----------------------------------------COLABORADORES------------------------------------------
    function get_list_colaborador($tipo){  
        $parte = "";
        if($tipo==1){
            $parte = "AND co.estado=2";
        }else{
            $parte = "AND co.estado NOT IN (4)";
        }

        $sql = "SELECT co.id_colaborador,CASE WHEN co.foto!='' THEN 'Si' ELSE 'No' END ft, 
                co.apellido_paterno,co.apellido_materno,co.nombres,co.nickname,co.codigo_gll,
                co.correo_personal,co.celular,CASE WHEN co.cv!='' THEN 'Si' ELSE 'No' END AS cv,
                CASE WHEN (SELECT COUNT(*) FROM contrato_colaborador cc 
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado=2)>0 THEN 'Si' ELSE 'No' END AS ct, 
                co.foto,CASE WHEN co.id_perfil=1 THEN 'Profesor' ELSE '' END AS nom_perfil,co.dni,
                co.correo_corporativo,co.direccion,de.nombre_departamento,
                pr.nombre_provincia,di.nombre_distrito,
                DATE_FORMAT(co.inicio_funciones,'%d-%m-%Y') AS inicio_funciones,
                DATE_FORMAT(co.fin_funciones,'%d-%m-%Y') AS fin_funciones,co.nickname,co.usuario,
                st.nom_status,co.observaciones,CASE WHEN co.archivo_dni!='' THEN 'Si'
                ELSE 'No' END AS doc,pe.nom_perfil AS perfil,
                CASE WHEN SUBSTRING(co.fec_nacimiento,1,1)!='0' THEN 
                DATE_FORMAT(co.fec_nacimiento,'%d-%m-%Y') ELSE '' END AS fec_nacimiento,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc 
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2 AND 
                cc.archivo!='')>0 THEN 'Si' ELSE 'No' END AS ct_firmado
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento=co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=co.id_distrito
                LEFT JOIN status st ON st.id_status=co.estado
                LEFT JOIN perfil pe ON co.id_perfil=pe.id_perfil
                WHERE co.id_empresa=3 $parte
                ORDER BY co.apellido_paterno ASC,co.apellido_materno ASC,co.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_perfil(){
        $sql = "SELECT * FROM perfil 
                WHERE id_empresa=3 AND estado=2
                ORDER BY nom_perfil ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_colaborador(){
        $sql = "SELECT id_colaborador FROM colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_usuario_colaborador($dato){
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='".$dato['usuario']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla=$dato['codigo_gll']."'C";
        if($dato['fec_nacimiento']=='' or $dato['fec_nacimiento']=='0000-00-00'){
            $dato['fec_nacimiento'] = 'NULL';
        }else{
            $dato['fec_nacimiento'] = "'".$dato['fec_nacimiento']."'";
        }
    
        if($dato['inicio_funciones']=='' or $dato['inicio_funciones']=='0000-00-00'){
            $dato['inicio_funciones'] = 'NULL';
        }else{
            $dato['inicio_funciones'] = "'".$dato['inicio_funciones']."'";
        }
    
        if($dato['fin_funciones']=='' or $dato['fin_funciones']=='0000-00-00'){
            $dato['fin_funciones'] = 'NULL';
        }else{
            $dato['fin_funciones'] = "'".$dato['fin_funciones']."'";
        }
        
        $sql = "INSERT INTO colaborador (id_empresa,id_perfil,apellido_paterno,apellido_materno,nombres,dni,
                correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll, codigo_glla, inicio_funciones,fin_funciones,nickname,usuario,password,
                password_desencriptado,foto,observaciones, fec_nacimiento, estado,fec_reg,user_reg)
                VALUES (3,'".$dato['id_perfil']."','".$dato['apellido_paterno']."',
                '".$dato['apellido_materno']."','".$dato['nombres']."','".$dato['dni']."',
                '".$dato['correo_personal']."','".$dato['correo_corporativo']."',
                '".$dato['celular']."','".$dato['direccion']."','".$dato['id_departamento']."',
                '".$dato['id_provincia']."','".$dato['id_distrito']."','".$dato['codigo_gll']."',
                '".addslashes($codigo_glla)."',
                ".$dato['inicio_funciones'].",".$dato['fin_funciones'].",'".$dato['nickname']."',
                '".$dato['usuario']."','".$dato['password']."','".$dato['password_desencriptado']."',
                '".$dato['foto']."','".$dato['observaciones']."',".$dato['fec_nacimiento'].", 2, NOW(),
                $id_usuario)";
        $this->db->query($sql);

        $codigo_glla=$dato['codigo_gll']."''C";
        $sql2 = "INSERT INTO colaborador (id_empresa,id_perfil,apellido_paterno,apellido_materno,nombres,dni,
                correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll, codigo_glla, inicio_funciones,fin_funciones,nickname,usuario,password,
                password_desencriptado,foto,observaciones, fec_nacimiento, estado,fec_reg,user_reg)
                VALUES (3,'".$dato['id_perfil']."','".$dato['apellido_paterno']."',
                '".$dato['apellido_materno']."','".$dato['nombres']."','".$dato['dni']."',
                '".$dato['correo_personal']."','".$dato['correo_corporativo']."',
                '".$dato['celular']."','".$dato['direccion']."','".$dato['id_departamento']."',
                '".$dato['id_provincia']."','".$dato['id_distrito']."','".$dato['codigo_gll']."',
                '".$codigo_glla."',
                ".$dato['inicio_funciones'].",".$dato['fin_funciones'].",'".$dato['nickname']."',
                '".$dato['usuario']."','".$dato['password']."','".$dato['password_desencriptado']."',
                '".$dato['foto']."','".$dato['observaciones']."',".$dato['fec_nacimiento'].", 2, getdate(),
                $id_usuario)";
        $this->db5->query($sql2);
    }

    function ultimo_id_colaborador(){
        $sql = "SELECT id_colaborador FROM colaborador
                ORDER BY id_colaborador DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_users_colaborador($dato){ 
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND id_externo='".$dato['id_externo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
      
    function insert_usuario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO users (tipo,id_externo,usuario_codigo,usuario_password,password_desencriptado,
                estado,fec_reg,user_reg)
                VALUES (2,'".$dato['id_externo']."','".$dato['usuario']."','".$dato['password']."',
                '".$dato['password_desencriptado']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_colaborador($id_colaborador){ 
        $sql = "SELECT co.*,SUBSTRING_INDEX(co.foto,'/',-1) AS nom_documento,
                CONCAT(co.apellido_paterno,' ',co.apellido_materno,', ',co.nombres) AS Nombre_Completo,
                CASE WHEN co.id_perfil=1 THEN 'Profesor' ELSE '' END AS nom_perfil,
                de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT DATE_FORMAT(cc.inicio_funciones,'%d/%m/%Y') 
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS i_funciones,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT CASE WHEN SUBSTRING(cc.fin_funciones,1,1)!='0' THEN 
                DATE_FORMAT(cc.fin_funciones,'%d/%m/%Y') ELSE '' END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS f_funciones,
                SUBSTRING_INDEX(co.cv,'/',-1) AS nom_cv,'' AS banco,'' AS cuenta
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento=co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=co.id_distrito
                WHERE co.id_colaborador=$id_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_usuario_colaborador($dato){ 
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='".$dato['usuario']."' AND estado=2 AND
                id_externo!='".$dato['id_colaborador']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla=$dato['codigo_gll']."'C";
        $parte = "";
        if($dato['password']!=""){
            $parte = "password='".$dato['password']."',password_desencriptado='".$dato['password_desencriptado']."',";
        }

        if($dato['fec_nacimiento']=='' or $dato['fec_nacimiento']=='0000-00-00'){
            $dato['fec_nacimiento'] = 'NULL';
        }else{
            $dato['fec_nacimiento'] = "'".$dato['fec_nacimiento']."'";
        }
    
        if($dato['inicio_funciones']=='' or $dato['inicio_funciones']=='0000-00-00'){
            $dato['inicio_funciones'] = 'NULL';
        }else{
            $dato['inicio_funciones'] = "'".$dato['inicio_funciones']."'";
        }
    
        if($dato['fin_funciones']=='' or $dato['fin_funciones']=='0000-00-00'){
            $dato['fin_funciones'] = 'NULL';
        }else{
            $dato['fin_funciones'] = "'".$dato['fin_funciones']."'";
        }

        $sql = "UPDATE colaborador SET id_perfil='".$dato['id_perfil']."',
                apellido_paterno='".$dato['apellido_paterno']."',
                apellido_materno='".$dato['apellido_materno']."',nombres='".$dato['nombres']."',
                dni='".$dato['dni']."',correo_personal='".$dato['correo_personal']."',
                correo_corporativo='".$dato['correo_corporativo']."',celular='".$dato['celular']."',
                direccion='".$dato['direccion']."',id_departamento='".$dato['id_departamento']."',
                id_provincia='".$dato['id_provincia']."',id_distrito='".$dato['id_distrito']."',
                codigo_gll='".$dato['codigo_gll']."',inicio_funciones=".$dato['inicio_funciones'].",
                fin_funciones=".$dato['fin_funciones'].",nickname='".$dato['nickname']."',
                usuario='".$dato['usuario']."',$parte foto='".$dato['foto']."',
                observaciones='".$dato['observaciones']."',estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario, fec_nacimiento=".$dato['fec_nacimiento'].",
                codigo_glla='".addslashes($codigo_glla)."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);

        $codigo_glla=$dato['codigo_gll']."''C";

        $sql2 = "UPDATE colaborador SET id_perfil='".$dato['id_perfil']."',
                apellido_paterno='".$dato['apellido_paterno']."',
                apellido_materno='".$dato['apellido_materno']."',nombres='".$dato['nombres']."',
                dni='".$dato['dni']."',correo_personal='".$dato['correo_personal']."',
                correo_corporativo='".$dato['correo_corporativo']."',celular='".$dato['celular']."',
                direccion='".$dato['direccion']."',id_departamento='".$dato['id_departamento']."',
                id_provincia='".$dato['id_provincia']."',id_distrito='".$dato['id_distrito']."',
                codigo_gll='".$dato['codigo_gll']."',inicio_funciones=".$dato['inicio_funciones'].",
                fin_funciones=".$dato['fin_funciones'].",nickname='".$dato['nickname']."',
                usuario='".$dato['usuario']."',$parte foto='".$dato['foto']."',
                observaciones='".$dato['observaciones']."',estado='".$dato['estado']."',fec_act=getdate(),
                user_act=$id_usuario, fec_nacimiento=".$dato['fec_nacimiento'].",
                codigo_glla='".$codigo_glla."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db5->query($sql2);
    }

    function update_usuario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $parte = "";
        if($dato['password']!=""){
            $parte = "usuario_password='".$dato['password']."',password_desencriptado='".$dato['password_desencriptado']."',";
        }

        $sql = "UPDATE users SET usuario_codigo='".$dato['usuario']."',$parte fec_act=NOW(),
                user_act=$id_usuario
                WHERE tipo=2 AND id_externo='".$dato['id_externo']."'";
        $this->db->query($sql); 
    }

    function delete_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);
        $sql2 = "UPDATE colaborador SET estado=4,fec_eli=getdate(),user_eli=$id_usuario 
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db5->query($sql2);
    }

    function update_cv_colaborador($dato){
        $sql = "UPDATE colaborador SET cv='".$dato['cv']."'
                WHERE id_colaborador ='".$dato['id_colaborador']."'";
        $this->db->query($sql); 
    }

    function get_list_contrato_colaborador($id_colaborador){  
        $sql = "SELECT cc.id_contrato,cc.nom_contrato,DATE_FORMAT(cc.fecha,'%d-%m-%Y') AS fecha,
                CASE WHEN cc.archivo!='' THEN 'Si' ELSE 'No' END AS v_archivo,
                DATE_FORMAT(cc.fec_reg,'%d-%m-%Y') AS fec_registro,us.usuario_codigo AS user_registro,
                st.nom_status,st.color,cc.archivo
                FROM contrato_colaborador cc
                LEFT JOIN users us ON us.id_usuario=cc.user_reg
                LEFT JOIN status st ON st.id_status=cc.estado
                WHERE cc.id_colaborador=$id_colaborador AND cc.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_contrato_colaborador($dato){ 
        $sql = "SELECT * FROM contrato_colaborador 
                WHERE nom_contrato='".$dato['nom_contrato']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_contrato_colaborador(){
        $sql = "SELECT id_contrato FROM contrato_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO contrato_colaborador (id_colaborador,nom_contrato,fecha,archivo,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_colaborador']."','".$dato['nom_contrato']."','".$dato['fecha']."',
                '".$dato['archivo']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_contrato_colaborador($id_contrato){
        $sql = "SELECT * FROM contrato_colaborador 
                WHERE id_contrato=$id_contrato";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_contrato_colaborador($dato){ 
        $sql = "SELECT * FROM contrato_colaborador 
                WHERE nom_contrato='".$dato['nom_contrato']."' AND estado=2 AND 
                id_contrato!='".$dato['id_contrato']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE contrato_colaborador SET nom_contrato='".$dato['nom_contrato']."',fecha='".$dato['fecha']."',
                archivo='".$dato['archivo']."',estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_contrato='".$dato['id_contrato']."'";
        $this->db->query($sql);
    }

    function delete_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE contrato_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_contrato='".$dato['id_contrato']."'";
        $this->db->query($sql);
    }

    function get_list_pago_colaborador($id_colaborador){  
        $sql = "SELECT pc.id_pago,pc.id_banco AS nom_banco,pc.cuenta_bancaria,st.nom_status,
                st.color
                FROM pago_colaborador pc
                LEFT JOIN status st ON st.id_status=pc.estado
                WHERE pc.id_colaborador=$id_colaborador AND pc.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_pago_colaborador($dato){ 
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_banco='".$dato['id_banco']."' AND cuenta_bancaria='".$dato['cuenta_bancaria']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_pago_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO pago_colaborador (id_colaborador,id_banco,cuenta_bancaria,
                estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_colaborador']."','".$dato['id_banco']."',
                '".$dato['cuenta_bancaria']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_pago_colaborador($id_pago){
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_pago=$id_pago";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_pago_colaborador($dato){ 
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_banco='".$dato['id_banco']."' AND cuenta_bancaria='".$dato['cuenta_bancaria']."' AND 
                estado=2 AND id_pago!='".$dato['id_pago']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_pago_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_colaborador SET id_banco='".$dato['id_banco']."',
                cuenta_bancaria='".$dato['cuenta_bancaria']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function delete_pago_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = " UPDATE pago_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function get_list_asistencia_colaborador($id_colaborador){  
        // ri.estado=2 AND ri.id_alumno=$id_colaborador
        $sql = "SELECT ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' 
                END AS tipo_desc,CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' 
                WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,
                us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,ri.codigo
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.id_registro_ingreso=0
                ORDER BY ri.ingreso ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_obs(){
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users
                WHERE id_nivel!=6 AND id_nivel IN (12) AND estado=2 OR id_usuario IN (1,7)
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_observacion_colaborador($id_colaborador){  
        $sql = "SELECT oc.id_observacion,DATE_FORMAT(oc.fecha,'%d-%m-%Y') AS fecha,ti.nom_tipo,
                us.usuario_codigo AS usuario,oc.observacion,oc.fecha AS orden
                FROM observacion_colaborador oc
                LEFT JOIN tipo_observacion ti ON ti.id_tipo=oc.id_tipo
                LEFT JOIN users us ON us.id_usuario=oc.usuario
                WHERE oc.id_colaborador=$id_colaborador AND oc.estado=2
                ORDER BY oc.fecha DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_colaborador($dato){
        $id_nivel= $_SESSION['usuario'][0]['id_nivel'];
        $sql = "SELECT * FROM observacion_colaborador 
                WHERE id_tipo='".$dato['id_tipo']."' AND fecha='".$dato['fecha']."' AND 
                observacion='".$dato['observacion']."' AND id_colaborador='".$dato['id_colaborador']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO observacion_colaborador (id_colaborador,id_tipo,fecha,usuario,observacion,
                estado,fec_reg,user_reg, id_empresa) 
                VALUES ('".$dato['id_colaborador']."','".$dato['id_tipo']."','".$dato['fecha']."',
                '".$dato['usuario']."','".$dato['observacion']."',2,NOW(),$id_usuario,5)";
        $this->db->query($sql);
    }

    function delete_observacion_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE observacion_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }
    //---------------------------------RETIRADOS----------------------------
    function get_list_retirados(){
        $sql = "SELECT ar.id_alumno_retirado,ar.Id,ar.Apellido_Paterno,ar.Apellido_Materno,ar.Nombre,ar.Codigo,
                DATE_FORMAT(ar.fecha_nasiste,'%d-%m-%Y') AS fecha_no_asiste,mr.nom_motivo,
                CASE WHEN ar.fut=1 THEN 'Si' WHEN ar.fut=2 THEN 'No' ELSE '' END AS fut,ar.tkt_boleta,
                DATE_FORMAT(ar.fecha_fut,'%d-%m-%Y') AS fecha_fut,CASE WHEN ar.pago_pendiente=1 THEN 'Si' 
                WHEN ar.pago_pendiente=2 THEN 'No' END AS pago_pendiente,
                CASE WHEN ar.monto!='' THEN CONCAT('s./ ',ar.monto) ELSE '' END AS monto,td.Motivo_Arpay,
                td.Observaciones_Arpay,ar.otro_motivo,CASE WHEN ar.contacto=1 THEN 'Si' 
                WHEN ar.contacto=2 THEN 'No' WHEN ar.contacto=3 THEN 'Incomunicado' ELSE '' END AS contacto,
                DATE_FORMAT(ar.fecha_contacto,'%d-%m-%Y') AS fecha_contacto,
                DATE_FORMAT(ar.hora_contacto,'%H:%i:%s') AS hora_contacto,ar.resumen,ar.obs_retiro,
                CASE WHEN ar.p_reincorporacion=1 THEN 'Si' WHEN ar.p_reincorporacion=2 THEN 'No' ELSE '' 
                END AS reincorporacion
                FROM alumno_retirado ar
                LEFT JOIN motivo_retiro mr ON mr.id_motivo=ar.id_motivo
                LEFT JOIN todos_l20 td ON td.Id=ar.Id
                WHERE ar.id_empresa=3 AND ar.estado=2
                ORDER BY ar.Apellido_Paterno ASC,ar.Apellido_Materno ASC,ar.Nombre ASC";     
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------CIERRES DE CAJA-------------------------------------
    function get_list_cierre_caja($tipo){   
        $parte = ""; 
        if($tipo==1){ 
            $parte = "AND MONTH(ci.fecha)=MONTH(CURDATE()) AND YEAR(ci.fecha)=YEAR(CURDATE())";
        }
 
        $sql = "SELECT ci.id_cierre_caja,ci.fecha,um.usuario_codigo AS cod_vendedor,
                DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,ci.saldo_automatico,ci.monto_entregado,
                ci.productos,(ci.saldo_automatico-ci.monto_entregado) AS diferencia,
                un.usuario_codigo AS cod_entrega,DATE_FORMAT(ci.fec_reg,'%d-%m-%Y') AS fecha_registro,
                ur.usuario_codigo AS cod_registro,ci.cofre,ci.cerrada,
                CASE WHEN ci.estado=4 THEN '#C00000'
                WHEN ci.cerrada=0 THEN '#FF8000' 
                WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado>0 THEN '#0070C0'
                WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado=0 THEN '#92D050' 
                WHEN ci.cerrada=1 AND ci.cofre!='' THEN '#92D050'
                ELSE '' END AS color_estado,
                CASE WHEN ci.estado=4 THEN 'Anulada'
                WHEN ci.cerrada=0 THEN 'Pendiente' 
                WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado>0 THEN 'Cerrada'
                WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado=0 THEN 'Cerrado' 
                WHEN ci.cerrada=1 AND ci.cofre!='' THEN 'Asignada'
                ELSE '' END AS nom_estado,ci.estado,
                CASE WHEN MONTH(ci.fecha)=1 THEN CONCAT('ene-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=2 THEN CONCAT('feb-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=3 THEN 
                CONCAT('mar-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=4 THEN CONCAT('abr-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=5 THEN CONCAT('may-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=6 THEN 
                CONCAT('jun-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=7 THEN CONCAT('jul-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=8 THEN CONCAT('ago-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=9 THEN 
                CONCAT('set-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=10 THEN CONCAT('oct-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=11 THEN CONCAT('nov-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=12 THEN 
                CONCAT('dic-',YEAR(ci.fecha)) ELSE '' END AS mes_anio
                FROM cierre_caja_empresa ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN users ur ON ur.id_usuario=ci.user_reg
                WHERE ci.id_empresa=3 AND ci.estado NOT IN (4) $parte
                ORDER BY ci.fecha ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_codigo(){  
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users 
                WHERE tipo=1 AND estado=2 
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_saldo_automatico($id_vendedor,$fecha){ 
        $sql = "SELECT (IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) 
                FROM pago_matricula_alumno_bl pa
                WHERE pa.user_pago=$id_vendedor AND DATE(pa.fec_pago)='$fecha' AND 
                pa.estado_pago=2 AND pa.id_tipo_pago=1 AND pa.estado=2),0)-
                IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) 
                FROM pago_matricula_alumno_bl pa
                WHERE pa.user_pago=$id_vendedor AND DATE(pa.fec_pago)='$fecha' AND 
                pa.estado_pago=4 AND pa.id_tipo_pago=1 AND pa.estado=2),0)) AS saldo_automatico";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_productos($id_vendedor,$fecha){ 
        $sql = "SELECT ((SELECT COUNT(1) FROM pago_matricula_alumno_bl pa
                WHERE pa.user_pago=$id_vendedor AND DATE(pa.fec_pago)='$fecha' AND 
                pa.estado_pago=2 AND pa.id_tipo_pago=1 AND pa.estado=2)-
                (SELECT COUNT(1) FROM pago_matricula_alumno_bl pa
                WHERE pa.user_pago=$id_vendedor AND DATE(pa.fec_pago)='$fecha' AND 
                pa.estado_pago=4 AND pa.id_tipo_pago=1 AND pa.estado=2)) AS productos";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_cierre_caja($dato){
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=3 AND id_vendedor='".$dato['id_vendedor']."' AND 
                fecha='".$dato['fecha']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_venta_cierre_caja($dato){ 
        $sql = "SELECT COUNT(1) AS cantidad FROM pago_matricula_alumno_bl
                WHERE user_pago='".$dato['id_vendedor']."' AND 
                DATE(fec_pago)='".$dato['fecha_valida']."' AND estado_pago=2 AND 
                id_tipo_pago=1 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_ultimo_cierre_caja($dato){ 
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=3 AND id_vendedor='".$dato['id_vendedor']."' AND 
                fecha=DATE_SUB('".$dato['fecha']."',INTERVAL 1 DAY) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_cierre_caja($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cierre_caja_empresa (id_empresa,id_sede,id_vendedor,fecha,
                saldo_automatico,monto_entregado,id_entrega,cofre,productos,cerrada,
                estado,fec_reg,user_reg)  
                VALUES (3,6,'".$dato['id_vendedor']."','".$dato['fecha']."',
                '".$dato['saldo_automatico']."','".$dato['monto_entregado']."',
                '".$dato['id_entrega']."','".$dato['cofre']."','".$dato['productos']."',
                1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_cierre_caja(){ 
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=3
                ORDER BY id_cierre_caja DESC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function update_cierre_caja($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cierre_caja_empresa SET monto_entregado='".$dato['monto_entregado']."',
                id_entrega='".$dato['id_entrega']."',cofre='".$dato['cofre']."',
                fec_reg=NOW(),user_reg=$id_usuario,fec_act=NOW(),user_act=$id_usuario
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }

    function delete_cierre_caja($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = "UPDATE cierre_caja_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }

    function get_id_cierre_caja($id_cierre_caja){ 
        $sql = "SELECT ci.*,DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,
                DATE_FORMAT(ci.fec_reg,'%d-%m-%Y %H:%i') AS fecha_cierre,
                DATE_FORMAT(ci.fec_reg,'%H:%i') AS hora,um.usuario_codigo AS cod_vendedor,
                un.usuario_codigo AS cod_entrega,se.cod_sede,se.observaciones_sede AS nom_sede,
                IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS ingresos,
                0.00 AS egresos,
                IFNULL((SELECT COUNT(1) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS recibos,
                IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS total_recibos,
                IFNULL((SELECT COUNT(*) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=4 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS devoluciones,
                IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=4 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS total_devoluciones,
                (ci.saldo_automatico-ci.monto_entregado) AS diferencia
                FROM cierre_caja_empresa ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN sede se ON se.id_sede=ci.id_sede
                WHERE ci.id_cierre_caja=$id_cierre_caja";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_cierre_caja($fecha){   
        /*$sql = "SELECT CASE WHEN pa.estado_pago=2 THEN 'Venta' ELSE 'Devolución' END AS nom_tipo,'' AS cod_venta,
                (SELECT SUM(pa.monto-pa.descuento+pa.penalidad) FROM pago_matricula_alumno_bl pm 
                WHERE pm.id_pago=pa.id_pago) AS total,
                DATE_FORMAT(pa.fec_pago,'%d-%m-%Y') AS fecha_pago,us.usuario_codigo 
                FROM pago_matricula_alumno_bl pa
                LEFT JOIN users us ON us.id_usuario=pa.user_pago
                WHERE DATE(pa.fec_pago)='$fecha' AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2";*/ 
        $sql = "SELECT al.cod_alum,al.alum_apater,al.alum_amater,al.alum_nom,
                pa.nom_pago,es.nom_estadop,(pa.monto-pa.descuento+pa.penalidad) AS total,
                dp.cod_documento,DATE_FORMAT(pa.fec_pago,'%d-%m-%Y') AS fecha_pago,
                us.usuario_codigo
                FROM pago_matricula_alumno_bl pa
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                LEFT JOIN estadop es ON es.id_estadop=pa.estado_pago
                LEFT JOIN documento_pago_alumno_bl dp ON dp.id_pago=pa.id_pago AND dp.tipo=1 AND dp.estado=2
                LEFT JOIN users us ON us.id_usuario=pa.user_pago
                WHERE DATE(pa.fec_pago)='$fecha' AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2
                ORDER BY al.cod_alum ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_cofre_cierre_caja($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cierre_caja_empresa SET cofre='".$dato['cofre']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }
    //---------------------------BALANCE------------------------------------------
    function get_list_balance($anio){   
        /*
            $sql = "SELECT (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=1 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_ene,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=2 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_feb,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=3 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_mar,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=4 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_abr,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=5 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_may,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=6 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_jun,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=7 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_jul,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=8 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_ago,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=9 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_sep,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=10 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_oct,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=11 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_nov,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=12 AND
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta_dic,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=2 AND dp.estado=2)>0 AND pm.estado=2) AS total_boleta,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=1 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_ene,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=2 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_feb,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=3 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_mar,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=4 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_abr,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=5 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_may,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=6 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_jun,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=7 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_jul,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=8 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_ago,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=9 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_sep,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=10 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_oct,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=11 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_nov,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=12 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito_dic,
                    (SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=3 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_debito,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=1 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_ene,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=2 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_feb,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=3 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_mar,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=4 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_abr,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=5 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_may,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=6 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_jun,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=7 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_jul,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=8 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_ago,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=9 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_sep,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=10 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_oct,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=11 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_nov,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=12 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito_dic,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=4 AND dp.estado=2)>0 AND pm.estado=2) AS total_nota_credito,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=1 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_ene,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=2 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_feb,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=3 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_mar,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=4 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_abr,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=5 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_may,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=6 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_jun,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=7 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_jul,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=8 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_ago,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=9 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_sep,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=10 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_oct,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=11 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_nov,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND MONTH(pm.fec_pago)=12 AND 
                    (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura_dic,
                    (SELECT SUM(pm.monto-pm.descuento) FROM pago_matricula_alumno_bl pm
                    WHERE YEAR(pm.fec_pago)=$anio AND (SELECT COUNT(1) FROM documento_pago_alumno_bl dp 
                    WHERE dp.id_pago=pm.id_pago AND dp.tipo=5 AND dp.estado=2)>0 AND pm.estado=2) AS total_factura,
                    0 AS total_cuentas_cobrar_ene,0 AS total_cuentas_cobrar_feb,0 AS total_cuentas_cobrar_mar,
                    0 AS total_cuentas_cobrar_abr,0 AS total_cuentas_cobrar_may,0 AS total_cuentas_cobrar_jun,
                    0 AS total_cuentas_cobrar_jul,0 AS total_cuentas_cobrar_ago,0 AS total_cuentas_cobrar_sep,
                    0 AS total_cuentas_cobrar_oct,0 AS total_cuentas_cobrar_nov,0 AS total_cuentas_cobrar_dic,
                    0 AS total_cuentas_cobrar";
        */
        $sql = "SELECT (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=1 AND 
                dp.estado=2) AS total_boleta_ene,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=2 AND 
                dp.estado=2) AS total_boleta_feb,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=3 AND 
                dp.estado=2) AS total_boleta_mar,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=4 AND 
                dp.estado=2) AS total_boleta_abr,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=5 AND 
                dp.estado=2) AS total_boleta_may,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=6 AND 
                dp.estado=2) AS total_boleta_jun,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=7 AND 
                dp.estado=2) AS total_boleta_jul,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=8 AND 
                dp.estado=2) AS total_boleta_ago,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=9 AND 
                dp.estado=2) AS total_boleta_sep,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=10 AND 
                dp.estado=2) AS total_boleta_oct,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=11 AND 
                dp.estado=2) AS total_boleta_nov,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=12 AND 
                dp.estado=2) AS total_boleta_dic,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND dp.estado=2) AS total_boleta,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=1 AND 
                dp.estado=2) AS total_nota_debito_ene,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=2 AND 
                dp.estado=2) AS total_nota_debito_feb,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=3 AND 
                dp.estado=2) AS total_nota_debito_mar,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=4 AND 
                dp.estado=2) AS total_nota_debito_abr,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=5 AND 
                dp.estado=2) AS total_nota_debito_may,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=6 AND 
                dp.estado=2) AS total_nota_debito_jun,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=7 AND 
                dp.estado=2) AS total_nota_debito_jul,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=8 AND 
                dp.estado=2) AS total_nota_debito_ago,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=9 AND 
                dp.estado=2) AS total_nota_debito_sep,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=10 AND 
                dp.estado=2) AS total_nota_debito_oct,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=11 AND 
                dp.estado=2) AS total_nota_debito_nov,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=12 AND 
                dp.estado=2) AS total_nota_debito_dic,
                (SELECT SUM(pm.penalidad) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND dp.estado=2) AS total_nota_debito,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=1 AND 
                dp.estado=2) AS total_nota_credito_ene,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=2 AND 
                dp.estado=2) AS total_nota_credito_feb,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=3 AND 
                dp.estado=2) AS total_nota_credito_mar,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=4 AND 
                dp.estado=2) AS total_nota_credito_abr,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=5 AND 
                dp.estado=2) AS total_nota_credito_may,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=6 AND 
                dp.estado=2) AS total_nota_credito_jun,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=7 AND 
                dp.estado=2) AS total_nota_credito_jul,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=8 AND 
                dp.estado=2) AS total_nota_credito_ago,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=9 AND 
                dp.estado=2) AS total_nota_credito_sep,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=10 AND 
                dp.estado=2) AS total_nota_credito_oct,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=11 AND 
                dp.estado=2) AS total_nota_credito_nov,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=12 AND 
                dp.estado=2) AS total_nota_credito_dic,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND dp.estado=2) AS total_nota_credito,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=1 AND 
                dp.estado=2) AS total_factura_ene,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=2 AND 
                dp.estado=2) AS total_factura_feb,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=3 AND 
                dp.estado=2) AS total_factura_mar,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=4 AND 
                dp.estado=2) AS total_factura_abr,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=5 AND 
                dp.estado=2) AS total_factura_may,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=6 AND 
                dp.estado=2) AS total_factura_jun,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=7 AND 
                dp.estado=2) AS total_factura_jul,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=8 AND 
                dp.estado=2) AS total_factura_ago,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=9 AND 
                dp.estado=2) AS total_factura_sep,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=10 AND 
                dp.estado=2) AS total_factura_oct,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=11 AND 
                dp.estado=2) AS total_factura_nov,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=12 AND 
                dp.estado=2) AS total_factura_dic,
                (SELECT SUM(pm.monto-pm.descuento) FROM documento_pago_alumno_bl dp 
                LEFT JOIN pago_matricula_alumno_bl pm ON pm.id_pago=dp.id_pago
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND dp.estado=2) AS total_factura,
                0 AS total_cuentas_cobrar_ene,0 AS total_cuentas_cobrar_feb,0 AS total_cuentas_cobrar_mar,
                0 AS total_cuentas_cobrar_abr,0 AS total_cuentas_cobrar_may,0 AS total_cuentas_cobrar_jun,
                0 AS total_cuentas_cobrar_jul,0 AS total_cuentas_cobrar_ago,0 AS total_cuentas_cobrar_sep,
                0 AS total_cuentas_cobrar_oct,0 AS total_cuentas_cobrar_nov,0 AS total_cuentas_cobrar_dic,
                0 AS total_cuentas_cobrar";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function get_list_balance_boleta($anio,$mes){  
        $sql = "SELECT DATE(dp.fec_reg) AS fec_documento,
                CASE WHEN dp.cod_documento='' THEN 'Manual' ELSE 
                dp.cod_documento END AS num_documento,
                al.alum_apater,al.alum_amater,al.alum_nom,pa.nom_pago,
                (pa.monto-pa.descuento) AS monto,pa.fec_pago,
                CASE WHEN pa.id_tipo_pago=1 THEN 'Efectivo' WHEN pa.id_tipo_pago=2 THEN 'Recaudo' 
                WHEN pa.id_tipo_pago=3 THEN 'Transferencia' ELSE '' END AS nom_tipo_pago,
                pa.operacion
                FROM documento_pago_alumno_bl dp
                LEFT JOIN pago_matricula_alumno_bl pa ON pa.id_pago=dp.id_pago
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                WHERE dp.tipo=2 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=$mes AND 
                dp.estado=2
                ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_balance_nota_debito($anio,$mes){  
        $sql = "SELECT DATE(dp.fec_reg) AS fec_documento,dp.cod_documento AS num_documento,
                al.alum_apater,al.alum_amater,al.alum_nom,pa.nom_pago,
                pa.penalidad AS monto,pa.fec_pago,
                CASE WHEN pa.id_tipo_pago=1 THEN 'Efectivo' WHEN pa.id_tipo_pago=2 THEN 'Recaudo' 
                WHEN pa.id_tipo_pago=3 THEN 'Transferencia' ELSE '' END AS nom_tipo_pago,
                pa.operacion
                FROM documento_pago_alumno_bl dp
                LEFT JOIN pago_matricula_alumno_bl pa ON pa.id_pago=dp.id_pago
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                WHERE dp.tipo=3 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=$mes AND 
                dp.estado=2
                ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_balance_nota_credito($anio,$mes){  
        $sql = "SELECT DATE(dp.fec_reg) AS fec_documento,dp.cod_documento AS num_documento,
                al.alum_apater,al.alum_amater,al.alum_nom,pa.nom_pago,
                (pa.monto-pa.descuento) AS monto,pa.fec_pago,
                CASE WHEN pa.id_tipo_pago=1 THEN 'Efectivo' WHEN pa.id_tipo_pago=2 THEN 'Recaudo' 
                WHEN pa.id_tipo_pago=3 THEN 'Transferencia' ELSE '' END AS nom_tipo_pago,
                pa.operacion
                FROM documento_pago_alumno_bl dp
                LEFT JOIN pago_matricula_alumno_bl pa ON pa.id_pago=dp.id_pago
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                WHERE dp.tipo=4 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=$mes AND 
                dp.estado=2
                ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_balance_factura($anio,$mes){  
        $sql = "SELECT DATE(dp.fec_reg) AS fec_documento,dp.cod_documento AS num_documento,
                al.alum_apater,al.alum_amater,al.alum_nom,pa.nom_pago,
                (pa.monto-pa.descuento) AS monto,pa.fec_pago,
                CASE WHEN pa.id_tipo_pago=1 THEN 'Efectivo' WHEN pa.id_tipo_pago=2 THEN 'Recaudo' 
                WHEN pa.id_tipo_pago=3 THEN 'Transferencia' ELSE '' END AS nom_tipo_pago,
                pa.operacion
                FROM documento_pago_alumno_bl dp
                LEFT JOIN pago_matricula_alumno_bl pa ON pa.id_pago=dp.id_pago
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                WHERE dp.tipo=5 AND YEAR(dp.fec_reg)=$anio AND MONTH(dp.fec_reg)=$mes AND 
                dp.estado=2
                ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------C CONTRATO------------------------------------------
    function get_list_c_contrato($id_c_contrato=null){  
        if(isset($id_c_contrato) && $id_c_contrato>0){
            $sql = "SELECT *,SUBSTRING_INDEX(documento,'/',-1) AS nom_documento 
                    FROM c_contrato 
                    WHERE id_c_contrato=$id_c_contrato";
        }else{
            $sql = "SELECT c.id_c_contrato,CASE WHEN c.tipo=1 THEN 'Contrato (Matricula)' WHEN c.tipo=2 
                    THEN 'Contrato (Pago Cuota)' WHEN c.tipo=3 THEN 'Contrato (Pago Matricula)' 
                    WHEN c.tipo=4 THEN 'Contrato (Puntual)' WHEN c.tipo=5 THEN 'Mensaje' ELSE '' END AS tipo,
                    c.referencia,CASE WHEN SUBSTRING(c.mes_anio,1,2)='01' 
                    THEN CONCAT('Ene/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='02' 
                    THEN CONCAT('Feb/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='03' 
                    THEN CONCAT('Mar/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='04' 
                    THEN CONCAT('Abr/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='05' 
                    THEN CONCAT('May/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='06' 
                    THEN CONCAT('Jun/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='07' 
                    THEN CONCAT('Jul/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='08' 
                    THEN CONCAT('Ago/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='09' 
                    THEN CONCAT('Set/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='10' 
                    THEN CONCAT('Oct/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='11' 
                    THEN CONCAT('Nov/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='12' THEN 
                    CONCAT('Dic/',SUBSTRING(c.mes_anio,-4,4)) ELSE '' END AS mes_anio,c.descripcion,c.asunto,
                    c.texto_correo,c.documento,st.nom_status,st.color,(SELECT COUNT(*) FROM documento_firma df
                    WHERE df.id_contrato=c.id_c_contrato AND df.estado_d=2 AND df.estado=2) AS enviados,
                    (SELECT COUNT(*) FROM documento_firma df
                    WHERE df.id_contrato=c.id_c_contrato AND df.estado_d=3 AND df.estado=2) AS firmados,
                    0 AS por_firmar
                    FROM c_contrato c
                    LEFT JOIN status st ON st.id_status=c.estado
                    WHERE c.id_empresa=3 AND c.estado IN (2,3)
                    ORDER BY c.referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function ultimo_id_c_contrato(){
        $sql = "SELECT id_c_contrato FROM c_contrato";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_c_contrato($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO c_contrato (id_empresa,tipo,referencia,mes_anio,fecha_envio,descripcion,asunto,id_grado,
                id_seccion,texto_correo,sms,texto_sms,documento,estado,fec_reg,user_reg) 
                VALUES (3,'".$dato['tipo']."','".$dato['referencia']."','".$dato['mes_anio']."','".$dato['fecha_envio']."',
                '".$dato['descripcion']."','".$dato['asunto']."','".$dato['id_grado']."','".$dato['id_seccion']."',
                '".$dato['texto_correo']."','".$dato['sms']."','".$dato['texto_sms']."','".$dato['documento']."',3,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function update_c_contrato($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE c_contrato SET tipo='".$dato['tipo']."',referencia='".$dato['referencia']."',mes_anio='".$dato['mes_anio']."',
                fecha_envio='".$dato['fecha_envio']."',descripcion='".$dato['descripcion']."',asunto='".$dato['asunto']."',
                id_grado='".$dato['id_grado']."',id_seccion='".$dato['id_seccion']."',texto_correo='".$dato['texto_correo']."',
                sms='".$dato['sms']."',texto_sms='".$dato['texto_sms']."',documento='".$dato['documento']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_c_contrato='".$dato['id_c_contrato']."'";
        $this->db->query($sql);
    }

    function delete_c_contrato($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE c_contrato SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_c_contrato='".$dato['id_c_contrato']."'";
        $this->db->query($sql);
    }

    function get_list_grado_contrato(){  
        $sql = "SELECT um.nom_grado AS Grado 
                FROM alumno al
                LEFT JOIN ultima_matricula_bl um ON um.id_alumno=al.id_alumno 
                WHERE al.id_sede=6 AND al.estado=2 AND um.nom_grado!='' AND 
                um.anio=".date('Y')." AND um.pago_matricula=0 AND 
                um.estado_matricula NOT IN ('Retirado(a)')
                GROUP BY um.nom_grado
                ORDER BY um.nom_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_seccion_contrato($grado){ 
        $sql = "SELECT um.nom_seccion AS Seccion 
                FROM alumno al
                LEFT JOIN ultima_matricula_bl um ON um.id_alumno=al.id_alumno 
                WHERE al.id_sede=6 AND al.estado=2 AND um.nom_grado='$grado' AND 
                um.nom_seccion!='' AND um.anio=".date('Y')." AND um.pago_matricula=0 AND 
                um.estado_matricula NOT IN ('Retirado(a)')
                GROUP BY um.nom_seccion
                ORDER BY um.nom_seccion";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------CONTRATO------------------------------------------
    function get_list_contrato($tipo){
        $parte = ""; 
        $order = "df.fecha_firma";
        if($tipo==1){
            $parte = "AND df.estado_d=2";
            $order = "df.fecha_envio";
        }
        $sql = "SELECT df.id_documento_firma,df.id_alumno,df.id_apoderado,df.cod_alumno,df.apater_alumno,
                df.amater_alumno,df.nom_alumno,
                CONCAT(df.apater_apoderado,' ',df.amater_apoderado,', ',df.nom_apoderado) AS nom_apoderado,
                df.parentesco_apoderado,df.fecha_envio,df.fecha_firma,
                DATE_FORMAT(df.fecha_envio,'%d-%m-%Y') AS fec_envio,
                DATE_FORMAT(df.fecha_envio,'%H:%i') AS hora_envio,
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma,
                DATE_FORMAT(df.fecha_firma,'%H:%i') AS hora_firma,
                CASE WHEN df.estado_d=1 THEN 'Anulado' WHEN df.estado_d=2 THEN 'Enviado' 
                WHEN df.estado_d=3 THEN 'Firmado' WHEN df.estado_d=4 THEN 'Validado' END AS nom_status,
                CASE WHEN df.estado_d=1 THEN '#C00000' WHEN df.estado_d=2 THEN '#0070c0' 
                WHEN df.estado_d=3 THEN '#00C000' WHEN df.estado_d=4 THEN '#7F7F7F' END AS color_status,
                co.referencia,df.email_apoderado,df.celular_apoderado,df.estado_d
                FROM documento_firma df
                LEFT JOIN c_contrato co ON co.id_c_contrato=df.id_contrato
                WHERE df.id_empresa=3 AND df.estado=2 $parte
                ORDER BY $order DESC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_contratos_activos(){
        $sql = "SELECT * FROM c_contrato 
                WHERE id_empresa=3 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_contrato_apoderados($id_grado,$id_seccion){  
        $parte_grado_1 = "";
        $parte_seccion_1 = "";
        if($id_grado!="0"){
            $parte_grado_1 = "AND ua.nom_grado='$id_grado'";
        }
        if($id_seccion!="0"){
            $parte_seccion_1 = "AND ua.nom_seccion='$id_seccion'";
        }
        $parte_grado_2 = "";
        $parte_seccion_2 = "";
        if($id_grado!="0"){
            $parte_grado_2 = "AND ub.nom_grado='$id_grado'";
        }
        if($id_seccion!="0"){
            $parte_seccion_2 = "AND ub.nom_seccion='$id_seccion'"; 
        }

        $sql = "SELECT 1 AS Id,aa.id_alumno AS Id_Alumno,aa.titular1_apater AS Apellido_Paterno,
                aa.titular1_amater AS Apellido_Materno,aa.titular1_nom AS Nombre,
                aa.titular1_correo AS Email,aa.titular1_celular AS Celular,
                pa.nom_parentesco AS Parentesco,aa.cod_alum AS cod_alumno,
                aa.alum_apater AS apater_alumno,aa.alum_amater AS amater_alumno,
                aa.alum_nom AS nom_alumno,ua.nom_grado AS grado_alumno,
                ua.nom_seccion AS seccion_alumno
                FROM alumno aa
                LEFT JOIN parentesco pa ON pa.id_parentesco=aa.titular1_parentesco
                LEFT JOIN ultima_matricula_bl ua ON ua.id_alumno=aa.id_alumno
                WHERE aa.id_sede=6 AND aa.estado=2 AND aa.titular1_correo!='' AND 
                ua.anio=".date('Y')." AND ua.pago_matricula=0 AND 
                ua.estado_matricula NOT IN ('Retirado(a)')
                $parte_grado_1 $parte_seccion_1
                UNION 
                SELECT 2 AS Id,ab.id_alumno AS Id_Alumno,ab.titular2_apater AS Apellido_Paterno,
                ab.titular2_amater AS Apellido_Materno,ab.titular2_nom AS Nombre,
                ab.titular2_correo AS Email,ab.titular2_celular AS Celular,
                pb.nom_parentesco AS Parentesco,ab.cod_alum AS cod_alumno,
                ab.alum_apater AS apater_alumno,ab.alum_amater AS amater_alumno,
                ab.alum_nom AS nom_alumno,ub.nom_grado AS grado_alumno,
                ub.nom_seccion AS seccion_alumno
                FROM alumno ab
                LEFT JOIN parentesco pb ON pb.id_parentesco=ab.titular2_parentesco
                LEFT JOIN ultima_matricula_bl ub ON ub.id_alumno=ab.id_alumno
                WHERE ab.id_sede=6 AND ab.estado=2 AND ab.titular2_correo!='' AND 
                ub.anio=".date('Y')." AND ub.pago_matricula=0 AND 
                ub.estado_matricula NOT IN ('Retirado(a)')
                $parte_grado_2 $parte_seccion_2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_envio_correo_contrato($Id_Alumno,$Id,$id_contrato){
        $sql = "SELECT id_documento_firma FROM documento_firma 
                WHERE id_alumno=$Id_Alumno AND id_apoderado=$Id AND id_empresa=3 AND enviado=1 AND 
                id_contrato=$id_contrato AND estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function insert_documento_firma($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                nom_alumno,grado_alumno,seccion_alumno,id_apoderado,apater_apoderado,
                amater_apoderado,nom_apoderado,parentesco_apoderado,email_apoderado,
                celular_apoderado,id_empresa,enviado,fecha_envio,id_contrato,estado_d,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['cod_alumno']."',
                '".$dato['apater_alumno']."','".$dato['amater_alumno']."','".$dato['nom_alumno']."',
                '".$dato['grado_alumno']."','".$dato['seccion_alumno']."','".$dato['id_apoderado']."',
                '".$dato['apater_apoderado']."','".$dato['amater_apoderado']."',
                '".$dato['nom_apoderado']."','".$dato['parentesco_apoderado']."',
                '".$dato['email_apoderado']."','".$dato['celular_apoderado']."',3,1,
                NOW(),'".$dato['id_contrato']."',2,2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_documento_firma(){
        $sql = "SELECT id_documento_firma FROM documento_firma
                ORDER BY id_documento_firma DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_id_contrato($id_documento_firma){
        $sql = "SELECT df.id_alumno,df.cod_alumno,df.apater_alumno,df.amater_alumno,df.nom_alumno,df.grado_alumno,df.seccion_alumno,
                df.id_apoderado,tu.Apellido_Paterno AS apater_apoderado,tu.Apellido_Materno AS amater_apoderado,
                tu.Nombre AS nom_apoderado,tu.Parentesco AS parentesco_apoderado,tu.Celular AS celular_apoderado,
                df.id_contrato,CONCAT(df.apater_alumno,' ',df.amater_alumno,', ',df.nom_alumno) AS alumno,
                df.email_apoderado,df.id_documento_firma,df.vencido
                FROM documento_firma df
                LEFT JOIN tutores_ls tu ON tu.Id_Tutor=df.id_apoderado
                WHERE df.id_documento_firma=$id_documento_firma";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_email_contrato($dato){  
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET email_apoderado='".$dato['email_apoderado']."'
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql);
    }

    function update_documento_firma($dato){  
        $sql = "UPDATE documento_firma SET fecha_envio=NOW()
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql);
    }

    function delete_documento_firma($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET estado_d=1
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql); 
    }
    //---------------------------------------------PAGAMENTO-------------------------------------------
    function get_list_pagamento(){   
        $sql = "SELECT pa.id_producto,pa.anio,pa.nombre AS nom_producto,
                (SELECT COUNT(*) FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                WHERE ma.id_producto=pa.id_producto AND ma.estado=2 AND pm.estado_pago=1 AND 
                pm.estado=2) AS pendientes,
                IFNULL((SELECT SUM(pm.monto-pm.descuento+pm.penalidad) 
                FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                WHERE ma.id_producto=pa.id_producto AND ma.estado=2 AND pm.estado_pago=1 AND 
                pm.estado=2),0) AS total_pendientes,
                (SELECT COUNT(*) FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                WHERE ma.id_producto=pa.id_producto AND ma.estado=2 AND pm.estado_pago=2 AND 
                pm.estado=2) AS pagos,
                IFNULL((SELECT SUM(pm.monto) FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                WHERE ma.id_producto=pa.id_producto AND ma.estado=2 AND pm.estado_pago=2 AND 
                pm.estado=2),0) AS total_pagos_monto,
                IFNULL((SELECT SUM(pm.descuento) FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                WHERE ma.id_producto=pa.id_producto AND ma.estado=2 AND pm.estado_pago=2 AND 
                pm.estado=2),0) AS total_pagos_descuento,
                IFNULL((SELECT SUM(pm.penalidad) FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                WHERE ma.id_producto=pa.id_producto AND ma.estado=2 AND pm.estado_pago=2 AND 
                pm.estado=2),0) AS total_pagos_penalidad,
                IFNULL((SELECT SUM(pm.monto-pm.descuento+pm.penalidad) 
                FROM pago_matricula_alumno_bl pm
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pm.id_matricula
                WHERE ma.id_producto=pa.id_producto AND ma.estado=2 AND pm.estado_pago=2 AND 
                pm.estado=2),0) AS total_pagos
                FROM producto_articulo pa
                WHERE pa.estado=2
                ORDER BY pa.anio DESC,pa.nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_pagamento($id_producto,$tipo){  
        if($tipo==1){
            $parte = "AND pa.estado_pago=2"; 
        }else{
            $parte = "AND pa.estado_pago=1";
        }
        $sql = "SELECT al.alum_apater,al.alum_amater,al.alum_nom,al.cod_alum,
                um.nom_grado,um.nom_seccion,pa.nom_pago,pa.monto,pa.descuento,
                pa.penalidad,(pa.monto-pa.descuento+pa.penalidad) AS total,
                CASE WHEN pa.fec_pago='0000-00-00' THEN '' ELSE 
                DATE_FORMAT(pa.fec_pago,'%d/%m/%Y') END AS fec_pago,
                (SELECT dp.cod_documento FROM documento_pago_alumno_bl dp 
                WHERE dp.id_pago=pa.id_pago AND dp.tipo=1 AND dp.estado=2) AS recibo
                FROM pago_matricula_alumno_bl pa
                LEFT JOIN matricula_alumno_bl ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN alumno al ON al.id_alumno=ma.id_alumno
                LEFT JOIN ultima_matricula_bl um ON um.id_alumno=ma.id_alumno
                WHERE ma.id_producto=$id_producto AND ma.estado=2 AND pa.estado=2 $parte
                ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //-------------------------------------------------ASISTENCIA COLABORADOR----------------------------------
    function get_list_registro_ingreso_c($fec_in,$fec_fi){
        $sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden,
                FORMAT(ri.ingreso,'dd/MM/yyyy') AS fecha_ingreso,
                FORMAT(ri.ingreso,'HH:mm') AS hora_ingreso,
                ri.codigo,ri.apater,ri.amater,ri.nombres,
                (CASE WHEN hr.observacion IS NULL THEN 'No' ELSE 'Sí' END) AS obs,
                CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' 
                WHEN hr.tipo=5 THEN 'Foto' WHEN hr.tipo=6 THEN 'Uniforme' 
                WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.salida>0 THEN 'Salida' ELSE 
                (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END) END AS nom_estado_reporte,
                us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN 
                (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) 
                WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,
                pe.nom_perfil AS nom_tipo_acceso,
                CASE WHEN ri.reg_automatico=1 THEN 'Automático' WHEN ri.reg_automatico=2 THEN 'Manual'
                ELSE '' END AS reg_automatico,CASE WHEN ri.user_reg=0 THEN 
                (SELECT usuario_codigo FROM users WHERE id_usuario=60) 
                ELSE ue.usuario_codigo END AS usuario_registro,
                FORMAT(ri.hora_salida,'HH:mm') AS hora_salida,hr.observacion as obs_historial
                FROM registro_ingreso_ls ri
                LEFT JOIN historial_registro_ingreso_ls hr ON ri.id_registro_ingreso=hr.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN colaborador c on c.codigo_glla = ri.codigo
                LEFT JOIN perfil pe ON c.id_perfil=pe.id_perfil
                WHERE ri.estado=2 AND FORMAT(ri.ingreso,'yyyy-MM-dd') BETWEEN '$fec_in' AND '$fec_fi' AND 
                ri.codigo LIKE '%C%' and c.id_empresa=3
                ORDER BY ri.ingreso DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_historial_registro_ingreso($id_registro_ingreso){
        $sql = "SELECT *,CASE WHEN tipo=1 THEN 'Asiduidad' WHEN tipo=2 THEN 'Retraso' WHEN tipo=3 THEN 'Fotocheck' 
                WHEN tipo=4 THEN 'Documentos' WHEN tipo=5 THEN 'Foto' WHEN tipo=6 THEN 'Uniforme'
                WHEN tipo=7 THEN 'Presentación' WHEN tipo=8 THEN 'Pagos' END AS tipo_desc,
                DATE_FORMAT(fec_reg,'%d/%m/%Y') AS Fecha
                FROM historial_registro_ingreso_ls 
                WHERE estado=2 AND id_registro_ingreso=$id_registro_ingreso";
        $query = $this->db5->query($sql)->result_Array(); 
        return $query;
    }

    function delete_registro_ingreso_lista($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_ingreso_ls SET estado=4,fec_eli=GETDATE(),user_eli=$id_usuario
                WHERE id_registro_ingreso='".$dato['id_registro_ingreso']."'";
        $this->db5->query($sql);
    }
    //-----------------------------------------------SALÓN------------------------------------------
    function get_list_salon($id_salon=null){
        if(isset($id_salon) && $id_salon>0){
            $sql = "SELECT * FROM salon_bl WHERE id_salon=$id_salon";
        }else{
            $sql = "SELECT sa.*,CASE WHEN sa.ae=1 THEN 'Si' ELSE 'No' END AS ae,
                    CASE WHEN sa.cf=1 THEN 'Si' ELSE 'No' END AS cf,CASE WHEN sa.ds=1 THEN 'Si' ELSE 'No' END AS ds,
                    CASE WHEN sa.et=1 THEN 'Si' ELSE 'No' END AS et,CASE WHEN sa.ft=1 THEN 'Si' ELSE 'No' END AS ft,
                    CASE WHEN sa.estado_salon=1 THEN 'Activo' WHEN sa.estado_salon=2 THEN 'Inactivo' 
                    WHEN sa.estado_salon=3 THEN 'Clausurado' ELSE '' END AS estado_salon,ts.nom_tipo_salon
                    FROM salon_bl sa
                    LEFT JOIN tipo_salon ts ON ts.id_tipo_salon=sa.id_tipo_salon
                    WHERE sa.estado=2
                    ORDER BY sa.planta ASC,sa.referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_combo_salon($id_especialidad){
        if($id_especialidad==5){
            $parte = "AND et=1";
        }elseif($id_especialidad==6){
            $parte = "AND ft=1";
        }elseif($id_especialidad==7){
            $parte = "AND ae=1";
        }elseif($id_especialidad==8){
            $parte = "AND cf=1";
        }elseif($id_especialidad==9){
            $parte = "AND ds=1";
        }
        $sql = "SELECT id_salon,descripcion AS nom_salon 
                FROM salon_bl 
                WHERE estado=2 $parte
                ORDER BY nom_salon ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_tipo_salon(){
        $sql = "SELECT * FROM tipo_salon ORDER BY nom_tipo_salon ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_salon($dato){
        $sql = "SELECT * FROM salon_bl WHERE referencia='".$dato['referencia']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_salon($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO salon_bl (planta,referencia,id_tipo_salon,descripcion,ae,cf,ds,et,ft,capacidad,disponible,
                pintura,chapa,pizarra,proyector,puerta,tacho,cortina,iluminacion,mueble,mesa_profesor,enchufe,
                computadora,silla_profesor,observaciones,estado_salon,estado,fec_reg,user_reg) 
                VALUES('".$dato['planta']."','".$dato['referencia']."','".$dato['id_tipo_salon']."',
                '".$dato['descripcion']."','".$dato['ae']."','".$dato['cf']."','".$dato['ds']."','".$dato['et']."',
                '".$dato['ft']."','".$dato['capacidad']."','".$dato['disponible']."','".$dato['pintura']."',
                '".$dato['chapa']."','".$dato['pizarra']."','".$dato['proyector']."','".$dato['puerta']."',
                '".$dato['tacho']."','".$dato['cortina']."','".$dato['iluminacion']."','".$dato['mueble']."',
                '".$dato['mesa_profesor']."','".$dato['enchufe']."','".$dato['computadora']."',
                '".$dato['silla_profesor']."','".$dato['observaciones']."',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_salon($dato){
        $sql = "SELECT * FROM salon_bl WHERE referencia='".$dato['referencia']."' AND 
                estado=2 AND id_salon!='".$dato['id_salon']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_salon($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE salon_bl SET planta='".$dato['planta']."',referencia='".$dato['referencia']."',
                id_tipo_salon='".$dato['id_tipo_salon']."',descripcion='".$dato['descripcion']."',
                ae='".$dato['ae']."',cf='".$dato['cf']."',ds='".$dato['ds']."',et='".$dato['et']."',ft='".$dato['ft']."',
                capacidad='".$dato['capacidad']."',disponible='".$dato['disponible']."',pintura='".$dato['pintura']."',
                chapa='".$dato['chapa']."',pizarra='".$dato['pizarra']."',proyector='".$dato['proyector']."',
                puerta='".$dato['puerta']."',tacho='".$dato['tacho']."',cortina='".$dato['cortina']."',
                iluminacion='".$dato['iluminacion']."',mueble='".$dato['mueble']."',mesa_profesor='".$dato['mesa_profesor']."',
                enchufe='".$dato['enchufe']."',computadora='".$dato['computadora']."',silla_profesor='".$dato['silla_profesor']."',
                observaciones='".$dato['observaciones']."',estado_salon='".$dato['estado_salon']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_salon='".$dato['id_salon']."'";
        $this->db->query($sql);
    } 

    function delete_salon($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE salon_bl SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_salon='".$dato['id_salon']."'";
        $this->db->query($sql);
    }

    function get_list_especialidad_combo(){
        $sql = "SELECT id_especialidad,nom_especialidad,abreviatura 
                FROM especialidad 
                WHERE estado=2 
                ORDER BY nom_especialidad ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //---------------------------------------------MAILING-------------------------------------------
    function get_list_mailing($id_mailing=null){  
        if(isset($id_mailing) && $id_mailing>0){
            $sql = "SELECT * FROM mailing_alumno 
                    WHERE id_mailing=$id_mailing";
        }else{
            $sql = "SELECT ma.id_mailing,ma.codigo,CASE WHEN ma.tipo_envio=1 THEN 'Matricula'
                    WHEN ma.tipo_envio=2 THEN 'Fecha' ELSE '' END AS nom_tipo_envio,ma.titulo,ma.texto,
                    ma.documento,st.nom_status,st.color,CASE WHEN SUBSTRING(ma.fecha_envio,1,1)='2' THEN
                    DATE_FORMAT(ma.fecha_envio,'%d-%m-%Y') ELSE '' END AS fecha_envio,
                    CASE WHEN ma.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                    FROM mailing_alumno ma
                    LEFT JOIN status st ON ma.estado_m=st.id_status
                    WHERE ma.id_empresa=3 AND ma.estado IN (2,3)
                    ORDER BY ma.codigo ASC";
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_alumno_mailing(){ 
        //MATRICULADOS
        /*$sql = "SELECT al.id_alumno,CONCAT(al.alum_apater,' ',al.alum_amater,', ',al.alum_nom) AS nom_alumno
                FROM alumno al 
                LEFT JOIN ultima_matricula_bl um ON um.id_alumno=al.id_alumno
                WHERE al.id_sede=6 AND al.estado=2 AND um.pago_matricula>0 AND 
                um.estado_matricula NOT IN ('Retirado(a)')
                ORDER BY al.alum_apater ASC,al.alum_amater ASC,al.alum_nom ASC";*/
        //TODOS
        $sql = "SELECT id_alumno,CONCAT(alum_apater,' ',alum_amater,', ',alum_nom) AS nom_alumno
                FROM alumno
                WHERE id_sede=6 AND estado=2
                ORDER BY alum_apater ASC,alum_amater ASC,alum_nom ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_grado_mailing(){
        $sql = "SELECT nom_grado FROM grado_bl 
                WHERE estado=2
                ORDER BY nom_grado ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_seccion_mailing($nom_grado){
        $sql = "SELECT se.nom_seccion FROM seccion se
                LEFT JOIN grado_bl gr ON se.id_grado=gr.id_grado
                WHERE gr.nom_grado='$nom_grado' AND se.estado=2
                ORDER BY se.nom_seccion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_mailing(){
        $sql = "SELECT COUNT(1) AS cantidad FROM mailing_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO mailing_alumno (id_empresa,codigo,alumno,grado,seccion,tipo_envio,fecha_envio,
                titulo,texto,documento,estado_m,estado,fec_reg,user_reg) 
                VALUES (3,'".$dato['codigo']."','".$dato['alumno']."','".$dato['grado']."',
                '".$dato['seccion']."','".$dato['tipo_envio']."','".$dato['fecha_envio']."',
                '".$dato['titulo']."','".$dato['texto']."','".$dato['documento']."','".$dato['estado_m']."',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_mailing(){
        $sql = "SELECT id_mailing FROM mailing_alumno
                ORDER BY id_mailing DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_envio_mailing($dato){
        $sql = "INSERT INTO envio_mailing_alumno (id_mailing,id_alumno) 
                VALUES ('".$dato['id_mailing']."','".$dato['id_alumno']."')";
        $this->db->query($sql);
    }

    function get_list_envio_mailing($id_mailing){
        $sql = "SELECT id_alumno FROM envio_mailing_alumno
                WHERE id_mailing=$id_mailing";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET codigo='".$dato['codigo']."',alumno='".$dato['alumno']."',
                grado='".$dato['grado']."',seccion='".$dato['seccion']."',
                tipo_envio='".$dato['tipo_envio']."',fecha_envio='".$dato['fecha_envio']."',
                titulo='".$dato['titulo']."',texto='".$dato['texto']."',documento='".$dato['documento']."',
                estado_m='".$dato['estado_m']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function delete_envio_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM envio_mailing_alumno
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function get_mailing_activos(){
        $sql = "SELECT id_mailing,titulo,texto,documento
                FROM mailing_alumno 
                WHERE id_empresa=3 AND enviado=0 AND estado_m=2 AND 
                (tipo_envio=1 OR (tipo_envio=2 AND fecha_envio=CURDATE())) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_datos_alumno_mailing($id_mailing){
        $sql = "CALL datos_alumno_mailing ($id_mailing)";
        $query = $this->db->query($sql)->result_Array();
        mysqli_next_result($this->db->conn_id);
        return $query; 
    } 

    function insert_detalle_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_mailing_alumno (id_mailing,id_alumno,cod_alumno,apater_alumno,
                amater_alumno,nom_alumno,email_alumno,celular_alumno,grado_alumno,seccion_alumno,id_apoderado,
                apater_apoderado,amater_apoderado,nom_apoderado,parentesco_apoderado,email_apoderado,
                celular_apoderado,fecha_envio,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_mailing']."','".$dato['id_alumno']."','".$dato['cod_alumno']."',
                '".$dato['apater_alumno']."','".$dato['amater_alumno']."','".$dato['nom_alumno']."',
                '".$dato['email_alumno']."','".$dato['celular_alumno']."','".$dato['grado_alumno']."',
                '".$dato['seccion_alumno']."','".$dato['id_apoderado']."','".$dato['apater_apoderado']."',
                '".$dato['amater_apoderado']."','".$dato['nom_apoderado']."',
                '".$dato['parentesco_apoderado']."','".$dato['email_apoderado']."',
                '".$dato['celular_apoderado']."',NOW(),2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_enviado_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET enviado=1,estado_m=3
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function delete_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function get_list_detalle_mailing($id_mailing){  
        $sql = "SELECT fecha_envio AS orden,cod_alumno,apater_alumno,amater_alumno,nom_alumno,
                CONCAT(apater_apoderado,' ',amater_apoderado,', ',nom_apoderado) AS nom_apoderado,
                parentesco_apoderado,email_apoderado,celular_apoderado,
                DATE_FORMAT(fecha_envio,'%d-%m-%Y') AS fec_envio,
                DATE_FORMAT(fecha_envio,'%H:%i') AS hora_envio
                FROM detalle_mailing_alumno
                WHERE id_mailing=$id_mailing AND estado=2
                ORDER BY fecha_envio DESC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }
   /* 
    function get_list_colaborador_combo(){
        $sql = "SELECT id_colaborador,CONCAT(apellido_paterno,' ',apellido_materno,', ',nombres) AS nom_colaborador
                FROM colaborador WHERE id_empresa=3 AND estado=2
                ORDER BY nombres ASC,apellido_paterno ASC,apellido_materno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_insert_documento_colab($dato){
        $sql = "SELECT * FROM documento_colaborador_empresa 
                WHERE id_empresa=3 AND cod_documento='".$dato['cod_documento']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_list_documento_colab($id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_colaborador_empresa 
                    WHERE id_documento=$id_documento";
        }else{
            $sql = "SELECT do.*,CASE WHEN do.obligatorio=0 THEN 'No' 
                    WHEN do.obligatorio=1 THEN 'Si'
                    WHEN do.obligatorio=2 THEN 'Mayores de 4 (>4)' 
                    WHEN do.obligatorio=3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,
                    st.nom_status,CASE WHEN do.validacion=1 THEN 'Si' ELSE 'No' END AS validacion
                    FROM documento_colaborador_empresa do
                    LEFT JOIN status st ON st.id_status=do.estado
                    WHERE do.id_empresa=3 AND do.estado!=4
                    ORDER BY do.nom_documento ASC,do.descripcion_documento ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function insert_documento_colab($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_colaborador_empresa (id_empresa,cod_documento,nom_documento,
                descripcion_documento,obligatorio,digital,aplicar_todos,validacion,estado,fec_reg,user_reg) 
                VALUES (3,'".$dato['cod_documento']."','".$dato['nom_documento']."',
                '".$dato['descripcion_documento']."','".$dato['obligatorio']."','".$dato['digital']."',
                '".$dato['aplicar_todos']."','".$dato['validacion']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    function ultimo_id_documento_colab(){
        $sql = "SELECT id_documento FROM documento_colaborador_empresa 
                WHERE id_empresa=3 ORDER BY id_documento DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_update_documento_colab($dato){
        $sql = "SELECT * FROM documento_colaborador_empresa 
                WHERE id_empresa=3 AND cod_documento='".$dato['cod_documento']."' AND estado=2 AND 
                id_documento!='".$dato['id_documento']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function update_documento_colab($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_colaborador_empresa SET cod_documento='".$dato['cod_documento']."',
                nom_documento='".$dato['nom_documento']."',
                descripcion_documento='".$dato['descripcion_documento']."',
                obligatorio='".$dato['obligatorio']."',digital='".$dato['digital']."',
                aplicar_todos='".$dato['aplicar_todos']."',validacion='".$dato['validacion']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
    function delete_documento_colab($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_colaborador_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
    function valida_insert_documento_todos_colab($dato){
        $sql = "SELECT * FROM detalle_colaborador_empresa 
                WHERE id_colaborador='".$dato['id_colaborador']."' AND
                id_documento='".$dato['id_documento']."' AND id_empresa=3 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function insert_documento_todos_colab($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_colaborador_empresa (id_colaborador,id_documento,id_empresa,anio,
                    estado,fec_reg,user_reg)
                    VALUES ('" . $dato['id_colaborador'] . "','" . $dato['id_documento'] . "',3,
                    '" . $dato['anio'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    // ---------------------- lISTA DE FOTOCHECKS DE BABYLEADERS --------------------------------------
    function get_list_fotocheck($tipo){
        $parte = " f.esta_fotocheck NOT IN (99)"; //99 es el estado de prueba
        if($tipo==1){
            $parte = "f.esta_fotocheck NOT IN (2,3,99)";
        }
        $sql = "SELECT f.*,DATE_FORMAT(f.Fecha_Pago_Fotocheck, '%d/%m/%Y') as Pago_Fotocheck,tl.id_colaborador,
                tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombres,tl.codigo_gll, tl.codigo_glla,
                DATE_FORMAT(f.fecha_envio, '%d/%m/%Y') as fecha_envio,
                f.usuario_encomienda,f.cargo_envio,
                DATE_FORMAT(f.fecha_recepcion, '%d/%m/%Y') as fecha_recepcion,f.usuario_foto,
                (SELECT us.usuario_codigo FROM users us 
                WHERE f.usuario_encomienda=us.id_usuario) as usuario_codigo,
                (SELECT us.usuario_codigo FROM users us 
                WHERE f.usuario_foto=us.id_usuario) as usuario_foto,
                (SELECT car.cod_cargo FROM cargo car 
                WHERE car.id_cargo=f.cargo_envio) as cargo_envio,
                CASE WHEN f.esta_fotocheck=1 AND f.impresion=0 THEN 'Foto Rec' 
                WHEN f.esta_fotocheck=1 AND f.impresion=1 THEN 'Impreso'
                WHEN f.esta_fotocheck=2 THEN 'Enviado' 
                WHEN f.esta_fotocheck=3 THEN 'Anulado' ELSE 'Cancelado' END AS esta_fotocheck,
                CASE WHEN f.esta_fotocheck=1 AND f.impresion=0 THEN '#92D050' 
                WHEN f.esta_fotocheck=1 AND f.impresion=1 THEN '#F18A00'
                WHEN f.esta_fotocheck=2 THEN '#0070c0' 
                WHEN f.esta_fotocheck=3 THEN '#7F7F7F' ELSE '#0070c0' END AS color_esta_fotocheck,
                f.esta_fotocheck AS estado_fotocheck
                FROM fotocheck_bl f
                LEFT JOIN colaborador tl ON f.Id=tl.id_colaborador
                WHERE $parte
                ORDER BY f.Fecha_Pago_Fotocheck ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_fotocheck($id_fotocheck){
        $sql = "SELECT fo.*,CASE WHEN fo.esta_fotocheck=1 THEN 'Foto Rec' WHEN fo.esta_fotocheck=2 THEN 'Enviado' 
                WHEN fo.esta_fotocheck=3 THEN 'Anulado' ELSE 'Cancelado' END AS esta_fotocheck,
                CASE WHEN fo.esta_fotocheck=1 THEN '#92D050' WHEN fo.esta_fotocheck=2 THEN '#0070c0' 
                WHEN fo.esta_fotocheck=3 THEN '#7F7F7F' ELSE '#0070c0' END AS color_esta_fotocheck, 
                DATE_FORMAT(fo.fecha_recepcion, '%d/%m/%Y') AS fecha_recepcion,
                DATE_FORMAT(fo.fecha_recepcion_2, '%d/%m/%Y') AS fecha_recepcion_2,
                DATE_FORMAT(fo.fecha_recepcion_3, '%d/%m/%Y') AS fecha_recepcion_3,
                DATE_FORMAT(fo.fecha_envio, '%d/%m/%Y') AS fecha_envio,
                uf.usuario_codigo AS usuario_foto,
                DATE_FORMAT(fo.fecha_anulado, '%d/%m/%Y') AS fecha_anulado,
                ua.usuario_codigo AS usuario_anulado,ud.usuario_codigo AS usuario_foto_2,
                ut.usuario_codigo AS usuario_foto_3,ue.usuario_codigo AS usuario_encomienda,
                ca.cod_cargo AS cargo_envio,
                SUBSTRING_INDEX(foto_fotocheck,'/',-1) AS nom_foto_fotocheck,
                SUBSTRING_INDEX(foto_fotocheck_2,'/',-1) AS nom_foto_fotocheck_2,
                SUBSTRING_INDEX(foto_fotocheck_3,'/',-1) AS nom_foto_fotocheck_3
                ,tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombres,tl.codigo_gll,tl.codigo_glla,
                YEAR(fo.fecha_fotocheck) AS anio_fotocheck,MONTH(fo.fecha_fotocheck) AS mes_fotocheck,
                case when length(concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno)) > 18 then 
                concat(tl.Apellido_Paterno,' ',substring(tl.Apellido_Materno,1,1),'.')else concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno) end as apellidos,
                IF(LENGTH(tl.nombres) > 20, CONCAT(SUBSTRING(tl.nombres, 1, 20),'.'),tl.nombres) AS Nombre_corto,
                (SELECT car.cod_cargo FROM cargo car WHERE car.id_cargo=fo.cargo_envio) as cargo_envio
                FROM fotocheck_bl fo
                LEFT JOIN users uf ON uf.id_usuario=fo.usuario_foto
                LEFT JOIN users ua ON ua.id_usuario=fo.usuario_anulado
                LEFT JOIN users ud ON ud.id_usuario=fo.usuario_foto_2
                LEFT JOIN users ut ON ut.id_usuario=fo.usuario_foto_3
                LEFT JOIN users ue ON ue.id_usuario=fo.usuario_encomienda
                LEFT JOIN cargo ca ON ca.id_cargo=fo.cargo_envio
                LEFT JOIN colaborador tl ON tl.id_colaborador=fo.Id
                WHERE fo.id_fotocheck=$id_fotocheck";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_documento_colaborador($cod_documento){ // cambiar aal crear tabla de -> documento_colaborador_empresa
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                WHERE id_empresa=3 AND cod_documento='$cod_documento' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_detalle_colaborador_empresa($id_colaborador,$id_documento){ // camiar al crear la tabla de -> detalle_colaborador_empresa
        $sql = "SELECT id_detalle FROM detalle_alumno_empresa 
                WHERE id_alumno=$id_colaborador AND id_documento=$id_documento AND estado=2
                ORDER BY id_detalle DESC";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_foto_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $estado = "";
        if($dato['n_foto']==1){
            $foto_fotocheck = "foto_fotocheck";
            $usuario_foto = "usuario_foto";
            $fecha_recepcion = "fecha_recepcion";
        }else{
            if($dato['n_foto']==2){
                $estado="esta_fotocheck=1,";
            }
            $foto_fotocheck = "foto_fotocheck_".$dato['n_foto'];
            $usuario_foto = "usuario_foto_".$dato['n_foto'];
            $fecha_recepcion = "fecha_recepcion_".$dato['n_foto'];
        }
        $sql = "UPDATE fotocheck_bl SET $foto_fotocheck='".$dato[$foto_fotocheck]."',
                $usuario_foto=$id_usuario,$fecha_recepcion=NOW(),$estado
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function update_documento_colaborador($dato){ // cambiar al crear la tabla -> detalle_colabordor_empresa
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_alumno_empresa SET archivo='".$dato['archivo']."',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        echo $sql;
        $this->db->query($sql);
    }

    function valida_fotocheck_completo($id_fotocheck){
        $sql = "SELECT id_fotocheck FROM fotocheck_bl 
                WHERE id_fotocheck=$id_fotocheck AND foto_fotocheck!='' AND 
                foto_fotocheck_2!='' AND foto_fotocheck_3!='' AND 
                (fecha_fotocheck IS NOT NULL OR fecha_fotocheck!='' OR fecha_fotocheck!='0000-00-00')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_fotocheck_completo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_bl SET fecha_fotocheck=NOW()
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function impresion_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_bl SET impresion=1,fec_impresion=NOW(),user_impresion=$id_usuario
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function anular_envio($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE fotocheck_bl SET esta_fotocheck=3,obs_anulado='".$dato['obs_anulado']."',usuario_anulado=$id_usuario,fecha_anulado=NOW(),user_act=$id_usuario 
        WHERE id_fotocheck='".$dato['id_fotocheck']."'";

        $this->db->query($sql);
    }

    function get_id_user(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM users where id_usuario='$id_usuario' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cargo_x_id($id_usuario_de){
        $sql = "SELECT * FROM (SELECT * FROM cargo where id_usuario_de=$id_usuario_de ORDER BY cod_cargo DESC LIMIT 10) AS cargo ORDER BY cod_cargo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_envio_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_bl SET fecha_envio='".$dato['fecha_envio']."',
                    usuario_encomienda='".$dato['usuario_encomienda']."',
                    cargo_envio='".$dato['cargo_envio']."',esta_fotocheck=2,
                    fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }*/
    
    //---------------------------------------------Colaborador--Observaciones-------------------------------------------
    function get_list_colaborador_obs(){ 
        $sql = "SELECT c.apellido_Paterno,c.apellido_Materno,c.nombres,c.codigo_gll,e.nom_empresa,
                DATE_FORMAT(oc.fec_reg, '%d-%m-%Y') AS fecha_registro,oc.observacion AS Comentario,
                u.usuario_codigo,c.id_empresa
                FROM observacion_colaborador oc
                LEFT JOIN colaborador c ON c.id_colaborador=oc.id_colaborador
                LEFT JOIN empresa e ON e.id_empresa=c.id_empresa
                LEFT JOIN users u ON u.id_usuario=c.user_reg
                WHERE oc.id_empresa = 3";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
}