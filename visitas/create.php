<?php
include('../app/config.php');
include('../layout/sesion.php');

// 🔒 PROTEGER PÁGINA - Solo usuarios con permiso de crear
protegerPagina('visitas', 'crear');

include('../layout/parte1.php');
include('../app/controllers/visitas/listado_de_visitas.php');
include('../app/controllers/usuarios/listado_de_usuarios.php');
include('../app/controllers/areas/listado_de_areas.php');
include('../app/controllers/delegados/listado_de_delegados.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de Visita</h1>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Llene los Datos con Cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form action="../app/controllers/visitas/create.php" method="post" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <!-- Apartado para Solicitante -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Solicitante:</label>
                                                            <div style="display: flex">
                                                                <input type="text" class="form-control" value="<?php echo $nombres_sesion; ?>" disabled>
                                                                <input type="text" name="nombre_usuario" value="<?php echo $id_usuario_sesion; ?>" hidden>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Apartado para Área -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Área:</label>
                                                            <div style="display: flex">
                                                                <select name="nombre_area" id="" class="form-control" required>
                                                                    <option value="" disabled selected>Seleccionar…</option>
                                                                    <?php
                                                                    foreach ($areas_datos as $areas_dato) { ?>
                                                                        <option value="<?php echo $areas_dato['id_area']; ?>">
                                                                            <?php echo $areas_dato['nombre_area']; ?>
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
                                                                <select name="nombre_delegado" id="" class="form-control" required>
                                                                    <option value="" disabled selected>Seleccionar…</option>
                                                                    <?php
                                                                    foreach ($delegados_datos as $delegados_dato) { ?>
                                                                        <option value="<?php echo $delegados_dato['id_delegado']; ?>">
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
                                                            <input type="text" name="institucion" class="form-control" placeholder="Ej: Universidad Autónoma, Empresa XYZ, etc." required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Motivo -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Motivo:</label>
                                                            <textarea name="motivo" id="" cols="30" rows="2" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Apartado para Estado (oculto) -->
                                                    <div class="col-md-8" hidden>
                                                        <div class="form-group">
                                                            <label for="">Estado:</label>
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
                                                            <textarea name="invitados" id="invitados" cols="30" rows="4" class="form-control" placeholder="Ejemplo:&#10;Juan Pérez García&#10;María López Rodríguez&#10;Carlos Martínez López" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Descripción -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Descripción Vehículo (Si Aplica):</label>
                                                            <textarea name="comentario_admin" id="" cols="30" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                                <h5 class="text-center mb-3" style="color: #611232;">Periodo de Visita</h5>
                                                
                                                <!-- Fecha y Hora de Inicio -->
                                                <div class="form-group">
                                                    <label for="">Fecha Inicio:</label>
                                                    <input type="date"
                                                        name="fecha_inicio"
                                                        id="fecha_inicio"
                                                        class="form-control"
                                                        required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Hora Inicio:</label>
                                                    <input type="time"
                                                        name="hora_inicio"
                                                        id="hora_inicio"
                                                        class="form-control"
                                                        required>
                                                </div>

                                                <hr style="border-top: 2px dashed #b89457;">

                                                <!-- Fecha y Hora de Fin -->
                                                <div class="form-group">
                                                    <label for="">Fecha Fin:</label>
                                                    <input type="date"
                                                        name="fecha_fin"
                                                        id="fecha_fin"
                                                        class="form-control"
                                                        required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Hora Fin:</label>
                                                    <input type="time"
                                                        name="hora_fin"
                                                        id="hora_fin"
                                                        class="form-control"
                                                        required>
                                                </div>

                                                <small class="text-danger" style="display:none;" id="errorFechas">
                                                    La fecha/hora de fin debe ser posterior a la de inicio
                                                </small>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-primary">Registrar Visita</button>
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

<!-- Script para validar fechas en el formulario -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInicio = document.getElementById('fecha_inicio');
        const horaInicio = document.getElementById('hora_inicio');
        const fechaFin = document.getElementById('fecha_fin');
        const horaFin = document.getElementById('hora_fin');
        const errorFechas = document.getElementById('errorFechas');
        const formulario = fechaInicio.form;

        const ahora = new Date();
        const hoy = ahora.toISOString().split('T')[0];
        const horaActual = ahora.getHours().toString().padStart(2, '0') + ':' + ahora.getMinutes().toString().padStart(2, '0');

        fechaInicio.setAttribute('min', hoy);
        fechaFin.setAttribute('min', hoy);

        function validarRangoFechas() {
            if (!fechaInicio.value || !horaInicio.value || !fechaFin.value || !horaFin.value) {
                return true;
            }

            const inicio = new Date(fechaInicio.value + 'T' + horaInicio.value);
            const fin = new Date(fechaFin.value + 'T' + horaFin.value);

            if (fechaInicio.value === hoy) {
                if (horaInicio.value <= horaActual) {
                    errorFechas.textContent = 'La hora de inicio debe ser posterior a la hora actual (' + horaActual + ')';
                    errorFechas.style.display = 'block';
                    return false;
                }
            }

            if (fechaInicio.value < hoy) {
                errorFechas.textContent = 'La fecha de inicio no puede ser anterior a hoy';
                errorFechas.style.display = 'block';
                return false;
            }

            if (fin <= inicio) {
                if (fechaFin.value === fechaInicio.value) {
                    errorFechas.textContent = 'La hora de fin debe ser posterior a la hora de inicio';
                } else {
                    errorFechas.textContent = 'La fecha/hora de fin debe ser posterior a la de inicio';
                }
                errorFechas.style.display = 'block';
                return false;
            }

            errorFechas.style.display = 'none';
            return true;
        }

        fechaInicio.addEventListener('change', function() {
            fechaFin.setAttribute('min', this.value);
            if (fechaFin.value && fechaFin.value < this.value) {
                fechaFin.value = this.value;
            }
            validarRangoFechas();
        });

        [fechaInicio, horaInicio, fechaFin, horaFin].forEach(campo => {
            campo.addEventListener('change', validarRangoFechas);
            campo.addEventListener('blur', validarRangoFechas);
        });

        formulario.addEventListener('submit', function(e) {
            if (!validarRangoFechas()) {
                e.preventDefault();
                errorFechas.scrollIntoView({ behavior: 'smooth', block: 'center' });
                fechaInicio.focus();
            }
        });
    });
</script>