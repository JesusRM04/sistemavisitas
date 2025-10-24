<?php
include ('../../config.php');

$nombre_area = $_GET['nombre_area'];

$sentencia = $pdo->prepare("INSERT INTO areas
       ( nombre_area) 
VALUES (:nombre_area)");

$sentencia->bindParam('nombre_area',$nombre_area);
if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = "Se Registró la Área de Manera Correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/areas";
    </script>
    <?php
}else{
    session_start();
    $_SESSION['mensaje'] = "Error, NO se pudo Registrar en la BD";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/areas";
    </script>
    <?php
}
