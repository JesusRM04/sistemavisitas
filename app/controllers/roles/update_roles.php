<?php
$id_rol_get = $_GET['id'];

// Obtener datos del rol
$sql_rol = "SELECT * FROM roles WHERE id_rol = :id_rol";
$query_rol = $pdo->prepare($sql_rol);
$query_rol->execute([':id_rol' => $id_rol_get]);
$rol_dato = $query_rol->fetch(PDO::FETCH_ASSOC);

$nombre_rol = $rol_dato['nombre_rol'];
$descripcion = isset($rol_dato['descripcion']) ? $rol_dato['descripcion'] : '';

// Obtener permisos actuales del rol CON ALCANCE
$sql_permisos = "SELECT id_modulo, puede_ver, puede_crear, puede_editar, puede_eliminar, alcance 
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
        'alcance' => $p['alcance'] ?? 'todos'
    ];
}
?>