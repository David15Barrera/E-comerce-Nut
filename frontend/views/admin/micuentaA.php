<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styleUser.css" type="text/css">
    <link rel="stylesheet" href="../../css/stylemicuenta.css" type="text/css">
    <title>Mi Cuenta</title>
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
            <li><a href="../admin/inicioAdmin.php" class="active"><span>Inicio</span></a></li>
            <li><a href="#"><span class="icono-agregar">Agregar Usuario</span></a></li>
            <li><a href="#"><span class="icono-autorizar">Autorizar</span></a></li>
            <li><a href="#"><span class="icono-reportes">Reporte Usuario</span></a></li>
            <li><a href="#"><span class="icono-reportes">Reportes</span></a></li>
            <li><a href="../admin/micuentaA.php"><span class="icono-usuario">Mi Cuenta</span></a></li> 
            <li><a href="../login.html"><span class="icono-cerrar">Cerrar sesión</span></a></li>
        </ul>
    </nav>
<br>
    <div class="container-cuenta">
        <div class="info-box">
            <h2>Información de Usuario</h2>
            <div class="user-details">
            <div class="user-name" id="nombreUsuario"></div>
            <div class="user-role" id="rolUsuario"></div>
            <div class="user-info">
                    <p id="correoUsuario"></p>
                    <p id="dpiUsuario"></p>
                    <p id="nitUsuario"></p>
                    <p id="addressUsuario"></p>
                    <p id="phoneUsuario"></p>
                    <p id="genderUsuario"></p>
                    <p id="fechaRegistro"></p>
            </div>
        </div>
        </div>
        <div class="edit-box">
            <form action="#" method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="input-field">
                        <label for="lastname">Apellido:</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-field">
                        <label for="dpi">  DPI:</label>
                        <input type="text" id="dpi" name="dpi" required>
                    </div>
                    <div class="input-field">
                        <label for="nit">  NIT:</label>
                        <input type="text" id="nit" name="nit" required>
                    </div>
                </div>
                 <div class="input-group">
                 <div class="input-field">
                        <label for="gender">Género:</label>
                        <select id="gender" name="gender">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="phone">Celular:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                 </div>   
                <div class="input-field">
                    <label for="address">Dirección:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                    <div class="input-field">
                    <label for="correoUsuario">Correo:</label>
                    <input type="text" id="addresUsuario" name="correoUsuario" required>
                    </div>
                <div class="input-group">
                    <div class="input-field">
                    <label for="password">Nueva Contraseña:</label>
                    <input type="password" id="password" name="password">
                    </div>
                    <div class="input-field">
                    <label for="confirmPassword">Confirmar Contraseña:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword">
                    </div>
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
</body>
<script src="../../js/update.js"></script>
</html>