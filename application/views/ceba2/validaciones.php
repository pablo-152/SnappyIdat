<script>
    $(document).ready(function() {
        /**/var msgDate = '';
        var inputFocus = '';
    });

function Delete_Alumno(id){
    var id = id;
    //alert(id);
    var url="<?php echo site_url(); ?>Ceba2/Delete_Alumno";
    Swal({
        title: '¿Realmente desea eliminar el registro',
        text: "El registro será eliminado permanentemente",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type:"POST",
                url:url,
                data: {'id_alumno':id},
                success:function () {
                    Swal(
                        'Eliminado!',
                        'El registro ha sido eliminado satisfactoriamente.',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba2/Alumno";
                    });
                }
            });
        }
    })
}
/*------------------------------*/

    function Insert_Slide(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        //alert("slide");
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Valida_Insert_Slide";

        var dataString2 = new FormData(document.getElementById('formulario'));
        var url2="<?php echo site_url(); ?>Ceba2/Insert_Slide";
        if (valida_slide()) {
            bootbox.confirm({
                title: "Registrar Slide",
                message: "¿Desea registrar slide?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                        //return false;
                    }else{
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:dataString,
                            success:function (data) {
                                if(data=="error"){
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡El registro llegó al límite de Slides!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }else{
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                            swal.fire(
                                                'Registro Exitoso!',
                                                'Haga clic en el botón!',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>Ceba2/Temas";
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                } 
            });

            
        }    
    }

    function Insert_Slide_Detalle(){
        //alert("slide");    
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Valida_Insert_Slide";
        if (valida_slide()) {
            bootbox.confirm({
                title: "Registrar Slide",
                message: "¿Desea registrar slide?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                        //return false;
                    }else{
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:dataString,
                            success:function (data) {
                                if(data=="error")
                                {
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡El registro llegó al límite de Slides!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }
                                else
                                {
                                    swal.fire(
                                        'Registro Exitoso!',
                                        'Haga clic en el botón!',
                                        'success'
                                    ).then(function() {
                                        //window.location = "<?php echo site_url(); ?>Ceba2/Temas";
                                        $('#formulario').submit();
                                    });
                                }
                            }
                        });
                    }
                } 
            });

            
        }    
        else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function valida_slide() {
        if($('#id_grado').val().trim() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#referencia').val().trim() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_status').val().trim() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#orden').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tiempo').val() == '' || $('#tiempo').val() == '00:00') {
            Swal(
                'Ups!',
                'Debe ingresar Tiempo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_slide').val().trim() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#imagen_sl').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe cargar Archivo PNG o MP4.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function Update_Slide(){
        if (valida_update_slide()) {
            bootbox.confirm({
                title: "Actualizar Slide",
                message: "¿Desea actualizar slide?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                    }else{
                        swal.fire(
                                'Actualización Exitosa!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    $('#formulario').submit();
                                });
                    }
                } 
            });
            
        }    
        else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function valida_update_slide() {
            if($('#orden').val().trim() === '') {
                msgDate = 'Debe seleccionar un orden';
                inputFocus = '#orden';
                return false;
            }
            return true;
    }

    function Delete_Slide(id,id_tema){
            var id_tema = id_tema;
            var id = id;
            var url="<?php echo site_url(); ?>Ceba2/Delete_Slide";
            Swal({
                title: '¿Realmente desea eliminar el registro',
                text: "El registro será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: {'id_slide':id,'id_tema':id_tema},
                        success:function () {
                            Swal(
                                'Eliminado!',
                                'El registro ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id_tema;
                                
                            });
                        }
                    });
                }
            })
    }

    function Delete_Img_Slide(id,id_tema){
            var id_tema = id_tema;
            var id = id;
            var url="<?php echo site_url(); ?>Ceba2/Delete_Img_Slide";
            Swal({
                title: '¿Realmente desea eliminar imagen del registro',
                text: "El archivo será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: {'id_slide':id,'id_tema':id_tema},
                        success:function () {
                            Swal(
                                'Eliminado!',
                                'El archivo ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id_tema;
                                
                            });
                        }
                    });
                }
            })
    }
    /*--------------REGISTRO INTRO--------*/
    function Insert_Intro(id_tema){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });


        var id= id_tema;
        
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Valida_Insert_Intro";

        var dataString2 = new FormData(document.getElementById('formulario'));
        var url2="<?php echo site_url(); ?>Ceba2/Insert_Intro_Index";
        if (valida_intro()) {
            bootbox.confirm({
                title: "Registrar Intro",
                message: "¿Desea registrar intro?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                        //return false;
                    }else{
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:dataString,
                            success:function (data) {
                                if(data=="error"){
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡Intro para el grado y referencia ya existe!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }else{
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                            swal.fire(
                                                'Registro Exitoso!',
                                                'Haga clic en el botón!',
                                                'success'
                                            ).then(function() {
                                                if(id!="0"){
                                                    window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id;
                                                }else{
                                                    window.location = "<?php echo site_url(); ?>Ceba2/Temas";
                                                }
                                            });
                                        }
                                    }); 
                                }
                            }
                        });
                    }
                } 
            });
            
        }    
    }

    function valida_intro() {
        if($('#id_grado').val() == '0') { //validacion arreglada
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#referencia').val() == '0') { //validacion arreglada
            Swal(
                'Ups!',
                'Debe seleccionar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_status').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#orden').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fotoimg').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe cargar Primera Imagen.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#foto2').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe cargar Segunda Imagen.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#foto3').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe cargar Tercera Imagen.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Update_Intro(){
        if (valida_update_intro()) {
            bootbox.confirm({
                title: "Actualizar Intro",
                message: "¿Desea actualizar intro?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                    }else{
                        swal.fire(
                                'Actualización Exitosa!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    $('#formulario').submit();
                                });
                    }
                } 
            });
            
        }    
        else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

function valida_update_intro() {
        if($('#orden').val().trim() === '') {
            msgDate = 'Debe seleccionar un orden';
            inputFocus = '#orden';
            return false;
        }
        return true;
}

    function Delete_Intro(id, id_tema){
        var id = id;
        var id_tema = id_tema;
        var url="<?php echo site_url(); ?>Ceba2/Delete_Intro";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_intro':id,'id_tema':id_tema},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id_tema;
                            
                        });
                    }
                });
            }
        })
    }
    
    function Delete_Img1_Intro(){

        bootbox.confirm({
            title: "Eliminar Archivo",
            message: "¿Desea eliminar archivo?",
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Confirmar'
                }
            },
            callback: function (result) {
                if (result==false) {
                }else{
                    swal.fire(
                            'Eliminación Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                            ).then(function() {
                                $('#formulario_img1').submit();
                            });
                }
            } 
        });
    }

    function Descargar_Img1_Intro(){
        var introduccion1 = $("#introduccion1").val();
        var foto_introduccion1 = $("#foto_introduccion1").val();
        window.location.replace("<?php echo site_url(); ?>Ceba2/Descargar_Img_Intro/" + introduccion1 + "/" + foto_introduccion1);
    }

    function Delete_Img2_Intro(){

        bootbox.confirm({
            title: "Eliminar Archivo",
            message: "¿Desea eliminar archivo?",
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Confirmar'
                }
            },
            callback: function (result) {
                if (result==false) {
                }else{
                    swal.fire(
                            'Eliminación Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                            ).then(function() {
                                $('#formulario_img2').submit();
                            });
                }
            } 
        });
    }

    function Descargar_Img2_Intro(){
        var introduccion2 = $("#introduccion2").val();
        var foto_introduccion2 = $("#foto_introduccion2").val();
        window.location.replace("<?php echo site_url(); ?>Ceba2/Descargar_Img_Intro/" + introduccion2 + "/" + foto_introduccion2);
    }

    function Delete_Img3_Intro(){
        bootbox.confirm({
            title: "Eliminar Archivo",
            message: "¿Desea eliminar archivo?",
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Confirmar'
                }
            },
            callback: function (result) {
                if (result==false) {
                }else{
                    swal.fire(
                            'Eliminación Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                            ).then(function() {
                                $('#formulario_img3').submit();
                            });
                }
            } 
        });
    }

    function Descargar_Img3_Intro(){
        var introduccion3 = $("#introduccion3").val();
        var foto_introduccion3 = $("#foto_introduccion3").val();
        window.location.replace("<?php echo site_url(); ?>Ceba2/Descargar_Img_Intro/" + introduccion3 + "/" + foto_introduccion3);
    }


    /*------------------REGISTRO INTRO-----------*/
    function Insert_Repaso(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });


        //alert("repaso");
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Valida_Insert_Repaso";

        var dataString2 = new FormData(document.getElementById('formulario'));
        var url2="<?php echo site_url(); ?>Ceba2/Insert_Repaso";
        if (valida_repaso()) {
            bootbox.confirm({
                title: "Registrar Repaso",
                message: "¿Desea registrar repaso?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                        //return false;
                    }else{
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:dataString,
                            success:function (data) {
                                if(data=="error"){
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "Repaso para el grado y referencia ya existe!!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }else{
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                            swal.fire(
                                                'Registro Exitoso!',
                                                'Haga clic en el botón!',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>Ceba2/Temas";
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                } 
            });
        }    
    }

    function Delete_Repaso(id,id_tema){
            var id_tema = id_tema;
            var id = id;
            var url="<?php echo site_url(); ?>Ceba2/Delete_Repaso";
            Swal({
                title: '¿Realmente desea eliminar el registro',
                text: "El registro será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: {'id_repaso':id,'id_tema':id_tema},
                        success:function () {
                            Swal(
                                'Eliminado!',
                                'El registro ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id_tema;
                                
                            });
                        }
                    });
                }
            })
    }

    function Delete_Img_Repaso(id,id_tema){
            var id_tema = id_tema;
            var id = id;
            var url="<?php echo site_url(); ?>Ceba2/Delete_Img_Repaso";
            Swal({
                title: '¿Realmente desea eliminar imágen del registro',
                text: "El archivo será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: {'id_repaso':id,'id_tema':id_tema},
                        success:function () {
                            Swal(
                                'Eliminado!',
                                'La imágen ha sido eliminada satisfactoriamente.',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id_tema;
                                
                            });
                        }
                    });
                }
            })
    }

    function Update_Repaso(){
        if (valida_update_repaso()) {
            bootbox.confirm({
                title: "Actualizar Repaso",
                message: "¿Desea actualizar repaso?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                    }else{
                        swal.fire(
                                'Actualización Exitosa!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    $('#formulario').submit();
                                });
                    }
                } 
            });
            
        }    
        else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function valida_update_repaso() {
            if($('#orden').val().trim() === '') {
                msgDate = 'Debe seleccionar un orden';
                inputFocus = '#orden';
                return false;
            }
            if($('#tiempo').val().trim() === '') {
                msgDate = 'Debe seleccionar un tiempo';
                inputFocus = '#tiempo';
                return false;
            }
            return true;
    }

    function valida_repaso() {
        if($('#id_grado').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#referencia').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#orden').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tiempo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tiempo.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_status').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#imagen').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe cargar Archivo PNG o MP4.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function Insert_Examen(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });


        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Valida_Insert_Examen_Index";

        var dataString2 = new FormData(document.getElementById('formulario'));
        var url2="<?php echo site_url(); ?>Ceba2/Insert_Examen";
        if (valida_examen()) {
            bootbox.confirm({
                title: "Registrar Pregunta para Examen",
                message: "¿Desea registrar pregunta para examen?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                        //return false;
                    }else{
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:dataString,
                            success:function (data) {
                                if(data=="error"){
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡El examen llegó al límite de Preguntas!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }else{
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                            swal.fire(
                                                'Registro Exitoso!',
                                                'Haga clic en el botón!',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>Ceba2/Temas";
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                } 
            }); 
        }
    }

    function Insert_Examenv2(id_tema){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Valida_Insert_Examen_D";
        var id = id_tema;   
        var dataString2 = new FormData(document.getElementById('formulario'));
        var url2="<?php echo site_url(); ?>Ceba2/Insert_Examen_Detalle";
        if (valida_examen()) {
            bootbox.confirm({
                title: "Registrar Pregunta para Examen",
                message: "¿Desea registrar pregunta para examen?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                        //return false;
                    }else{
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:dataString,
                            success:function (data) {
                                if(data=="error")
                                {
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡El examen llegó al límite de Preguntas!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }
                                else
                                {
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                            swal.fire(
                                                'Registro Exitoso!',
                                                'Haga clic en el botón!',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id;
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                } 
            });

            
        }
        else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function valida_examen() {
        /*  R1=document.getElementById("respuesta1").checked;
        R2=document.getElementById("respuesta2").checked;
        R3=document.getElementById("respuesta3").checked;*/
        if($('#id_grado').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#referencia').val() == '0') { //ojo validacion
            Swal(
                'Ups!',
                'Debe seleccionar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#orden').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#pregunta').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Pregunta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alternativa1').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Primera Respuesta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alternativa2').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Segunda Respuesta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alternativa3').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tercera Respuesta.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#respuesta').val().trim() === '') {
            msgDate = 'Debe ingresar tercera respuesta';
            inputFocus = '#respuesta';
            return false;
        }
        if (R1==false && R2==false && R3==false)
        {
        msgDate = 'Debe seleccionar la respuesta correcta para la pregunta antes de registrar';
        return false;
        }*/
        return true;
    }

    function Delete_Examen(id,id_tema){
            var id_tema = id_tema;
            var id = id;
            var url="<?php echo site_url(); ?>Ceba2/Delete_Examen";
            Swal({
                title: '¿Realmente desea eliminar el registro',
                text: "El registro será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: {'id_examen':id,'id_tema':id_tema},
                        success:function () {
                            Swal(
                                'Eliminado!',
                                'El registro ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id_tema;
                                
                            });
                        }
                    });
                }
            })
    }

    function Delete_Img_Examen(id,id_tema){
            var id_tema = id_tema;
            var id = id;
            var url="<?php echo site_url(); ?>Ceba2/Delete_Img_Examen";
            Swal({
                title: '¿Realmente desea eliminar imágen del registro',
                text: "El archivo será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: {'id_examen':id,'id_tema':id_tema},
                        success:function () {
                            Swal(
                                'Eliminado!',
                                'El archivo ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>Ceba2/Modal_Tema_View1/"+id_tema;
                                
                            });
                        }
                    });
                }
            })
    }

    /*function Admision_Alumno(id) {
        var id = id;
        var url="<?php echo site_url(); ?>Ceba2/Admision_Alumno";
        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':id},
            success:function (data) {
                $('#lista_admision_alumno').html(data);
            }
        });
    }*/

    function Delete_Pago(id,id_alumno){
    var id = id;
    var id_alumno = id_alumno;
    //alert(id);
    var url="<?php echo site_url(); ?>Ceba2/Delete_Pago";
    Swal({
        title: '¿Realmente desea eliminar el pago?',
        text: "El registro será eliminado permanentemente",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type:"POST",
                url:url,
                data: {'id_pago':id, 'id_alumno':id_alumno},
                success:function () {
                    Swal(
                        'Eliminado!',
                        'El registro ha sido eliminado satisfactoriamente.',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba2/Detalles_Alumno/"+id_alumno;
                    });
                }
            });
        }
    })
    }
    function Exportar(){
        $('#formularioxls').submit();
    }

    function Exportar_Alumno(){
        $('#formularioxls').submit();
    }
    function Exportar_Postulante(){
        $('#postulantexls').submit();
    }

    function Exportar_Instruccion(){
        $('#formularioxls').submit();
    }

    /*------------------------------------------------------ */

    function BuscadorIns(id) {
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var id = id;
        var url="<?php echo site_url(); ?>Ceba2/BuscadorIns";
        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':id},
            success:function (data) {
                $('#lista_temas').html(data);
            }
        });
    }

    function Actualizar_Observaciones(id){
        var dataString = $("#form-observaciones").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Actualizar_Observaciones";
        var id=id;

        $.ajax({
            type:"POST",
            url:url,
            data:dataString,
            success:function(){
                window.location = "<?php echo site_url(); ?>Ceba2/Detalles_Alumno/"+id;
            }
        });
    }

    function Delete_Pregunta_Admision(id,id_area,id_examen)
    {
        var id = id;
        var id_area = id_area;
        var id_examen = id_examen;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Pregunta_Admision";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_pregunta':id,'id_examen':id_examen},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Preguntas/"+id_area+"/"+id_examen;
                        });
                    }
                });
            }
        })
    }

    function Delete_Carrera(id_carrera)
    {

        var id_carrera = id_carrera;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Carrera";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_carrera':id_carrera},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Carrera";
                        });
                    }
                });
            }
        })
    }

    function Delete_Area(id_area)
    {

        var id_area = id_area;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Area";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_area':id_area},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Area";
                        });
                    }
                });
            }
        })
    }
    //-----------------------------------------ELIMINAR CENTRO-----------------------------------------------
    function Delete_Centro(id){
        var id = id;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Centro";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_centro':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Centro";
                        });
                    }
                });
            }
        })
    }
    //-----------------------------------------ELIMINAR ASIGNACION CICLO-----------------------------------------------
    function Delete_Asignacion_Ciclo(id){
        var id = id;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Asignacion_Ciclo";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_asignacion_ciclo':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Asignacion_Ciclo";
                        });
                    }
                });
            }
        })
    }
    //-----------------------------------------ELIMINAR ASIGNACION MODULO-----------------------------------------------
    function Delete_Asignacion_Modulo(id){
        var id = id;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Asignacion_Modulo";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_asignacion_modulo':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Asignacion_Modulo";
                        });
                    }
                });
            }
        })
    }
    //----------------------------------------MENSAJES---------------------------------------------------------
    function Insert_Mensaje(){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Insert_Mensaje";
        if (Valida_Mensaje()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function () {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba2/Mensaje";
                    });
                }
            });
        }
    }

    function Valida_Mensaje() {
        if($('#telefono').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Teléfono.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mensaje').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Mensaje.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    //------------------------------------REQUISITO MATRICULA-------------------------------//
    function Insert_Requisito_Matricula(){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Insert_Requisito_Matricula";
        if (Valida_Requisito()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function () {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba2/Requisito";
                    });
                }
            });
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    

    function Actualizar_Requisito_Matricula(){
        var dataString = $("#formulario_actu").serialize();
        var url="<?php echo site_url(); ?>Ceba2/Update_Requisito_Matricula";
        if (Valida_Requisito()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function () {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba2/Requisito";
                    });
                }
            });
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Requisito() {
        if($('#codigo').val().trim() === '') {
            msgDate = 'Debe ingresar Código.';
            inputFocus = '#codigo';
            return false;
        }
        if($('#nombre').val() == '') {
            msgDate = 'Debe ingresar Nombre.';
            inputFocus = '#nombre';
            return false;
        }
        if($('#modal').val()==2){
            if($('#id_status').val() == '0') {
                msgDate = 'Debe seleccionar Estado.';
                inputFocus = '#id_status';
                return false;
            }
        }
        return true;
    }

    function Delete_Requisito_Matricula(id){
        var id = id;
        var url="<?php echo site_url(); ?>Ceba2/Delete_Requisito_Matricula";
        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_requisito_m':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Ceba2/Requisito";
                        });
                    }
                });
            }
        })
    } 

    function Matricular(id){
        var id_alumno=id;
        var dataString = new FormData(document.getElementById('formulario_matricula'));
        var url="<?php echo site_url(); ?>Ceba2/Registrar_Matricula";
        Swal({
                //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
                title: '¿Realmente desea realizar matrícula?',
                text: "Se crearán los pagos automáticamente.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url: url,
                        data:dataString,
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            swal.fire(
                                'Actualización Exitosa!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Ceba2/Detalles_Alumno/"+id_alumno;
                                    
                                });
                            
                        }
                    });
                }
            })        
        
    }

    function soloNumeros(e) {
        var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        //letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
        letras = "0123456789",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

        for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
        }
    }
</script>
