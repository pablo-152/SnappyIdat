<link rel="stylesheet" href="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.css')?>">
<script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>
<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>

<script>
    $(document).ready(function() {
        document.title = "Validación de correo";

        var mensaje = '<?= $mensaje; ?>';
        var titulo = '<?= $titulo; ?>';
        var tipo = '<?= $tipo; ?>';

        Swal(
            ''+titulo,
            ''+mensaje,
            ''+tipo
        ).then(function() { 
            window.close();
        });
    });
</script>
