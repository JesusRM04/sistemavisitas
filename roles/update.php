<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

$id_rol_get = $_GET['id'];


// Obtener datos del rol
$sql_rol = "SELECT * FROM roles WHERE id_rol = :id_rol";
$query_rol = $pdo->prepare($sql_rol);
$query_rol->execute([':id_rol' => $id_rol_get]);
$rol_dato = $query_rol->fetch(PDO::FETCH_ASSOC);

$nombre_rol = $rol_dato['nombre_rol'];
$descripcion = isset($rol_dato['descripcion']) ? $rol_dato['descripcion'] : '';

// Obtener todos los módulos
$sql_modulos = "SELECT * FROM modulos WHERE activo = TRUE ORDER BY orden ASC";
$query_modulos = $pdo->prepare($sql_modulos);
$query_modulos->execute();
$modulos = $query_modulos->fetchAll(PDO::FETCH_ASSOC);

// Obtener permisos actuales del rol CON ALCANCE
$sql_permisos = "SELECT id_modulo, puede_ver, puede_crear, puede_editar, puede_eliminar, puede_aprobar, alcance 
                 FROM permisos WHERE id_rol = :id_rol";
$query_permisos = $pdo->prepare($sql_permisos);
$query_permisos->execute([':id_rol' => $id_rol_get]);
$permisos_actuales = $query_permisos->fetchAll(PDO::FETCH_ASSOC);

// Convertir a array asociativo para fácil acceso
$permisos_rol = [];
foreach ($permisos_actuales as $p) {
    $permisos_rol[$p['id_modulo']] = [
        'ver' => $p['puede_ver'],
        'crear' => $p['puede_crear'],
        'editar' => $p['puede_editar'],
        'eliminar' => $p['puede_eliminar'],
        'aprobar' => $p['puede_aprobar'],
        'alcance' => $p['alcance'] ?? 'todos'
    ];
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Editar Rol: <?php echo $nombre_rol; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Modificar Rol y Permisos</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <form action="../app/controllers/roles/update.php" method="post">
                                <input type="hidden" name="id_rol" value="<?php echo $id_rol_get; ?>">
                                
                                <!-- Nombre del Rol -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombre del Rol <span class="text-danger">*</span></label>
                                            <input type="text" name="rol" class="form-control" 
                                                   value="<?php echo $nombre_rol; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Descripción (opcional)</label>
                                            <input type="text" name="descripcion" class="form-control" 
                                                   value="<?php echo $descripcion; ?>"
                                                   placeholder="Breve descripción del rol">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Tabla de Permisos -->
                                <h5 class="mb-3">
                                    <i class="fas fa-shield-alt"></i> Permisos por Módulo
                                </h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead style="background-color: #28a745; color: white;">
                                            <tr>
                                                <th width="25%">Módulo</th>
                                                <th width="12%" class="text-center">
                                                    <i class="fas fa-eye"></i> Ver
                                                </th>
                                                <th width="12%" class="text-center">
                                                    <i class="fas fa-plus"></i> Crear
                                                </th>
                                                <th width="12%" class="text-center">
                                                    <i class="fas fa-edit"></i> Editar
                                                </th>
                                                <th width="12%" class="text-center">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </th>
                                                <th width="10%" class="text-center">
                                                    <i class="fas fa-check-circle"></i> Aprobar
                                                </th>
                                                <th width="17%" class="text-center">
                                                    <i class="fas fa-filter"></i> Alcance
                                                </th>
                                                <th width="10%" class="text-center">
                                                    Todos
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($modulos as $modulo): 
                                                $id_mod = isset($modulo['id_modulo']) ? (int)$modulo['id_modulo'] : 0;
                                                if ($id_mod === 0) continue; // evita módulos corruptos

                                                $tiene_ver = isset($permisos_rol[$id_mod]) && $permisos_rol[$id_mod]['ver'];
                                                $tiene_crear = isset($permisos_rol[$id_mod]) && $permisos_rol[$id_mod]['crear'];
                                                $tiene_editar = isset($permisos_rol[$id_mod]) && $permisos_rol[$id_mod]['editar'];
                                                $tiene_eliminar = isset($permisos_rol[$id_mod]) && $permisos_rol[$id_mod]['eliminar'];
                                                $tiene_aprobar = isset($permisos_rol[$id_mod]) && $permisos_rol[$id_mod]['aprobar'];
                                                $alcance_actual = isset($permisos_rol[$id_mod]) ? $permisos_rol[$id_mod]['alcance'] : 'todos';
                                                $tiene_todos = $tiene_ver && $tiene_crear && $tiene_editar && $tiene_eliminar;
                                            ?>
                                            <tr>
                                                <td>
                                                    <i class="<?php echo $modulo['icono']; ?>"></i>
                                                    <strong><?php echo ucfirst($modulo['nombre_modulo']); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo $modulo['descripcion']; ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $id_mod; ?>][ver]" 
                                                           value="1" 
                                                           class="permiso-ver" 
                                                           data-modulo="<?php echo $id_mod; ?>"
                                                           <?php echo $tiene_ver ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $id_mod; ?>][crear]" 
                                                           value="1" 
                                                           class="permiso-accion" 
                                                           data-modulo="<?php echo $id_mod; ?>"
                                                           <?php echo $tiene_crear ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $id_mod; ?>][editar]" 
                                                           value="1" 
                                                           class="permiso-accion" 
                                                           data-modulo="<?php echo $id_mod; ?>"
                                                           <?php echo $tiene_editar ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $id_mod; ?>][eliminar]" 
                                                           value="1" 
                                                           class="permiso-accion" 
                                                           data-modulo="<?php echo $id_mod; ?>"
                                                           <?php echo $tiene_eliminar ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                        name="permisos[<?php echo $id_mod; ?>][aprobar]" 
                                                        value="1" 
                                                        class="permiso-accion" 
                                                        data-modulo="<?php echo $id_mod; ?>"
                                                        <?php echo ($tiene_aprobar ?? false) ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="text-center">
                                                    <select name="permisos[<?php echo $id_mod; ?>][alcance]" 
                                                            class="form-control form-control-sm" 
                                                            style="font-size: 12px;">
                                                        <option value="todos" <?php echo $alcance_actual == 'todos' ? 'selected' : ''; ?>>
                                                            Todos los registros
                                                        </option>
                                                        <option value="propios" <?php echo $alcance_actual == 'propios' ? 'selected' : ''; ?>>
                                                            Solo mis registros
                                                        </option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           class="check-todos" 
                                                           data-modulo="<?php echo $id_mod; ?>"
                                                           <?php echo $tiene_todos ? 'checked' : ''; ?>
                                                           title="Seleccionar todos">
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Alcance de permisos:</strong>
                                    <ul class="mb-0">
                                        <li><strong>Todos los registros:</strong> Puede ver/editar/eliminar cualquier registro del módulo</li>
                                        <li><strong>Solo mis registros:</strong> Solo puede ver/editar/eliminar sus propios registros</li>
                                    </ul>
                                </div>

                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Atención:</strong> Los cambios en permisos afectarán a todos los usuarios con este rol
                                </div>

                                <hr>
                                
                                <div class="form-group">
                                    <a href="index.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Actualizar Rol
                                    </button>
                                </div>
                            </form>
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
$(document).ready(function() {
    // Auto-activar "Ver" cuando se selecciona otra acción
    $('.permiso-accion').on('change', function() {
        if ($(this).is(':checked')) {
            var modulo = $(this).data('modulo');
            $('input.permiso-ver[data-modulo="' + modulo + '"]').prop('checked', true);
        }
    });
    
    // Checkbox "Todos"
    $('.check-todos').on('change', function() {
        var modulo = $(this).data('modulo');
        var checked = $(this).is(':checked');
        
        $('input[data-modulo="' + modulo + '"]').not('.check-todos').prop('checked', checked);
    });
    
    // Actualizar "Todos" si se cambian checkboxes individuales
        $('input[type="checkbox"]').not('.check-todos').on('change', function() {
        var modulo = $(this).data('modulo');
        var total = $('input[data-modulo="' + modulo + '"]').not('.check-todos').length;
        var checkedCount = $('input[data-modulo="' + modulo + '"]:checked').not('.check-todos').length;

        $('.check-todos[data-modulo="' + modulo + '"]').prop('checked', total === checkedCount);
    });

});
</script>