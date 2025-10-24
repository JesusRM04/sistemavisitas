<?php

$id_delegado_get = $_GET['id'];

$sql_delegados = "SELECT 
    id_delegado AS id_delegado, 
    nombre AS nombres, 
    correo AS email, 
    ext AS extension
FROM delegados
WHERE id_delegado = :id_delegado";

$query_delegados = $pdo->prepare($sql_delegados);
$query_delegados->bindParam(':id_delegado', $id_delegado_get);
$query_delegados->execute();
$delegados_dato = $query_delegados->fetch(PDO::FETCH_ASSOC);

if ($delegados_dato) {
    $nombres = $delegados_dato['nombres'];
    $email = $delegados_dato['email'];
    $ext = $delegados_dato['extension'];
} else {
    $nombres = $email = $ext = '';
}
