<style>
    .th_cuadro {
        border: 1px solid #000;
        height: 35px;
        text-align: center;
        vertical-align: middle;
    }

    .td_cuadro {
        border: 1px solid #000;
        height: 35px;
        text-align: center;
        vertical-align: middle;
    }

    .color_fondo{
        background-color: #E5E5E5;
    }
</style>

<table width="100%">
    <thead>
        <tr class="color_fondo">
            <th class="th_cuadro">Matriculados</th>
            <th class="th_cuadro">Sin Matricular</th>
        </tr>
    </thead>

    <tbody>
        <?php $i=0; $j=0; 
            foreach ($list_cuadro as $list) {  ?>
            <tr>
                <td class="td_cuadro"><?php echo $list['matriculados']; ?></td>
                <td class="td_cuadro"><?php echo $list['sin_matricular']; ?></td>
            </tr>
        <?php $i=$i+$list['matriculados']; $j=$j+$list['sin_matricular']; } ?>
        <tr class="color_fondo">
            <td class="td_cuadro"><?php echo $i; ?></td>
            <td class="td_cuadro"><?php echo $j; ?></td>
        </tr>
    </tbody>
</table>