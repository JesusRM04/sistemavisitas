<?php
include ('../../config.php');

$nombre_area = $_GET['nombre_area'];
$id_area = $_GET['id_area'];

$sentencia = $pdo->prepare("UPDATE areas
    SET nombre_area=:nombre_area
    WHERE id_area = :id_area ");

$sentencia->bindParam('nombre_area',$nombre_area);
$sentencia->bindParam('id_area',$id_area);
if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = "El Área se Actualizó de Manera Correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/areas";
    </script>
    <?php
}else{
    session_start();
    $_SESSION['mensaje'] = "Error, NO se pudo Actualizar en la BD";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/areas";
    </script>
    <?php
}



