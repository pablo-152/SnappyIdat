<?php
    require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    $id_departamento=$_POST['id_departamento'];

    $query_r=mysqli_query($con, "SELECT * FROM provincia WHERE id_departamento=$id_departamento");
    $row_r=mysqli_fetch_array($query_r);
    $totalRows_r = mysqli_num_rows($query_r);
?>

<select id="id_provincia" class="selectformulario" name="id_provincia">
    <option value="0">Seleccione provincia</option>
    <?php
    if ($totalRows_r > 0){
        do {  
        ?>
        <option value="<?php echo $row_r['id_provincia']?>"><?php echo utf8_encode($row_r['nombre_provincia'])?></option>
    <?php
        } while ($row_r = mysqli_fetch_array($query_r));
    }

    ?>
</select>