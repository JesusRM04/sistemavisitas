<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/usuarios/listado_de_usuarios.php');
include('../app/controllers/delegados/listado_de_delegados.php');
include('../app/controllers/areas/listado_de_areas.php');
include('../app/controllers/visitas/show.php');

// Separar fecha y hora del timestamp
$fecha_solo = date('Y-m-d', strtotime($fecha_hora));
$hora_solo = date('H:i', strtotime($fecha_hora));

// Asegurar que fecha_fin existe
if (!empty($fecha_fin)) {
    $fecha_fin_solo = date('Y-m-d', strtotime($fecha_fin));
    $hora_fin_solo  = date('H:i', strtotime($fecha_fin));
} else {
    $fecha_fin_solo = '';
    $hora_fin_solo  = '';
}

// Separar fecha y hora de fecha_fin
$fecha_fin_solo = date('Y-m-d', strtotime($fecha_fin));
$hora_fin_solo = date('H:i', strtotime($fecha_fin));

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualizar Visita</h1>
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
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form action="../app/controllers/visitas/update.php" method="post">
                                        <input type="text" value="<?php echo $id_visita_get; ?>" name="id_visita" hidden>

                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <!-- Apartado para Solicitante -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Solicitante:</label>
                                                            <div style="display: flex">
                                                                <input type="text" class="form-control" value="<?php echo $nombres_sesion; ?>" disabled>
                                                                <input type="text" name="id_usuario" value="<?php echo $id_usuario_sesion; ?>" hidden>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Apartado para Área -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Área:</label>
                                                            <div style="display: flex">
                                                                <select name="id_area" class="form-control" required>
                                                                    <?php
                                                                    foreach ($areas_datos as $area_dato) {
                                                                        $nombre_area_tabla = $area_dato['nombre_area'];
                                                                        $id_area_tabla = $area_dato['id_area']; ?>
                                                                        <option value="<?php echo $id_area_tabla; ?>" <?php if ($nombre_area_tabla == $nombre_area) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo $nombre_area_tabla; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Apartado para Delegado -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Delegado</label>
                                                            <div style="display: flex">
                                                                <select name="id_delegado" id="" class="form-control" required>
                                                                    <?php
                                                                    foreach ($delegados_datos as $delegados_dato) {
                                                                        $selected = ($delegados_dato['nombres'] == $nombre_delegado) ? 'selected' : '';
                                                                        ?>
                                                                        <option value="<?php echo $delegados_dato['id_delegado']; ?>" <?php echo $selected; ?>>
                                                                            <?php echo $delegados_dato['nombres']; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Institución -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Institución de Procedencia:</label>
                                                            <input type="text" name="institucion" value="<?php echo $institucion; ?>" class="form-control" placeholder="Ej: Universidad Autónoma, Empresa XYZ, etc." required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Motivo -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Motivo:</label>
                                                            <input type="text" name="motivo" value="<?php echo $motivo; ?>" class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <!-- Apartado para Estado -->
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Estado:</label>
                                                            <input type="text" class="form-control" value="<?php echo $estado; ?>" disabled>
                                                            <input type="text" name="estado" value="PENDIENTE" hidden>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Invitados -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Nombres de los Visitantes:</label>
                                                            <small class="text-muted">(Ingrese un nombre por línea)</small>
                                                            <textarea name="invitados" cols="30" rows="4" class="form-control" required><?php echo $invitados_texto; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Comentarios/Descripción -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Descripción Vehículo (Si Aplica):</label>
                                                            <textarea name="comentario_admin" cols="30" rows="3" class="form-control"><?php echo $comentario_admin; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                                <!-- Apartado para Fecha -->
                                                <div class="form-group">
                                                    <label for="">Fecha de Visita:</label>
                                                    <input type="date" id="fecha_ingreso" name="fecha_visita" value="<?php echo $fecha_solo; ?>" class="form-control" required>
                                                    <small id="errorFecha" style="color: red; display: none;">La fecha no puede ser anterior a hoy</small>
                                                </div>

                                                <!-- Apartado para Hora -->
                                                <div class="form-group">
                                                    <label for="">Hora de Visita:</label>
                                                    <input type="time" id="hora_visita" name="hora_visita" value="<?php echo $hora_solo; ?>" class="form-control" required>
                                                    <small class="text-muted">Formato 24 horas</small>
                                                </div>

                                                <!-- Apartado para Fecha Fin -->
                                                <div class="form-group">
                                                    <label for="">Fecha Fin de Visita:</label>
                                                    <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin_solo; ?>" class="form-control" required>
                                                    <small id="errorFechaFin" style="color: red; display: none;">La fecha fin debe ser posterior a la fecha de inicio</small>
                                                </div>

                                                <!-- Apartado para Hora Fin -->
                                                <div class="form-group">
                                                    <label for="">Hora Fin de Visita:</label>
                                                    <input type="time" id="hora_fin" name="hora_fin" value="<?php echo $hora_fin_solo; ?>" class="form-control" required>
                                                    <small class="text-muted">Formato 24 horas</small>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <a href="<?php echo ($estado == 'APROBADO') ? 'aprobadas.php' : 'index.php'; ?>" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-success">Actualizar Visita</button>
                                        </div>
                                    </form>
                                </div>
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

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<!-- Script para validar fecha en el formulario -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputFecha = document.getElementById('fecha_ingreso');
        const inputHora = document.getElementById('hora_visita');
        const inputFechaFin = document.getElementById('fecha_fin');
        const inputHoraFin = document.getElementById('hora_fin');
        const errorFecha = document.getElementById('errorFecha');
        const errorFechaFin = document.getElementById('errorFechaFin');

        // Establecer fecha mínima (hoy)
        const hoy = new Date().toISOString().split('T')[0];
        inputFecha.setAttribute('min', hoy);
        inputFechaFin.setAttribute('min', hoy);

        // Función para validar fecha de inicio
        function validarFechaInicio() {
            const fechaSeleccionada = new Date(inputFecha.value);
            const fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0);

            if (fechaSeleccionada < fechaActual) {
                errorFecha.style.display = 'block';
                inputFecha.value = '';
                return false;
            } else {
                errorFecha.style.display = 'none';
                return true;
            }
        }

        // Función para validar fecha fin
        function validarFechaFin() {
            const fechaInicio = new Date(inputFecha.value + 'T' + inputHora.value);
            const fechaFin = new Date(inputFechaFin.value + 'T' + inputHoraFin.value);

            if (fechaFin <= fechaInicio) {
                errorFechaFin.style.display = 'block';
                return false;
            } else {
                errorFechaFin.style.display = 'none';
                return true;
            }
        }

        // Validar fecha de inicio al cambiar
        inputFecha.addEventListener('change', validarFechaInicio);

        // Validar fecha fin al cambiar cualquier campo relacionado
        [inputFecha, inputHora, inputFechaFin, inputHoraFin].forEach(element => {
            element.addEventListener('change', validarFechaFin);
        });

        // Validar al enviar el formulario
        inputFecha.form.addEventListener('submit', function(e) {
            const fechaSeleccionada = new Date(inputFecha.value);
            const fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0);

            if (fechaSeleccionada < fechaActual) {
                e.preventDefault();
                errorFecha.style.display = 'block';
                inputFecha.focus();
                return;
            }

            const fechaInicio = new Date(inputFecha.value + 'T' + inputHora.value);
            const fechaFin = new Date(inputFechaFin.value + 'T' + inputHoraFin.value);

            if (fechaFin <= fechaInicio) {
                e.preventDefault();
                errorFechaFin.style.display = 'block';
                inputFechaFin.focus();
            }
        });
    });
</script>
