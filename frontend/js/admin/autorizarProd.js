document.addEventListener('DOMContentLoaded', function() {
    // Obtener el ID del producto de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    // Realizar una solicitud AJAX para obtener los detalles del producto
    fetch(`../../../backend/verProdDetalles.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {

            let imageLink = product.Imagen.startsWith('../backend/') ? product.Imagen.substring(11) : product.Imagen;
            // Actualizar los elementos HTML con los detalles del producto
            document.getElementById('product-image').src = `../../../backend/${imageLink}`;
            document.getElementById('product-title').textContent = product.titulo;
            document.getElementById('product-description').textContent = product.descripcion;
            document.getElementById('product-price').textContent = `Precio: Q ${product.precio}`;
            document.getElementById('product-precioLocal').textContent = `NutPoints: ${product.precioLocal}`;
            document.getElementById('product-cantidadDisponible').textContent = `Cantidad: ${product.cantidadDisponible}`;
            document.getElementById('product-FechaPublicacion').textContent = `Fecha de Publicación: ${product.FechaPublicacion}`;
            document.getElementById('product-FechaExpiracion').textContent = `Fecha de Expiración: ${product.FechaExpiracion}`;
            document.getElementById('product-Categoria').textContent = `Categoría: ${product.categoria}`;
        })
        .catch(error => console.error('Error al obtener los detalles del producto:', error));

});

//------------------------------------------------- Metodo para aceptar
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-autorizar');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.value; // Obtener el ID del producto del valor del botón
            console.log(productId);
            fetch('../../../backend/autorizarPub.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Cambiar a application/x-www-form-urlencoded
                },
                body: `productId=${productId}` // Enviar los datos como una cadena de consulta
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Producto Autorizado con Exito");
                    window.location.href = '../../views/admin/autorizarProd.html';    
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});


//--------------------------------------- Metodo para cancelar la compra
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-rechazar');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.value; // Obtener el ID del producto del valor del botón
            console.log(productId);
            fetch('../../../backend/rechazar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Cambiar a application/x-www-form-urlencoded
                },
                body: `productId=${productId}` // Enviar los datos como una cadena de consulta
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Producto Rechazado con Exito");
                    window.location.href = '../../views/admin/autorizarProd.html';    
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
