<?php

$id_usuario_get = $_GET['id'];

$sql_usuarios = "SELECT us.id_usuario as id_usuario, us.nombre as nombre, us.correo as correo, us.extension as extension, rol.nombre_rol as rol 
                  FROM usuarios as us INNER JOIN roles as rol ON us.id_rol = rol.id_rol where id_usuario = '$id_usuario_get' ";
$query_usuarios = $pdo->prepare($sql_usuarios);
$query_usuarios->execute();
$usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios_datos as $usuarios_dato){
    $nombres = $usuarios_dato['nombre'];
    $email = $usuarios_dato['correo'];
    $rol = $usuarios_dato['rol'];
    $ext = $usuarios_dato['extension'];
}