function delete_row(e, url) {
        bootbox.confirm({
            title: "Eliminar Subdependencia",
            message: "¿Está  seguro de eliminar?",/*"+usuario+",*/
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Aceptar'
                }
            },
            callback: function (result) {
                if (result) {
                    $.get(url, function(data) {
                        // console.log(data);
                        //dataTable.row($(e).parents('tr')).remove().draw();
                        location.reload();
                    });
                }
            }
        });
}
