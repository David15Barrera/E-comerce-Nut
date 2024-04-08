<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "connection.php";

$response = []; // Inicializar un arreglo para la respuesta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['correo'])) {
        $correo = $_SESSION['correo'];

        // Recuperar los detalles de los productos cancelados del carrito
        $sqlGetCanceledProducts = "SELECT publicacionId, cantidad FROM CARRITO WHERE userId = (SELECT idUser FROM USUARIO WHERE email = '$correo')";
        $result = $conn->query($sqlGetCanceledProducts);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $publicacionId = $row['publicacionId'];
                $cantidadDevuelta = $row['cantidad'];
                
                // Actualizar las cantidades disponibles en la tabla de PUBLICACIONES con las cantidades devueltas
                $sqlUpdateQuantity = "UPDATE PUBLICACIONES SET cantidadDisponible = cantidadDisponible + $cantidadDevuelta WHERE idPublicaciones = $publicacionId";
                if ($conn->query($sqlUpdateQuantity) !== TRUE) {
                    $response['error'] = 'Error al actualizar cantidades de productos en la tabla de PUBLICACIONES: ' . $conn->error;
                    break;
                }
            }

            // Eliminar los productos cancelados del carrito
            $sqlDeleteCanceledProducts = "DELETE FROM CARRITO WHERE userId = (SELECT idUser FROM USUARIO WHERE email = '$correo')";
            if ($conn->query($sqlDeleteCanceledProducts) === TRUE) {
                $response['success'] = 'Compra cancelada con éxito';
            } else {
                $response['error'] = 'Error al cancelar la compra: ' . $conn->error;
            }
        } else {
            $response['error'] = 'No hay productos en el carrito';
        }
    } else {
        $response['error'] = 'No has iniciado sesión';
    }
} else {
    $response['error'] = 'Método de solicitud incorrecto';
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
