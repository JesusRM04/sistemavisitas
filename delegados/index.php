<?php
include ('../app/config.php');
include ('../layout/sesion.php');

// 🔒 PROTEGER PÁGINA
protegerPagina('delegados', 'ver');

include ('../layout/parte1.php');

include ('../app/controllers/delegados/listado_de_delegados.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- ... código del header ... -->
    
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DELEGADOS REGISTRADOS</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><center>ID Delegado</center></th>
                                    <th><center>Nombre</center></th>
                                    <th><center>Correo</center></th>
                                    <th><center>Extensión</center></th>
                                    <th><center>Acciones</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $contador = 0;
                                foreach ($delegados_datos as $delegados_dato){
                                    $id_delegado = $delegados_dato['id_delegado']; 
                                    $contador++;
                                    ?>
                                    <tr>
                                        <td><center><?php echo $contador; ?></center></td>
                                        <td><center><?php echo $delegados_dato['nombres'];?></center></td>
                                        <td><center><?php echo $delegados_dato['email'];?></center></td>
                                        <td><center><?php echo $delegados_dato['extension'];?></center></td>
                                        <td>
                                            <center>
                                                <div class="btn-group">
                                                    <?php if (tienePermiso('delegados', 'ver')): ?>
                                                    <a href="show.php?id=<?php echo $id_delegado; ?>" class="btn btn-info">
                                                        <i class="fa fa-eye"></i> Ver
                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (tienePermiso('delegados', 'editar')): ?>
                                                    <a href="update.php?id=<?php echo $id_delegado; ?>" class="btn btn-success">
                                                        <i class="fa fa-pencil-alt"></i> Editar
                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (tienePermiso('delegados', 'eliminar')): ?>
                                                    <a href="delete.php?id=<?php echo $id_delegado; ?>" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i> Borrar
                                                    </a>
                                                    <?php endif; ?>
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
        </div>
    </div>
</div>

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>

<!-- Script para el funcionamiento de la tabla de usuarios -->
<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Delegados",
                "infoEmpty": "Mostrando 0 a 0 de 0 Delegados",
                "infoFiltered": "(Filtrado de _MAX_ total Delegados)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Delegados",
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
                        title: 'Reporte Delegados',
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3] 
                        }
                    }, {
                        extend: 'pdf',
                        title: 'Reporte Delegados',
                        exportOptions: {
                            columns: [0, 1, 2, 3] 
                        }
                    }, {
                        extend: 'csv',
                        title: 'Reporte Delegados',
                        exportOptions: {
                            columns: [0, 1, 2, 3] 
                        }
                    }, {
                        extend: 'excel',
                        title: 'Reporte Delegados',
                        exportOptions: {
                            columns: [0, 1, 2, 3] 
                        }
                    }, {
                        text: 'Imprimir',
                        extend: 'print',
                        title: 'Reporte Delegados',
                        exportOptions: {
                            columns: [0, 1, 2, 3] 
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
