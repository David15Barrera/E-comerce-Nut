<?php
// Incluir archivo de conexión a la base de datos
include_once "connection.php";

// Verificar si se recibió el ID del producto como parámetro
if (isset($_GET['id'])) {
    // Obtener el ID del producto desde la URL
    $idProducto = $_GET['id'];

    // Consultar la base de datos para obtener los detalles del producto con el ID proporcionado
    $sql = "SELECT * FROM PUBLICACIONES WHERE idPublicaciones = $idProducto";
    $result = $conn->query($sql);

    // Verificar si se encontró el producto
    if ($result->num_rows > 0) {
        // Crear un array asociativo para almacenar los detalles del producto
        $producto = [];

        // Obtener los detalles del producto y almacenarlos en el array
        while ($row = $result->fetch_assoc()) {
            $producto = [
                'titulo' => $row['titulo'],
                'descripcion' => $row['Descripcion'],
                'Imagen' => $row['Imagen'],
                'Tipo' => $row['Tipo'],
                'precio' => $row['precioSistema'],
                'precioLocal' => $row['precioLocal'],
                'cantidadDisponible' => $row['cantidadDisponible'],
                'FechaPublicacion' => $row['FechaPublicacion'],     
                'FechaExpiracion' => $row['FechaExpiracion'],
                'categoria' => $row['categoria'],
            ];
        }

        // Devolver los detalles del producto en formato JSON
        echo json_encode($producto);
        
    } else {
        // Si no se encontró el producto, devolver un mensaje de error
        echo json_encode(['error' => 'Producto no encontrado']);
    }
} else {
    // Si no se proporcionó el ID del producto, devolver un mensaje de error
    echo json_encode(['error' => 'ID del producto no especificado']);
}
?>
