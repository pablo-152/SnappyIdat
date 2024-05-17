<table class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr>
            <th class="text-center">Números</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php foreach($list_numeros as $list){ ?>
            <tr>
                <td><?php echo $list['numero']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>