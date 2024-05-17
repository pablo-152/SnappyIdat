<label class="control-label text-bold">Distrito:</label>

<?php
if ($mode === 'editar') {
    echo '<select class="form-control" name="distrito_e" id="distrito_e">';
} else {
    echo '<select class="form-control" name="distrito" id="distrito">';
}

echo '<option value="0">Seleccione</option>';

foreach ($list_distrito as $list) {
    echo '<option value="' . $list['id_distrito'] . '">' . $list['nombre_distrito'] . '</option>';
}

echo '</select>';
?>
