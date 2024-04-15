<?php
include_once "connection.php"; // Incluir archivo de conexión

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $publicacionId = $_POST['publicacionesId'];
    $mensaje = $_POST['message'];
    $receptorId = $_POST['receptor'];

    // Obtener el ID del usuario emisor a partir de la sesión
    session_start();
    $correo = $_SESSION['correo'] ?? null;

    if ($correo === null) {
        echo json_encode(['success' => false, 'message' => 'Error: No se pudo obtener el correo electrónico del usuario.']);
        exit;
    }

    $sql = "SELECT idUser FROM USUARIO WHERE email='$correo'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $emisorId = $row['idUser'];

        // Insertar el mensaje en la base de datos
        $insertQuery = "INSERT INTO CHATS (publicacionesId, emisor, receptor, mensaje, timeMessage) VALUES ('$publicacionId', '$emisorId', '$receptorId', '$mensaje', NOW())";
        if ($conn->query($insertQuery) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Mensaje enviado con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: No se pudo obtener el ID de usuario del emisor.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Método de solicitud incorrecto.']);
}
?>
