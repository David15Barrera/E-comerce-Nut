<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['correo'])) {
    // Redireccionar si el usuario no está autenticado
    header("Location: login.html");
    exit();
}

$correo = $_SESSION['correo'];

// Obtener el ID del usuario a partir del correo electrónico
$idUsuarioQuery = "SELECT idUser FROM USUARIO WHERE email='$correo'";
$idUsuarioResult = $conn->query($idUsuarioQuery);

if ($idUsuarioResult->num_rows == 1) {
    $row = $idUsuarioResult->fetch_assoc();
    $idUser = $row['idUser'];

    // Consulta para obtener los usuarios que quieren interactuar con el usuario actual
    $usuariosInteresadosQuery = "SELECT UD.name, UD.lastname, P.titulo, C.publicacionesId
                                FROM CHATS C
                                INNER JOIN USUARIO U ON C.emisor = U.idUser
                                INNER JOIN USUARIODATOS UD ON U.idUser = UD.userId
                                INNER JOIN PUBLICACIONES P ON C.publicacionesId = P.idPublicaciones
                                WHERE C.receptor = $idUser";

    $usuariosInteresadosResult = $conn->query($usuariosInteresadosQuery);

    // Manejar los resultados obtenidos
    $usuariosInteresados = [];
    if ($usuariosInteresadosResult->num_rows > 0) {
        while ($row = $usuariosInteresadosResult->fetch_assoc()) {
            $usuariosInteresados[] = [
                'nombre' => $row['name'],
                'lastname' => $row['lastname'],
                'titulo_publicacion' => $row['titulo'],
                'publicacionesId' => $row['publicacionesId']
            ];
        }
    }

    // Devolver los resultados como JSON
    echo json_encode($usuariosInteresados);
} else {
    // Manejar el caso en que no se encuentre el usuario
    echo "Error: Usuario no encontrado.";
}

$conn->close();
?>
