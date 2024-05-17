<form  method="post" id="formularioxls" enctype="multipart/form-data" action="<?= site_url('Administrador/Excel_Inscripcion')?>" class="formulario">
  <input type="hidden" name="id_status" id="id_status" value="<?php echo $status; ?> ">
</form>

<table id="example" class="table table-hover table-bordered table-striped" width="100%">
  <thead>
    <tr style="background-color: #E5E5E5;">
      <th class="text-center" width="5%" title="Código">Cod.</th>
      <th class="text-center" width="22%">Evento</th>
      <th class="text-center" width="4%" title="Empresa">Emp.</th>
      <th class="text-center" width="20%">Nombre</th>
      <th class="text-center" width="12%">Correo</th>
      <th class="text-center" width="6%" title="Celular">Cel.</th>
      <th class="text-center" width="19%">Grado</th>
      <th class="text-center" width="5%" title="Fecha Registro">F. Reg.</th>
      <th class="text-center" width="5%">Estado</th>
      <th class="text-center" width="2%"></th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($row_p as $row_p) {  ?>
      <tr class="even pointer">
        <td class="text-center"><?php echo $row_p['cod_inscripcion']; ?></td>
        <td><?php echo $row_p['nom_evento']; ?></td>
        <td class="text-center"><?php echo $row_p['cod_empresa']; ?></td>
        <td><?php echo substr($row_p['nombres'],0,50); ?></td>
        <td><?php echo $row_p['correo']; ?></td>
        <td class="text-center"><?php echo $row_p['celular']; ?></td>
        <td><?php if($row_p['id_conversatorio']!=0){ echo $row_p['nom_conversatorio']; }else{ echo $row_p['nom_producto_interes']; } ?></td>
        <td class="text-center"><?php echo $row_p['fecha_registro']; ?></td>
        <td class="text-center"><?php echo $row_p['nom_estadoi']; ?></td>
        <td class="text-center">
          <a type="button" title="Editar Inscripción" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Editar_Inscripcion') ?>/<?php echo $row_p['id_inscripcion']; ?>"> <img src="<?= base_url() ?>images/editar.png" 
          style="cursor:pointer; cursor: hand;" width="22" height="22"></a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $('#example thead tr').clone(true).appendTo('#example thead');
    $('#example thead tr:eq(1) th').each(function(i) {
      var title = $(this).text();

      if(title==""){
        $(this).html('');
      }else{
        $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
      }

      $('input', this).on('keyup change', function() {
        if (table.column(i).search() !== this.value) {
          table
          .column(i)
          .search(this.value)
          .draw();
        }
      });
    });

    var table = $('#example').DataTable({
      ordering: false,
      orderCellsTop: true,
      fixedHeader: true,
      pageLength: 50
    });
  });
</script>

