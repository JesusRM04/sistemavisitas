<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');


include ('../app/controllers/visitas/listado_de_visitas.php');


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Visitas Pendientes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Visitas Pendientes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                           <div class="table table-responsive">
                               <table id="example1" class="table table-bordered table-striped table-sm">
                                   <thead>
                                   <tr>
                                       <th><center>Nro</center></th>
                                       <th><center>Solicitante</center></th>
                                       <th><center>Institución</center></th>
                                       <th><center>Delegado</center></th>
                                       <th><center>Área</center></th>
                                       <th><center>Fecha</center></th>
                                       <th><center>Hora</center></th>
                                       <th><center>Motivo</center></th>
                                       <th><center>Estado</center></th>
                                       <th><center>Descripción Vehículo</center></th>
                                       <th><center>Acciones</center></th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   <?php
                                   $contador = 0;
                                   foreach ($visitas_datos as $visitas_dato){
                                       $id_visita = $visitas_dato['id_visita']; 
                                       // Separar fecha y hora
                                       $fecha_formateada = date('d/m/Y', strtotime($visitas_dato['fecha_hora']));
                                       $hora_formateada = date('H:i', strtotime($visitas_dato['fecha_hora']));
                                       ?>
                                       <tr>
                                           <td><center><?php echo $contador = $contador + 1; ?></center></td>
                                           <td><center><?php echo $visitas_dato['nombre_usuario'];?></center></td>
                                           <td><center><?php echo $visitas_dato['institucion'];?></center></td>
                                           <td><center><?php echo $visitas_dato['nombre_delegado'];?></center></td>
                                           <td><center><?php echo $visitas_dato['nombre_area'];?></center></td>
                                           <td><center><?php echo $fecha_formateada;?></center></td>
                                           <td><center><?php echo $hora_formateada;?></center></td>
                                           <td><?php echo $visitas_dato['motivo'];?></td>
                                           <td><center><span class="badge badge-warning"><?php echo $visitas_dato['estado'];?></span></center></td>
                                           <td><?php echo $visitas_dato['comentario_admin'];?></td>
                                           <td>
                                               <center>
                                                   <div class="btn-group">
                                                       <a href="show.php?id=<?php echo $id_visita; ?>" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                                       <a href="update.php?id=<?php echo $id_visita; ?>" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i> Editar</a>
                                                       <a href="delete.php?id=<?php echo $id_visita; ?>" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</a>
                                                       <a href="../app/controllers/visitas/aprobar.php?id=<?php echo $id_visita; ?>" type="button" class="btn btn-secondary btn-sm" onclick="return confirm('¿Está seguro de Autorizar esta Visita?')"><i class="fa fa-circle-check"></i> Autorizar</a>
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

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>

<!-- Script para el funcionamiento de la tabla de visitas -->
<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Visitas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Visitas",
                "infoFiltered": "(Filtrado de _MAX_ total Visitas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Visitas",
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
                        title: 'Reporte Visitas',
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] 
                        }
                    }, {
                        extend: 'pdf',
                        title: 'Reporte Visitas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] 
                        }
                    }, {
                        extend: 'csv',
                        title: 'Reporte Visitas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] 
                        }
                    }, {
                        extend: 'excel',
                        title: 'Reporte Visitas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] 
                        }
                    }, {
                        text: 'Imprimir',
                        extend: 'print',
                        title: 'Reporte Visitas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] 
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
