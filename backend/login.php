<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost:3306"; // Cambia esto si tu servidor MySQL no está en localhost
    $username = "root"; // Reemplaza con tu nombre de usuario de MySQL
    $password = "Sistemas1."; // Reemplaza con tu contraseña de MySQL
    $database = "ECOMARCEDB"; // Reemplaza con el nombre de tu base de datos

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Prevenir inyección SQL
    $correo = mysqli_real_escape_string($conn, $correo);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM USUARIO WHERE email='$correo' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login exitoso
        $row = $result->fetch_assoc();
        $_SESSION['correo'] = $correo;
        $_SESSION['estatus'] = $row['estatus']; 
        // Verificar el rol del usuario y redirigir
        if ($row['rol'] == 'usuario') {
            echo "success_usuario";
        } elseif ($row['rol'] == 'administrador') {
            echo "success_administrador";
        }
    } else {
        // Login fallido
        echo "failure";
    }

    $conn->close();
}
?>