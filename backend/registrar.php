<?php
// Conexión a la base de datos (cambia los valores según tu configuración)
$servername = "localhost:3306"; // Cambia esto si tu servidor MySQL no está en localhost
$username = "root"; // Reemplaza con tu nombre de usuario de MySQL
$password = "Sistemas1."; // Reemplaza con tu contraseña de MySQL
$database = "ECOMARCEDB"; // Reemplaza con el nombre de tu base de datos


$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$lastName = $_POST['lastName'];
$dpi = $_POST['dpi'];
$nit = $_POST['nit'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$genero = $_POST['genero'];

// Establecer valores predeterminados
$estatus = "Activado";
$rol = "Usuario";
$dateRegistro = date("Y-m-d"); // Fecha y hora actual en formato MySQL

// Insertar datos en la tabla USUARIO
$sql_usuario = "INSERT INTO USUARIO (email, password, rol, estatus) VALUES ('$email', '$password', '$rol', '$estatus')";
if ($conn->query($sql_usuario) === TRUE) {
    $last_id = $conn->insert_id;

    // Insertar datos en la tabla USUARIODATOS
    $sql_usuario_datos = "INSERT INTO USUARIODATOS (userId, name, lastName, dpiUser, nitUserDatos, direccionUser, telefonoUser, genero, dateRegistro) VALUES ('$last_id', '$name', '$lastName', '$dpi', '$nit', '$direccion', '$telefono', '$genero', '$dateRegistro')";
    if ($conn->query($sql_usuario_datos) === TRUE) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }
} else {
    echo "Error al registrar el usuario: " . $conn->error;
}

$conn->close();
?>