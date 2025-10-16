<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');


include ('../app/controllers/usuarios/listado_de_usuarios.php');


?>

<!-- Contenedor Principal (contiene el contenido de la página) -->
<div class="content-wrapper">
    <!-- Encabezado -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">LISTADO DE USUARIOS</h1>
                </div><!-- Fin columna -->
            </div><!-- Fin fila -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Fin Encabezado -->


    <!-- Contenido Principal -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">USUARIOS REGISTRADOS</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><center>ID Usuario</center></th>
                                    <th><center>Nombre</center></th>
                                    <th><center>Correo</center></th>
                                    <th><center>Rol del Usuario</center></th>
                                    <th><center>Extensión</center></th>
                                    <th><center>Acciones</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $contador = 0;
                                foreach ($usuarios_datos as $usuarios_dato){
                                    $id_usuario = $usuarios_dato['id_usuario']; ?>
                                    <tr>
                                        <td><center><?php echo $contador = $contador + 1;?></center></td>
                                        <td><?php echo $usuarios_dato['nombres'];?></td>
                                        <td><?php echo $usuarios_dato['email'];?></td>
                                        <td><center><?php echo $usuarios_dato['rol'];?></center></td>
                                        <td><center><?php echo $usuarios_dato['extension'];?></center></td>
                                        <td>
                                            <center>
                                                <div class="btn-group">
                                                    <a href="show.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-info"><i class="fa fa-eye"></i> Ver</a>
                                                    <a href="update.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-success"><i class="fa fa-pencil-alt"></i> Editar</a>
                                                    <a href="delete.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar</a>
                                                </div>
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


<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>

<!-- Script para el funcionamiento de la tabla de usuarios -->
<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
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
                        title: 'Reporte Usuarios',
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Solo exporta las dos primeras columnas
                        }
                    }, {
                        extend: 'pdf',
                        title: 'Reporte Usuarios',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Solo exporta las dos primeras columnas
                        }
                    }, {
                        extend: 'csv',
                        title: 'Reporte Usuarios',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Solo exporta las dos primeras columnas
                        }
                    }, {
                        extend: 'excel',
                        title: 'Reporte Usuarios',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Solo exporta las 4 primeras columnas
                        }
                    }, {
                        text: 'Imprimir',
                        extend: 'print',
                        title: 'Reporte Usuarios',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Solo exporta las dos primeras columnas
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

</script>
