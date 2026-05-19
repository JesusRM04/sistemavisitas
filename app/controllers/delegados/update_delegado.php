<?php

$id_delegado_get = $_GET['id'];

$sql_delegados = "SELECT 
    id_delegado AS id_delegado, 
    nombre AS nombre, 
    correo AS correo, 
    ext AS extension
FROM delegados
WHERE id_delegado = :id_delegado";
$query_delegados = $pdo->prepare($sql_delegados);
$query_delegados->execute([':id_delegado' => $id_delegado_get]);
$delegados_datos = $query_delegados->fetchAll(PDO::FETCH_ASSOC);

foreach ($delegados_datos as $delegados_dato) {
    $nombres = $delegados_dato['nombre'];
    $email = $delegados_dato['correo'];
    $ext = $delegados_dato['extension'];
}
