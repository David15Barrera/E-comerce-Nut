<?php

require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión
// Realizar la consulta SQL para obtener los servicios más usados
$sql = "SELECT p.titulo AS nombre_producto, SUM(v.total * 0.2) AS ingresos_totales
        FROM VENTAS v
        JOIN DETALLETRANSACCIONES dt ON v.idventas = dt.ventasid
        JOIN PUBLICACIONES p ON dt.publicacionesId = p.idPublicaciones
        GROUP BY p.titulo";

// Ejecutar la consulta SQL y obtener los resultados
$result = $pdo->query($sql);

// Crear un array para almacenar los resultados
$ingresostotales = array();

// Iterar sobre los resultados y agregarlos al array
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $ingresostotales[] = $row;
}

// Devolver los resultados como JSON
echo json_encode($ingresostotales);
?>
