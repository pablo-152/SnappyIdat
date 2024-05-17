(function(){

  $("tr td #delete_asignatura").click(function(ev){
      ev.preventDefault();
      var nombre = $(this).parents('tr').find('td:first').text();
      var id = $(this).attr('data-id');
      var self = this;
      Swal({
          title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
          text: "El registro será eliminado permanentemente",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
        }).then((result) => {
          if (result.value) {
            // ajax ....  
            $.ajax({
              type: 'POST',
              url: '/new_snappy/index.php?/Ceba/Delete_asignatura',
              data: {'id_asignatura':id},
              success: function(){
                $(self).parents('tr').remove();
                Swal(
                  'Eliminado!',
                  'El registro ha sido eliminado satisfactoriamente.',
                  'success'
                )
              },statusCode: {
                400: function(data){
                  var json = JSON.parse(data.responseText);
                  Swal(
                    'Error!',
                    json.msg,
                    'error'
                  )
                }
              }
            });
      
          }
      })
  })




})();