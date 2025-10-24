<?php
$sql_areas = "SELECT * FROM areas ";
$query_areas = $pdo->prepare($sql_areas);
$query_areas->execute();
$areas_datos = $query_areas->fetchAll(PDO::FETCH_ASSOC);