<?php
include ('../app/config.php');
include ('../layout/sesion.php');

// 🔒 PROTEGER PÁGINA
protegerPagina('visitas', 'ver');

include ('../layout/parte1.php');
include ('../app/controllers/visitas/visitas_aprobadas.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Visitas Aprobadas</h1>
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
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Visitas Aprobadas</h3>
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
                                       <th><center>Fecha Fin</center></th>
                                       <th><center>Motivo</center></th>
                                       <th><center>Aprobador</center></th>
                                       <th><center>Visitantes</center></th>
                                       <th><center>Descripción Vehículo</center></th>
                                       <th><center>Acciones</center></th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   <?php
                                   $contador = 0;
                                   foreach ($visitas_datos as $visitas_dato){
                                       $id_visita = $visitas_dato['id_visita'];
                                       $id_usuario_visita = $visitas_dato['id_usuario']; // 🔑 IMPORTANTE
                                       
                                       // 🔒 VERIFICAR SI PUEDE MODIFICAR ESTE REGISTRO
                                       $puede_editar = tienePermiso('visitas', 'editar') && 
                                                      $permisos->puedeModificarRegistro('visitas', $id_usuario_visita);
                                       $puede_eliminar = tienePermiso('visitas', 'eliminar') && 
                                                        $permisos->puedeModificarRegistro('visitas', $id_usuario_visita);
                                       ?>
                                       <tr>
                                           <td><center><?php echo $contador = $contador + 1; ?></center></td>
                                           <td><center><?php echo $visitas_dato['nombre_usuario'];?></center></td>
                                           <td><center><?php echo $visitas_dato['institucion']; ?></center></td>
                                           <td><center><?php echo $visitas_dato['nombre_delegado'];?></center></td>
                                           <td><center><?php echo $visitas_dato['nombre_area'];?></center></td>
                                           <td><center><?php echo $visitas_dato['fecha_hora'];?></center></td>
                                           <td><center><?php echo $visitas_dato['fecha_fin'];?></center></td>
                                           <td><?php echo $visitas_dato['motivo'];?></td>
                                           <td><center><?php echo $visitas_dato['aprobador'];?></span></center></td>
                                           <td>
                                                <center>
                                                    <?php if (!empty($visitas_dato['invitados'])): ?>
                                                    <span title="<?php echo str_replace('<br>', '&#10;', $visitas_dato['invitados']); ?>"
                                                        style="cursor: help; color: #007bff; white-space: pre-line;">Ver invitados</span>
                                                    <span style="display:none;"><?php echo $visitas_dato['invitados']; ?></span>
                                                    <?php else: ?>
                                                    <span style="color: gray;">Sin invitados</span>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                           <td><?php echo $visitas_dato['comentario_admin'];?></td>
                                           <td>
                                               <center>
                                                   <div class="btn-group">
                                                       <a href="show.php?id=<?php echo $id_visita; ?>" type="button" class="btn btn-info btn-sm">
                                                           <i class="fa fa-eye"></i> Ver
                                                       </a>
                                                       
                                                       <?php if ($puede_editar): ?>
                                                       <a href="update.php?id=<?php echo $id_visita; ?>" type="button" class="btn btn-success btn-sm">
                                                           <i class="fa fa-pencil-alt"></i> Editar
                                                       </a>
                                                       <?php endif; ?>
                                                       
                                                       <?php if ($puede_eliminar): ?>
                                                       <a href="delete.php?id=<?php echo $id_visita; ?>" type="button" class="btn btn-danger btn-sm">
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

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>

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
            buttons: [
    {
        extend: 'collection',
        text: 'Reportes',
        orientation: 'landscape',
        buttons: [
            {
                extend: 'copy',
                text: 'Copiar',
                title: 'Reporte Visitas',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                    format: {
                        body: function (data, row, column, node) {
                            if (column === 9) {
                                const hidden = $(node).find('span[style*="display:none"]').html();
                                if (hidden) {
                                    return hidden.replace(/<br\s*\/?>/gi, '\n');
                                }
                            }
                            return $(node).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'pdf',
                text: 'Exportar PDF',
                title: 'Reporte Visitas',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                    format: {
                        body: function (data, row, column, node) {
                            if (column === 9) {
                                const hidden = $(node).find('span[style*="display:none"]').html();
                                if (hidden) {
                                    return hidden.replace(/<br\s*\/?>/gi, '\n');
                                }
                            }
                            return $(node).text().trim();
                        }
                    }
                },
                customize: function (doc) {
                    doc.styles.tableBodyOdd.alignment = 'left';
                    doc.styles.tableBodyEven.alignment = 'left';
                    doc.defaultStyle.fontSize = 9;
                }
            },
            {
                extend: 'csv',
                text: 'Exportar CSV',
                title: 'Reporte Visitas',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                    format: {
                        body: function (data, row, column, node) {
                            if (column === 9) {
                                const hidden = $(node).find('span[style*="display:none"]').html();
                                if (hidden) {
                                    return hidden.replace(/<br\s*\/?>/gi, '\n');
                                }
                            }
                            return $(node).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'excel',
                text: 'Exportar Excel',
                title: 'Reporte Visitas',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                    format: {
                        body: function (data, row, column, node) {
                            if (column === 9) {
                                const hidden = $(node).find('span[style*="display:none"]').html();
                                if (hidden) {
                                    return hidden.replace(/<br\s*\/?>/gi, '\n');
                                }
                            }
                            return $(node).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                title: 'Reporte Visitas',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                    format: {
                        body: function (data, row, column, node) {
                            if (column === 9) {
                                const hidden = $(node).find('span[style*="display:none"]').html();
                                if (hidden) {
                                    return hidden.replace(/<br\s*\/?>/gi, '<br>');
                                }
                            }
                            return $(node).text().trim();
                        }
                    }
                },
                customize: function (win) {
                    $(win.document.body).find('table tbody td').each(function() {
                        $(this).html($(this).html().replace(/\n/g, '<br>'));
                    });
                }
            }
        ]
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