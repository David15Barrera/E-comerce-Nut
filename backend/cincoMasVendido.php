<?php
// Incluir el archivo de conexión a la base de datos
require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

try {
    // Consulta SQL para obtener los 5 productos con más ventas
    $sql = "SELECT p.idPublicaciones, p.titulo, COUNT(dt.publicacionesId) AS total_ventas, u.name, u.lastname AS nombre_usuario
                FROM PUBLICACIONES p
                INNER JOIN DETALLETRANSACCIONES dt ON p.idPublicaciones = dt.publicacionesId
                INNER JOIN USUARIODATOS u ON p.userId = u.idUserdatos
                GROUP BY p.idPublicaciones
                ORDER BY total_ventas DESC
                LIMIT 5";

    // Preparar la consulta
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados de la consulta
    $productos_mas_vendidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar los resultados como JSON
    echo json_encode($productos_mas_vendidos);
} catch (PDOException $e) {
    // Manejar cualquier error de la base de datos
    echo json_encode(array("success" => false, "message" => "Error al obtener los productos más vendidos: " . $e->getMessage()));
}
?>
