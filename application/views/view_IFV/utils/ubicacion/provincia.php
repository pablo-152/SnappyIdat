<label class="control-label text-bold">Provincia:</label>

<?php
if ($mode === 'editar') {
    // Si estás en modo 'editar', cambia el nombre, el id y la función onchange
    echo '<select class="form-control" name="provincia_e" id="provincia_e" onchange="Distrito(\'editar\');">';
} else {
    // En modo 'registrar', utiliza el nombre, el id y la función onchange predeterminados
    echo '<select class="form-control" name="provincia" id="provincia" onchange="Distrito();">';
}

echo '<option value="0">Seleccione</option>';

foreach ($list_provincia as $list) {
    echo '<option value="' . $list['id_provincia'] . '">' . $list['nombre_provincia'] . '</option>';
}

echo '</select>';
?>
