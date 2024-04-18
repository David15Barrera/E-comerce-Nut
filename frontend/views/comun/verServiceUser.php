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
                    <a href="../comun/inicioComun.php" class="link">Cuenta</a>
                    <a href="../comun/productosUser.html" class="link">Productos</a>
                    <a href="../comun/carrito.html" class="link link--active">Carrito</a>
                </div>
            </div>
        </nav>
    </header>
    <br>

    <div class="product-details">
        <div class="image-container">
            <img alt="Producto" id="product-image">
        </div>
        <div class="details">
            <h1 id="product-title">Nombre del Producto</h1>
            <p id="product-description">Descripción del producto...</p>
            <p id="product-price">Bellotas: $XX.XX</p>
             <p id="product-cantidadDisponible">Personas necesarias: XX</p>
            <p id="product-FechaPublicacion">Fecha de Publicación: XX/XX/XXXX</p>
            <p id="product-FechaExpiracion">Fecha de evento: XX/XX/XXXX</p>
            <p id="product-Categoria">Categoría: XXX</p>        

            <button class="btn-service" value="<?php echo $_GET['id']; ?>">Inscibirse</button>

        </div>
    </div>


    <div class="comments-and-contact">
        <!-- Espacio para comentarios del producto -->
        <div class="product-comments">
            <h2>Comentarios del Producto</h2>
            <!-- Otros comentarios se pueden agregar aquí -->

            <form class="form-comentario" id="form-comentario" method="post">
                <h2>Haz Tu Comentario</h2>
                <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $_GET['id']; ?>">
                <label for="comentario">Comentario:</label>
                <textarea id="comentario" name="comentario" required></textarea>
                <label for="puntuacion">Puntuación</label>
                <select id="puntuacion" name="puntuacion" required>
                    <option value="">Selecciona una puntuación</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <small>Nota: 5 es la mejor puntuación y 1 es la peor.</small>
                <button type="submit">Enviar</button>
            </form>
            

        </div>

        <!-- Formulario de contacto -->
        <div class="contact-form">
            <h2>Contactar con el Usuario</h2>
            <form action="#" method="post">
                <label for="mensaje">Mensaje:</label>
                <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $_GET['id']; ?>">
                <textarea id="mensaje" name="mensaje" required></textarea>
                <button type="submit" >Enviar</button>
            </form>
        </div>
    </div>
</body>
<script src="../../js/Usuario/verServComun.js"></script>
</html>
