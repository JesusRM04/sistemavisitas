<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Obtener todos los módulos
$sql_modulos = "SELECT * FROM modulos WHERE activo = TRUE ORDER BY orden ASC";
$query_modulos = $pdo->prepare($sql_modulos);
$query_modulos->execute();
$modulos = $query_modulos->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de Roles</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Configurar Rol y Permisos</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <form action="../app/controllers/roles/create.php" method="post">
                                
                                <!-- Nombre del Rol -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombre del Rol <span class="text-danger">*</span></label>
                                            <input type="text" name="rol" class="form-control" 
                                                   placeholder="Ej: SUPERVISOR, GERENTE, etc." required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Descripción (opcional)</label>
                                            <input type="text" name="descripcion" class="form-control" 
                                                   placeholder="Breve descripción del rol">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Tabla de Permisos -->
                                <h5 class="mb-3">Permisos por Módulo</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead style="background-color: #611232; color: white;">
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
                                                <th width="17%" class="text-center">
                                                    <i class="fas fa-filter"></i> Alcance
                                                </th>
                                                <th width="10%" class="text-center">
                                                    Todos
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($modulos as $modulo): ?>
                                            <tr>
                                                <td>
                                                    <i class="<?php echo $modulo['icono']; ?>"></i>
                                                    <strong><?php echo ucfirst($modulo['nombre_modulo']); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo $modulo['descripcion']; ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $modulo['id_modulo']; ?>][ver]" 
                                                           value="1" 
                                                           class="permiso-ver" 
                                                           data-modulo="<?php echo $modulo['id_modulo']; ?>">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $modulo['id_modulo']; ?>][crear]" 
                                                           value="1" 
                                                           class="permiso-accion" 
                                                           data-modulo="<?php echo $modulo['id_modulo']; ?>">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $modulo['id_modulo']; ?>][editar]" 
                                                           value="1" 
                                                           class="permiso-accion" 
                                                           data-modulo="<?php echo $modulo['id_modulo']; ?>">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="permisos[<?php echo $modulo['id_modulo']; ?>][eliminar]" 
                                                           value="1" 
                                                           class="permiso-accion" 
                                                           data-modulo="<?php echo $modulo['id_modulo']; ?>">
                                                </td>
                                                <td class="text-center">
                                                    <select name="permisos[<?php echo $modulo['id_modulo']; ?>][alcance]" 
                                                            class="form-control form-control-sm" 
                                                            style="font-size: 12px;">
                                                        <option value="todos">Todos los registros</option>
                                                        <option value="propios">Solo mis registros</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           class="check-todos" 
                                                           data-modulo="<?php echo $modulo['id_modulo']; ?>"
                                                           title="Seleccionar todos">
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Nota:</strong> Si seleccionas crear/editar/eliminar, se activará automáticamente el permiso de "Ver"
                                </div>

                                <hr>
                                
                                <div class="form-group">
                                    <a href="index.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Guardar Rol
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
        var checked = $('input[data-modulo="' + modulo + '"]').not('.check-todos'):checked').length;
        
        $('.check-todos[data-modulo="' + modulo + '"]').prop('checked', total === checked);
    });
});
</script>