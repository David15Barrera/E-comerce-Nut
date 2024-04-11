<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styleUser.css" type="text/css">
    <link rel="stylesheet" href="../../css/styleverProd.css" type="text/css">    
    <title>Detalle Producto</title>
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
                </div>
            </div>
        </nav>
    </header>
    <div class="product-details">
        <div class="image-container">
            <img alt="Producto" id="product-image">
        </div>
        <div class="details">
            <h1 id="product-title">Nombre del Producto</h1>
            <p id="product-description">Descripción del producto...</p>
            <p id="product-price">Precio: $XX.XX</p>
            <p id="product-precioLocal">Precio Local: $XX.XX</p>
            <p id="product-cantidadDisponible">Cantidad Disponible: XX</p>
            <p id="product-FechaPublicacion">Fecha de Publicación: XX/XX/XXXX</p>
            <p id="product-FechaExpiracion">Fecha de Expiración: XX/XX/XXXX</p>
            <p id="product-Categoria">Categoría: XXX</p>        

            <button class="btn-autorizar" value="<?php echo $_GET['id']; ?>">Autorizar</button>
            <button class="btn-rechazar" value="<?php echo $_GET['id']; ?>">Rechazar</button>
        </div>
    </div>


    <div class="comments-and-contact">
        <!-- Espacio para comentarios del producto -->
        <div class="product-comments">
            <h2>Comentarios del Producto</h2>
            <!-- Otros comentarios se pueden agregar aquí -->
        </div>

        <!-- Formulario de contacto -->
        <div class="contact-form">
            <h2>Contactar con el Usuario</h2>
            <form action="#" method="post">
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
<script src="../../js/admin/autorizarProd.js"></script>
</html>
