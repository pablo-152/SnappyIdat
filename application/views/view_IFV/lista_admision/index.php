<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    table tbody tr td:nth-child(1),table tbody tr td:nth-child(2),table tbody tr td:nth-child(5),table tbody tr td:nth-child(6),table tbody tr td:nth-child(10){
        text-align: center;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Documentos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Enviar_Correo()" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/enviar.png" alt="Enviar"/>
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_Lista_Admision') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <form method="post" id="formulario" enctype="multipart/form-data" action="<?= site_url('AppIFV/archivar')?>" class="formulario">
                <div class="col-lg-12">
                    <input type="hidden" id="cadena" name="cadena" value="">
                    <input type="hidden" id="cantidad" name="cantidad" value="0">
                    <input type="hidden" id="prueba" name="prueba">

                    <table class="table table-hover table-striped table-bordered" id="example" width="100%">
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                                <th class="text-center" width="3%"><input type="checkbox" style="width: 20px" id="total" name="total" value="1"></th>
                                <th class="text-center" width="5%">Código</th>
                                <th class="text-center" width="8%">Estado</th>
                                <th class="text-center" width="17%">Especialidad</th>
                                <th class="text-center" width="7%">Grupo</th>
                                <th class="text-center" width="7%" title="Nr Documento">Nr Doc.</th>
                                <th class="text-center" width="12%">Apellido Paterno</th>
                                <th class="text-center" width="12%">Apellido Materno</th>
                                <th class="text-center" width="12%">Nombre</th>
                                <th class="text-center" width="9%" title="Fecha Inscripción">Fecha Ins.</th>
                                <th class="text-center" width="8%">Creado Por</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_admision as $list){ ?>                                           
                                <tr class="even pointer text-center">
                                    <td><input type="checkbox" id="correos[]" name="correos[]" value="<?php echo $list['Email']; ?>"></td>
                                    <td><?php echo $list['Id']; ?></td>
                                    <td><?php echo ""; ?></td>
                                    <td class="text-left"><?php echo $list['Especialidad']; ?></td>
                                    <td><?php echo $list['Grupo']; ?></td>
                                    <td><?php echo $list['IdentityCardNumber']; ?></td>
                                    <td class="text-left"><?php echo $list['FatherSurname']; ?></td>
                                    <td class="text-left"><?php echo $list['MotherSurname']; ?></td>
                                    <td class="text-left"><?php echo $list['FirstName']; ?></td>
                                    <td><?php echo $list['Fecha_Inscripcion']; ?></td>
                                    <td class="text-left"><?php echo $list['Creado_Por']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informes").addClass('active');
        $("#hinformes").attr('aria-expanded', 'true');
        $("#documentos_alumnos").addClass('active');
		document.getElementById("rinformes").style.display = "block";

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title==""){
                $(this).html( '' );
            }else{
                $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
            }
            
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table=$('#example').DataTable( {
            order: [1,"desc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0 ]
                }
            ]
        } );

        // Seleccionar todo en la tabla
        let $dt = $('#example');
        let $total = $('#total');
        let $cadena = $('#cadena');
        let $cantidad = $('#cantidad');
  
        // Cuando hacen click en el checkbox del thead
        $dt.on('change', 'thead input', function (evt) {
            var tipo=$('#prueba').val();
            if(tipo==""){
                let checked = this.checked;
                let total = 0;
                let data = [];
                let cadena='';
                
                table.data().each(function (info) {
                var txt = info[0];
                    if (checked) {
                        total += 1;
                        txt = txt.substr(0, txt.length - 1) + ' checked>';
                        cadena += info[1]+",";
                    } else {
                        txt = txt.replace(' checked', '');
                    }
                    info[0] = txt;
                    data.push(info);
                });
                
                table.clear().rows.add(data).draw();
                $cantidad.val(total);
                $cadena.val(cadena);
            }else{
                if (document.getElementById('total').checked)
                {
                    var inp=document.getElementsByTagName('input');
                    for(var i=0, l=inp.length;i<l;i++){
                        if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='correos')
                            inp[i].checked=1;
                    }
                }

                else
                {
                    let checked = this.checked;
                    let total = 0;
                    let data = [];
                    let cadena='';
                    
                    table.data().each(function (info) {
                    var txt = info[0];
                        if (checked) {
                            total += 1;
                            txt = txt.substr(0, txt.length - 1) + ' checked>';
                            cadena += info[1]+",";
                        } else {
                            txt = txt.replace(' checked', '');
                        }
                        info[0] = txt;
                        data.push(info);
                    });
                    
                    table.clear().rows.add(data).draw();
                    $cantidad.val(total);
                    $cadena.val(cadena);
                } 
            }
        });
  
        // Cuando hacen click en los checkbox del tbody
        $dt.on('change', 'tbody input', function() {
            let q= $('#cadena').val();
            let cantidad= $('#cantidad').val();
            let info = table.row($(this).closest('tr')).data();
            let total = parseFloat($total.val());
            let cadena = $cadena.val();
            let price = parseFloat(info[1]);
            let cadena2 = info[1]+",";
            //total += this.checked ? price : price * -1;
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
            //cadena += this.checked ? cadena2 : info[1]+", ";
            
        });
    });

    function Enviar_Correo(){
        var contadorf=$('#cantidad').val();
        
        if(contadorf>0){
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

            var dataString = new FormData(document.getElementById('formulario'));
            var url="<?php echo site_url(); ?>AppIFV/Enviar_Correo_Admision";

            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Envío Exitoso',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Lista_Admision";
                    });
                }
            });
        }else{
            Swal(
                'Ups!',
                'Debe seleccionar al menos 1 Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>