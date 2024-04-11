<?php

session_start();
include 'connection.php';

if (!isset($_SESSION['correo'])) {
    // Redireccionar si el usuario no está autenticado
    header("Location: login.html");
    exit();
}

$correo = $_SESSION['correo'];
$idUsuarioQuery = "SELECT idUser FROM USUARIO WHERE email='$correo'";
$idUsuarioResult = $conn->query($idUsuarioQuery);

$row = $idUsuarioResult->fetch_assoc();
$idUser = $row['idUser'];


$sql = "SELECT * FROM PUBLICACIONES WHERE estado = 'APROBADA' AND userId = $idUser" ;
$result = $conn->query($sql);

$publicaciones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $publicacion = [
            'idPublicaciones' => $row['idPublicaciones'],
            'titulo' => $row['titulo'],
            'descripcion' => $row['Descripcion'],
            'Imagen' => $row['Imagen'],
            'precioLocal' => $row['precioLocal'],
            'precioSistema' => $row['precioSistema']
        ];
        $publicaciones[] = $publicacion;
    }
}

echo json_encode($publicaciones);
?>
