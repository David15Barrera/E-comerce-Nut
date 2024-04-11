<?php
session_start();
include 'connection.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo'])) {
    header('Location: ../login.html');
    exit;
}

// Obtener el ID de usuario del usuario actual
$correo = $_SESSION['correo'];
$sql = "SELECT idUser FROM USUARIO WHERE email='$correo'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $userId = $row['idUser'];
    // echo "ID de usuario obtenido: $userId"; // Mensaje de depuración
} else {
    echo "Error: No se pudo obtener el ID de usuario.";
    exit;
}

// Obtener el ID de la publicación de la URL
if(isset($_GET['publicacionesId'])) {
    $publicacionesId = $_GET['publicacionesId'];
} else {
    echo "Error: No se proporcionó el ID de la publicación.";
    exit;
}

// Obtener mensajes del chat relacionados con la publicación
$sql = "SELECT * FROM CHATS WHERE publicacionesId = $publicacionesId ORDER BY timeMessage ASC";
$result = mysqli_query($conn, $sql);
$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

// echo "<pre>";
// print_r($messages); // Mensaje de depuración
// echo "</pre>";

// Devolver los mensajes y el userId como JSON
$response = [
    'publicacionesId' => $publicacionesId,
    'messages' => $messages,
    'userId' => $userId
];
header('Content-Type: application/json');
echo json_encode($response);
?>
