<?php
// Incluir el archivo de conexión
include 'connection.php';

// Consulta para obtener los usuarios registrados
$sql = "SELECT USUARIODATOS.name, USUARIODATOS.dpiUser, USUARIO.email FROM USUARIODATOS INNER JOIN USUARIO ON USUARIODATOS.userId = USUARIO.idUser";
$result = mysqli_query($conn, $sql);

// Array para almacenar los usuarios
$usuarios = array();

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $usuarios[] = $row;
    }
}

// Devolver los usuarios como JSON
echo json_encode($usuarios);

// Cerrar la conexión
mysqli_close($conn);
?>
