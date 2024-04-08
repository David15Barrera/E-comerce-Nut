<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "connection.php";

$response = []; // Inicializar un arreglo para la respuesta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['correo'])) {
        $correo = $_SESSION['correo'];
        $idCarrito = isset($_GET['idCarrito']) ? $_GET['idCarrito'] : null;

        if ($idCarrito !== null) {
            // Obtener la cantidad del producto eliminado del carrito
            $sqlGetQuantity = "SELECT cantidad FROM CARRITO WHERE idCarrito = '$idCarrito'";
            $resultQuantity = $conn->query($sqlGetQuantity);
            if ($resultQuantity->num_rows > 0) {
                $row = $resultQuantity->fetch_assoc();
                $cantidadEliminada = $row["cantidad"];

                // Obtener la cantidad disponible del producto correspondiente en la publicación
                $sqlGetAvailableQuantity = "SELECT cantidadDisponible FROM PUBLICACIONES WHERE idPublicaciones = (SELECT idPublicaciones FROM CARRITO WHERE idCarrito = '$idCarrito')";
                $resultAvailableQuantity = $conn->query($sqlGetAvailableQuantity);
                if ($resultAvailableQuantity->num_rows > 0) {
                    $rowAvailable = $resultAvailableQuantity->fetch_assoc();
                    $cantidadDisponible = $rowAvailable["cantidadDisponible"];

                    // Sumar la cantidad eliminada del carrito a la cantidad disponible en la base de datos
                    $nuevaCantidadDisponible = $cantidadDisponible + $cantidadEliminada;

                    // Actualizar la cantidad disponible de la publicación en la base de datos
                    $sqlUpdateQuantity = "UPDATE PUBLICACIONES SET cantidadDisponible = $nuevaCantidadDisponible WHERE idPublicaciones = (SELECT idPublicaciones FROM CARRITO WHERE idCarrito = '$idCarrito')";
                    if ($conn->query($sqlUpdateQuantity) === TRUE) {
                        // Eliminar el producto del carrito del usuario
                        $sqlDeleteCart = "DELETE FROM CARRITO WHERE userId = (SELECT idUser FROM USUARIO WHERE email = '$correo') AND idCarrito = '$idCarrito'";
                        if ($conn->query($sqlDeleteCart) === TRUE) {
                            $response['success'] = 'Producto eliminado del carrito';
                        } else {
                            $response['error'] = 'Error al eliminar el producto del carrito: ' . $conn->error;
                        }
                    } else {
                        $response['error'] = 'Error al actualizar la cantidad disponible de la publicación: ' . $conn->error;
                    }
                } else {
                    $response['error'] = 'No se pudo recuperar la cantidad disponible de la publicación';
                }
            } else {
                $response['error'] = 'No se pudo recuperar la cantidad del producto eliminado del carrito';
            }
        } else {
            $response['error'] = 'ID del carrito no proporcionado en la solicitud';
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
