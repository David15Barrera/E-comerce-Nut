<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['correo'])) {
    header("Location: login.html"); // Redirigir a la página de inicio de sesión si el usuario no está logueado
    exit();
}

include_once "connection.php";

$correo = $_SESSION['correo'];
//var_dump($correo);
// Obtener información del usuario desde la tabla USUARIO y USUARIODATOS
$sql = "SELECT u.email, u.rol, ud.name, ud.lastName, ud.dpiUser, ud.nitUserDatos, ud.direccionUser, ud.telefonoUser, ud.genero, ud.dateRegistro 
        FROM USUARIO u 
        JOIN USUARIODATOS ud ON u.idUser = ud.userId 
        WHERE u.email = '$correo'";
// Ejecutar la consulta SQL
$result = mysqli_query($conn, $sql);

// Verificar si hay algún error en la ejecución de la consulta
if (!$result) {
    die("Error al obtener los datos del usuario: " . mysqli_error($conn));
}


// Convertir el resultado a un arreglo asociativo
$usuario = mysqli_fetch_assoc($result);

// Convertir los datos del usuario a JSON sin escapar caracteres Unicode
$json_usuario = json_encode($usuario, JSON_UNESCAPED_UNICODE);

// Devolver los datos del usuario como JSON
echo $json_usuario;

mysqli_close($conn);
?>
