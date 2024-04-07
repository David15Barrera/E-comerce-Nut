<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Iniciar sesión para acceder a la variable de sesión

include_once "connection.php"; // Incluir archivo de conexión

// Verificar si se ha iniciado sesión y se tiene un correo electrónico en la variable de sesión
if (isset($_SESSION['correo'])) {
    $correo = $_SESSION['correo'];

    if (isset($_POST['comentario']) && isset($_POST['puntuacion']) && isset($_POST['idProducto'])) {
        $comentario = $_POST['comentario'];
        $puntuacion = $_POST['puntuacion'];
        $idProducto = $_POST['idProducto']; // Se asume que el ID del producto se enviará desde el formulario

        // Obtener el ID del usuario evaluador usando el correo electrónico
        $sqlUserId = "SELECT idUser FROM USUARIO WHERE email = '$correo'";
        $resultUserId = $conn->query($sqlUserId);
        if ($resultUserId->num_rows > 0) {
            $row = $resultUserId->fetch_assoc();
            $userId = $row['idUser'];

            // Insertar el comentario en la base de datos
            $sqlInsert = "INSERT INTO VALORACIONES (userEvaluadorId, publicacionId, puntuacion, comentario, dateValoracion) 
                          VALUES ('$userId', '$idProducto', '$puntuacion', '$comentario', CURRENT_DATE)";
            if ($conn->query($sqlInsert) === TRUE) {
                // Redirigir al usuario a la página de ver productos
                echo json_encode(['success' => 'Comentario creado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al crear el comentario: ' . $conn->error]);
            }
        } else {
            echo json_encode(['error' => 'No se encontró el usuario correspondiente al correo electrónico']);
        }
    } else {
        echo json_encode(['error' => 'Los datos del formulario están incompletos']);
    }
} else {
    echo json_encode(['error' => 'No se ha iniciado sesión']);
}
?>
