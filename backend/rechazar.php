<?php
include_once "connection.php"; // Incluir archivo de conexión

// Obtener el ID del producto a autorizar desde la solicitud POST

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['productId'])) {
        $productId = $_POST['productId'];

        // Ejecutar consulta para actualizar el estado del producto
        $sql = "UPDATE PUBLICACIONES SET estado = 'RECHAZADA' WHERE idPublicaciones = $productId";

        if ($conn->query($sql) === TRUE) {
            // Éxito: la consulta se ejecutó correctamente
            echo json_encode(['success' => true, 'message' => 'Producto Rechazdo con éxito.']);
        } else {
            // Error: la consulta falló
            echo json_encode(['success' => false, 'message' => 'Error al autorizar el producto: ' . $conn->error]);
        }
    } else {
        // Error: el ID del producto no se recibió correctamente
        echo json_encode(['success' => false, 'message' => 'ID del producto no recibido.']);
    }
} else {
    echo "Error: Método de solicitud incorrecto.";
}
?>
