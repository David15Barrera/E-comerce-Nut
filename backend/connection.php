<?php
$servername = "localhost:3306"; // Cambia esto si tu servidor MySQL no está en localhost
$username = "Nombre_base_datos"; // Reemplaza con tu nombre de usuario de MySQL
$password = "contraseña_base_datos"; // Reemplaza con tu contraseña de MySQL
$database = "ECOMARCEDB"; // Reemplaza con el nombre de tu base de datos

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
