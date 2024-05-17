<?php $this->load->view('view_CA/header'); ?>
<?php $this->load->view('view_CA/nav'); ?>

<div class="row">
</div>

<script>
    $(document).ready(function() {
        var mensaje = '<?= $mensaje; ?>';
        var titulo = '<?= $titulo; ?>';
        var tipo = '<?= $tipo; ?>';

        Swal(
            ''+titulo,
            ''+mensaje,
            ''+tipo
        ).then(function() { 
            window.location = "<?= site_url('Ca/Cargo')?>";
        });
    });
</script>

<?php $this->load->view('view_CA/footer'); ?>