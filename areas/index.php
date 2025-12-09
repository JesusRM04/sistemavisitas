<?php
include ('../app/config.php');
include ('../layout/sesion.php');
// 🔒 PROTEGER PÁGINA
protegerPagina('areas', 'ver');

include('../layout/parte1.php');


include ('../app/controllers/areas/listado_de_areas.php');


?>

<!-- Contenedor Principal (contiene el contenido de la página) -->
<div class="content-wrapper">
    <!-- Encabezado -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Áreas
                        <?php if (tienePermiso('areas', 'crear')): ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> Agregar Nueva
                        </button>
                        <?php endif; ?>
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Fin Encabezado -->


    <!-- Contenido Principal -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Áreas Registradas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre de Área</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($areas_datos as $areas_dato) {
                                        $id_area = $areas_dato['id_area'];
                                        $nombre_area = $areas_dato['nombre_area']; ?>
                                        <tr>
                                            <td>
                                                <center><?php echo $contador = $contador + 1; ?></center>
                                            </td>
                                            <td><center><?php echo $areas_dato['nombre_area']; ?></center></td>
                                            <td>
                                                <center>
                                                    <?php if (tienePermiso('areas', 'editar')): ?>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                                            data-target="#modal-update<?php echo $id_area; ?>">
                                                            <i class="fa fa-pencil-alt"></i> Editar
                                                        </button>
                                                        <!-- Modal para Actualizar Área -->
                                                        <div class="modal fade" id="modal-update<?php echo $id_area; ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: #116f4a;color: white">
                                                                        <h4 class="modal-title">Actualización de Área</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="">Nombre de Área</label>
                                                                                    <input type="text" id="nombre_area<?php echo $id_area; ?>" value="<?php echo $nombre_area; ?>" class="form-control" required>
                                                                                    <small style="color: red;display: none" id="lbl_update<?php echo $id_area; ?>">* Este campo es requerido</small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                                        <button type="button" class="btn btn-success" id="btn_update<?php echo $id_area; ?>">Actualizar</button>
                                                                    </div>
                                                                </div>
                                                                <!-- Fin Contenido Modal -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                        <!-- Fin Modal -->
                                                        <script>
                                                            $('#btn_update<?php echo $id_area; ?>').click(function() {
                                                                var nombre_area = $('#nombre_area<?php echo $id_area; ?>').val();
                                                                var id_area = '<?php echo $id_area; ?>';

                                                                if (nombre_area == "") {
                                                                    $('#nombre_area<?php echo $id_area; ?>').focus();
                                                                    $('#lbl_update<?php echo $id_area; ?>').css('display', 'block');
                                                                } else {
                                                                    var url = "../app/controllers/areas/update_de_areas.php";
                                                                    $.get(url, {
                                                                        nombre_area: nombre_area,
                                                                        id_area: id_area
                                                                    }, function(datos) {
                                                                        $('#respuesta_update<?php echo $id_area; ?>').html(datos);
                                                                    });
                                                                }
                                                            });
                                                        </script>
                                                        <div id="respuesta_update<?php echo $id_area; ?>"></div>
                                                    </div>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Fin Contenido Principal -->
</div>
<!-- Fin Contenedor Principal -->


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<!-- Script para el funcionamiento de la tabla de áreas -->
<!-- Script para el funcionamiento de la tabla de roles -->
<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Áreas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Áreas",
                "infoFiltered": "(Filtrado de _MAX_ total Áreas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Áreas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            buttons: [{
                    extend: 'collection',
                    text: 'Reportes',
                    orientation: 'landscape',
                    buttons: [{
                        text: 'Copiar',
                        title: 'Reporte Áreas',
                        extend: 'copy',
                    }, {
                        extend: 'pdf',
                        title: 'Reporte Áreas'
                    }, {
                        extend: 'csv',
                        title: 'Reporte Áreas'
                    }, {
                        extend: 'excel',
                        title: 'Reporte Áreas',
                        exportOptions: {
                            columns: [0, 1] // Solo exporta las dos primeras columnas
                        }
                    }, {
                        text: 'Imprimir',
                        extend: 'print',
                        title: 'Reporte Áreas',
                        exportOptions: {
                            columns: [0, 1] // Solo exporta las dos primeras columnas
                        }
                    }]
                },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>





<!-- Modal para Registrar Áreas -->
 <?php if (tienePermiso('areas', 'crear')): ?>
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Creación de una Nueva Área</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nombre de la Nueva Área <b>*</b></label>
                            <input type="text" id="nombre_area" class="form-control" required>
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php endif; ?>
<!-- /.modal -->

<script>
    $('#btn_create').click(function() {
        // alert("guardar");
        var nombre_area = $('#nombre_area').val();

        if (nombre_area == "") {
            $('#nombre_area').focus();
            $('#lbl_create').css('display', 'block');
        } else {
            var url = "../app/controllers/areas/registro_de_areas.php";
            $.get(url, {
                nombre_area: nombre_area
            }, function(datos) {
                $('#respuesta').html(datos);
            });
        }
    });
</script>
<div id="respuesta"></div>