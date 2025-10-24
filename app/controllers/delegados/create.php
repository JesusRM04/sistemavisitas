<?php

include ('../../config.php');

$nombre_delegado = $_POST['nombre'];
$extension = $_POST['ext'];
$email = $_POST['correo'];

$sentencia = $pdo->prepare("INSERT INTO delegados
       ( nombre, ext, correo, fyh_creacion) 
VALUES (:nombre,:ext,:correo,:fyh_creacion)");

$sentencia->bindParam('nombre',$nombre_delegado);
$sentencia->bindParam('ext',$extension);
$sentencia->bindParam('correo',$email);
$sentencia->bindParam('fyh_creacion',$fechaHora);


if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = "Se registró al Delegado de Manera Correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/delegados";
    </script>
    <?php
}else{
    session_start();
    $_SESSION['mensaje'] = "Error, NO se pudo Registrar en la BD";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/delegados";
    </script>
    <?php
}
