<?php

$sql_usuarios = "SELECT us.id_usuario as id_usuario, us.nombre as nombres, us.correo as email, us.extension as extension, rol.nombre_rol as rol 
                  FROM usuarios as us INNER JOIN roles as rol ON us.id_rol = rol.id_rol ";
$query_usuarios = $pdo->prepare($sql_usuarios);
$query_usuarios->execute();
$usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);