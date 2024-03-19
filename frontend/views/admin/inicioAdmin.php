<?php 
session_start();
if(isset($_SESSION['nombreUsuario']) && isset($_SESSION['apellidoUsuario'])) {
    $nombreUsuario = $_SESSION['nombreUsuario'];
    $apellidoUsuario = $_SESSION['apellidoUsuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styleUser.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome para los iconos -->    
    <title>InicioAdmin</title>
</head>
<body>
    <nav class="sidebar">
        <h3>nut</h3>
        <ul>
            <li><a href="#" class="active"><span>Inicio</span></a></li>
            <li><a href="#"><span class="icono-agregar">Agregar Usuario</span></a></li>
            <li><a href="#"><span class="icono-autorizar">Autorizar</span></a></li>
            <li><a href="#"><span class="icono-reportes">Reporte Usuario</span></a></li>
            <li><a href="#"><span class="icono-reportes">Reportes</span></a></li>
            <li><a href="#"><span class="icono-usuario">Mi Cuenta</span></a></li> 
            <li><a href="#"><span class="icono-cerrar">Cerrar sesión</span></a></li>
        </ul>
    </nav>
    <div class="content">
        <div class="container">
            <h1 class="animate__animated animate__fadeInDown">Bienvenido, <?php echo $nombreUsuario . " " . $apellidoUsuario; ?></h1>
            <p class="animate__animated animate__fadeInUp">¡Disfruta de tu sesión como Administrador!</p>
        </div>
    </div>
</body>
</html>

<?php 
} else {
    // Si las variables de sesión no están configuradas, redirige al usuario a la página de inicio de sesión
    header("Location: login.html");
    exit();
}
?>