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
    <title>InicioAdmin</title>
</head>
<body>
<header>
        <nav class="nav__hero">
            <div class="container nav__container">
                <div class="logo">
                    <h2 class="logo__name">Ecommerce<span class="point">.</span></h2>
                </div>
                <div class="links">
                    <a href="../admin/inicioAdmin.php" class="link">Cuenta</a>
                    <a href="#" class="link">Productos</a>
                </div>
            </div>
        </nav>
    </header>
    <br>
    <br>

    <nav class="sidebar">
        <ul>
            <br>
            <br>
            <li><a href="#" class="active"><span>Inicio</span></a></li>
            <li><a href="../admin/AgregarUser.html"><span class="icono-agregar">Agregar Usuario</span></a></li>
            <li><a href="../admin/autorizarProd.html"><span class="icono-autorizar">Autorizar</span></a></li>
            <li><a href="../admin/verReportes.html"><span class="icono-reportes">Reporte Usuario</span></a></li>
            <li><a href="#"><span class="icono-reportes">Reportes</span></a></li>
            <li><a href="../admin/micuentaA.php"><span class="icono-usuario">Mi Cuenta</span></a></li> 
            <li><a href="../login.html"><span class="icono-cerrar">Cerrar sesión</span></a></li>
        </ul>
    </nav>
    <div class="content">
        <div class="container">
            <h1 class="animate__animated animate__fadeInDown">Bienvenido, <?php echo $nombreUsuario . " " . $apellidoUsuario; ?></h1>
            <p class="animate__animated animate__fadeInUp">¡Disfruta de tu sesión como Administrador!</p>
        </div>
    </div>

    <div class="image-container-ardilla">
        <img src="../../img/img_user/ardillacool.png" alt="Ardilla Comiendo" width="499" height="499">
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