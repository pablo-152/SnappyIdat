<?php
    require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    $id_departamento=$_POST['id_departamento'];

    $query_p=mysqli_query($con, "SELECT * FROM provincia WHERE id_departamento=$id_departamento");
    $row_p=mysqli_fetch_array($query_p);
    $totalRows_p = mysqli_num_rows($query_p);
?>

<select id="id_provincia" name="id_provincia" class="input-form">
    <option value="0">Seleccione</option>
    <?php if($totalRows_p>0){ do{ ?>
        <option value="<?php echo $row_p['id_provincia']?>"><?php echo utf8_encode($row_p['nombre_provincia']); ?></option>
    <?php } while ($row_p = mysqli_fetch_array($query_p)); } ?>
</select>
<span>Provincia</span>
<i class="fas fa-check-circle"></i>
<i class="fas fa-exclamation-circle"></i>
<small>Error Msg</small>