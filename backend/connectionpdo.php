<?php
$servername = "localhost:3306"; // Cambia esto si tu servidor MySQL no está en localhost
$username = "root"; // Reemplaza con tu nombre de usuario de MySQL
$password = "Sistemas1."; // Reemplaza con tu contraseña de MySQL
$database = "ECOMARCEDB"; // Reemplaza con el nombre de tu base de datos

// Intentar establecer la conexión usando PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Habilitar el modo de errores de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Si hay un error al conectar, mostrar el mensaje de error
    die("Conexión fallida: " . $e->getMessage());
}
?>
