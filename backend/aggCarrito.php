<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el correo electrónico del usuario de la sesión
    $correo = $_SESSION['correo'] ?? null;

    // Verificar si el correo electrónico es válido
    if ($correo === null) {
        echo "Error: No se pudo obtener el correo electrónico del usuario.";
        exit; // Detener la ejecución del script
    }

    // Consultar la base de datos para obtener el ID de usuario asociado al correo electrónico
    $sql = "SELECT idUser FROM USUARIO WHERE email='$correo'";
    $result = mysqli_query($conn, $sql);
    
    // Verificar si se encontró un usuario con el correo electrónico dado
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['idUser'];

        // Obtener el ID del producto y la cantidad del cuerpo de la solicitud
        $productId = $_POST['productId'];
        $cantidad = $_POST['cantidad'];

        // Actualizar la cantidad disponible en la tabla PUBLICACIONES
        $updateQuery = "UPDATE PUBLICACIONES SET cantidadDisponible = cantidadDisponible - $cantidad WHERE idPublicaciones = $productId";
        if (mysqli_query($conn, $updateQuery)) {
            // Insertar el producto en la tabla del carrito
            $insertQuery = "INSERT INTO CARRITO (userId, publicacionId, cantidad, fechaAgregado) VALUES ('$userId', '$productId', '$cantidad', NOW())";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Compra completada exitosamente";
            } else {
                echo "Error al agregar el producto al carrito: " . mysqli_error($conn);
            }
        } else {
            echo "Error al actualizar la cantidad en la tabla PUBLICACIONES: " . mysqli_error($conn);
        }
    } else {
        echo "No se pudo encontrar el usuario asociado al correo electrónico proporcionado.";
    }
} else {
    echo "Error: Método de solicitud incorrecto.";
}
?>
