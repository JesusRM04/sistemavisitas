<?php
include('../app/config.php');
include('../layout/sesion.php');

// 🔒 PROTEGER PÁGINA
protegerPagina('reportes', 'ver');


include('../layout/parte1.php');

// Obtener mes y año actual o del filtro
$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
$anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

// Consulta para obtener todas las visitas del mes seleccionado
$sql_visitas = "SELECT 
    v.id_visita,
    u.nombre AS nombre_usuario,
    d.nombre AS nombre_delegado,
    a.nombre_area AS nombre_area,
    v.fecha_hora,
    v.motivo,
    v.institucion,
    v.estado,
    v.comentario_admin,
    STRING_AGG(i.nombre, ', ' ORDER BY i.fecha_creacion) AS invitados
FROM visitas v
JOIN usuarios u ON v.id_usuario = u.id_usuario
JOIN delegados d ON v.id_delegado = d.id_delegado
JOIN areas a ON v.id_area = a.id_area
LEFT JOIN invitados i ON v.id_visita = i.id_visita
WHERE EXTRACT(MONTH FROM v.fecha_hora) = :mes 
  AND EXTRACT(YEAR FROM v.fecha_hora) = :anio
GROUP BY v.id_visita, u.nombre, d.nombre, a.nombre_area, v.fecha_hora, v.motivo, v.institucion, v.estado, v.comentario_admin
ORDER BY v.fecha_hora DESC";

$query_visitas = $pdo->prepare($sql_visitas);
$query_visitas->execute([':mes' => $mes, ':anio' => $anio]);
$visitas_datos = $query_visitas->fetchAll(PDO::FETCH_ASSOC);

// Estadísticas
$total_visitas = count($visitas_datos);
$pendientes = 0;
$aprobadas = 0;
$rechazadas = 0;

foreach ($visitas_datos as $visita) {
    switch ($visita['estado']) {
        case 'PENDIENTE':
            $pendientes++;
            break;
        case 'APROBADO':
            $aprobadas++;
            break;
        case 'RECHAZADO':
            $rechazadas++;
            break;
    }
}

// Array de meses en español
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reporte de Visitas - <?php echo $meses[(int)$mes] . ' ' . $anio; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $URL; ?>">Inicio</a></li>
                        <li class="breadcrumb-item active">Reportes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            
            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Filtrar por Mes y Año</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mes:</label>
                                            <select name="mes" class="form-control">
                                                <?php foreach ($meses as $num => $nombre) { ?>
                                                    <option value="<?php echo $num; ?>" <?php echo ($num == $mes) ? 'selected' : ''; ?>>
                                                        <?php echo $nombre; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Año:</label>
                                            <select name="anio" class="form-control">
                                                <?php 
                                                $anio_actual = date('Y');
                                                for ($i = $anio_actual; $i >= $anio_actual - 5; $i--) { ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $anio) ? 'selected' : ''; ?>>
                                                        <?php echo $i; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fas fa-filter"></i> Filtrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $total_visitas; ?></h3>
                            <p>Total de Visitas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $aprobadas; ?></h3>
                            <p>Aprobadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $pendientes; ?></h3>
                            <p>Pendientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $rechazadas; ?></h3>
                            <p>Rechazadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Visitas -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Listado Completo de Visitas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><center>Nro</center></th>
                                            <th><center>Fecha</center></th>
                                            <th><center>Hora</center></th>
                                            <th><center>Solicitante</center></th>
                                            <th><center>Institución</center></th>
                                            <th><center>Visitantes</center></th>
                                            <th><center>Delegado</center></th>
                                            <th><center>Área</center></th>
                                            <th><center>Motivo</center></th>
                                            <th><center>Estado</center></th>
                                            <th><center>Descripción Vehículo</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($visitas_datos as $visita) {
                                            $contador++;
                                            $fecha_formateada = date('d/m/Y', strtotime($visita['fecha_hora']));
                                            $hora_formateada = date('H:i', strtotime($visita['fecha_hora']));
                                            $institucion = isset($visita['institucion']) ? $visita['institucion'] : 'No especificado';
                                            
                                            // Color del badge según estado
                                            $badge_color = 'warning';
                                            if ($visita['estado'] == 'APROBADO') $badge_color = 'success';
                                            if ($visita['estado'] == 'RECHAZADO') $badge_color = 'danger';
                                        ?>
                                            <tr>
                                                <td><center><?php echo $contador; ?></center></td>
                                                <td><center><?php echo $fecha_formateada; ?></center></td>
                                                <td><center><?php echo $hora_formateada; ?></center></td>
                                                <td><?php echo $visita['nombre_usuario']; ?></td>
                                                <td><?php echo $institucion; ?></td>
                                                <td><?php echo $visita['invitados'] ? $visita['invitados'] : 'Sin invitados'; ?></td>
                                                <td><?php echo $visita['nombre_delegado']; ?></td>
                                                <td><?php echo $visita['nombre_area']; ?></td>
                                                <td><?php echo $visita['motivo']; ?></td>
                                                <td><center><span class="badge badge-<?php echo $badge_color; ?>"><?php echo $visita['estado']; ?></span></center></td>
                                                <td><?php echo $visita['comentario_admin']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Visitas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Visitas",
                "infoFiltered": "(Filtrado de _MAX_ total Visitas)",
                "lengthMenu": "Mostrar _MENU_ Visitas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
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
                    title: 'Reporte Visitas <?php echo $meses[(int)$mes] . " " . $anio; ?>',
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }, {
                    extend: 'pdf',
                    title: 'Reporte Visitas <?php echo $meses[(int)$mes] . " " . $anio; ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }, {
                    extend: 'csv',
                    title: 'Reporte Visitas <?php echo $meses[(int)$mes] . " " . $anio; ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }, {
                    extend: 'excel',
                    title: 'Reporte Visitas <?php echo $meses[(int)$mes] . " " . $anio; ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }, {
                    text: 'Imprimir',
                    extend: 'print',
                    title: 'Reporte Visitas <?php echo $meses[(int)$mes] . " " . $anio; ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]
                    }
                }]
            },
            {
                extend: 'colvis',
                text: 'Visor de columnas'
            }],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>