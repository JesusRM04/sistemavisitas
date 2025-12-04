<?php
include('../../config.php');

session_start();

$id_rol = $_POST['id_rol'];
$nombre_rol = strtoupper(trim($_POST['rol']));
$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null;
$permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];

try {
    // Iniciar transacción
    $pdo->beginTransaction();
    
    // 1. Actualizar el rol
    $sql_rol = "UPDATE roles SET nombre_rol = :nombre_rol, descripcion = :descripcion WHERE id_rol = :id_rol";
    $stmt_rol = $pdo->prepare($sql_rol);
    $stmt_rol->execute([
        ':nombre_rol' => $nombre_rol,
        ':descripcion' => $descripcion,
        ':id_rol' => $id_rol
    ]);
    
    // 2. Eliminar permisos anteriores
    $sql_delete = "DELETE FROM permisos WHERE id_rol = :id_rol";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([':id_rol' => $id_rol]);
    
    // 3. Insertar los nuevos permisos CON ALCANCE Y APROBAR
    $sql_permiso = "INSERT INTO permisos 
        (id_rol, id_modulo, puede_ver, puede_crear, puede_editar, puede_eliminar, puede_aprobar, alcance) 
        VALUES 
        (:id_rol, :id_modulo, :puede_ver, :puede_crear, :puede_editar, :puede_eliminar, :puede_aprobar, :alcance)";
    
    $stmt_permiso = $pdo->prepare($sql_permiso);
    
    foreach ($permisos as $id_modulo => $acciones) {
        $puede_ver      = isset($acciones['ver'])      ? 1 : 0;
        $puede_crear    = isset($acciones['crear'])    ? 1 : 0;
        $puede_editar   = isset($acciones['editar'])   ? 1 : 0;
        $puede_eliminar = isset($acciones['eliminar']) ? 1 : 0;
        $puede_aprobar  = isset($acciones['aprobar'])  ? 1 : 0;
        $alcance = isset($acciones['alcance']) ? $acciones['alcance'] : 'todos';
        
        // Solo insertar si tiene al menos un permiso
        if ($puede_ver || $puede_crear || $puede_editar || $puede_eliminar || $puede_aprobar) {
            // Si tiene alguna acción, debe poder ver
            if ($puede_crear || $puede_editar || $puede_eliminar || $puede_aprobar) {
                $puede_ver = 1;
            }
            
            $stmt_permiso->execute([
                ':id_rol' => $id_rol,
                ':id_modulo' => $id_modulo,
                ':puede_ver' => $puede_ver,
                ':puede_crear' => $puede_crear,
                ':puede_editar' => $puede_editar,
                ':puede_eliminar' => $puede_eliminar,
                ':puede_aprobar' => $puede_aprobar, // 🆕 ESTO ES NUEVO
                ':alcance' => $alcance
            ]);
        }
    }
    
    // Confirmar transacción
    $pdo->commit();
    
    $_SESSION['mensaje'] = "Se actualizó el rol '$nombre_rol' con sus permisos correctamente";
    $_SESSION['icono'] = "success";
    header('Location: ' . $URL . '/roles');
    
} catch (PDOException $e) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    
    if ($e->getCode() == '23505') {
        $_SESSION['mensaje'] = "Error: Ya existe un rol con ese nombre";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el rol: " . $e->getMessage();
    }
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/roles/update.php?id=' . $id_rol);
}

exit;
?>