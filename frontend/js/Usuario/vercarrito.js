document.addEventListener('DOMContentLoaded', function() {
    // Obtener el contenedor de productos del carrito
    const cartItemsContainer = document.querySelector('.cart-items');
    // Obtener el contenedor del precio total y el total de puntos
    const totalPriceContainer = document.getElementById('total-price');
    const totalPointsContainer = document.getElementById('total-points');

    // Realizar una solicitud AJAX para obtener los detalles del carrito
    fetch('../../../backend/verCarrito.php')
    .then(response => response.json())
    .then(data => {
        // Limpiar el contenedor de productos del carrito
        cartItemsContainer.innerHTML = '';

        // Inicializar variables para el precio total y el total de puntos
        let precioTotal = 0;
        let totalPuntos = 0;

        // Renderizar los detalles de los productos en el carrito
        data.forEach(producto => {
            const productHTML = `
                <div class="product">
                    <h3>${producto.titulo} código ${producto.idCarrito}</h3>
                    <p>Precio unitario: Q${producto.precioSistema}</p>
                    <p>Cantidad: ${producto.cantidad}</p>
                    <p>Total: Q${producto.total}</p>
                    <button class="delete-btn" data-id="${producto.idCarrito}">Eliminar</button>
                </div>
            `;
            cartItemsContainer.innerHTML += productHTML;
            // Sumar el precio total y calcular el total de puntos
            precioTotal += parseFloat(producto.total);
            totalPuntos += parseFloat(producto.total) * 10;
            console.log(producto.idCarrito);
        });

        // Actualizar el precio total y el total de puntos en el contenedor correspondiente
        totalPriceContainer.textContent = precioTotal.toFixed(2);
        totalPointsContainer.textContent = totalPuntos.toFixed(2);

        // Escuchar clics en los botones de eliminar
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const idCarrito = this.getAttribute('data-id');
                console.log('ID del carrito:', idCarrito); // Agregar esta línea para depurar
                if (idCarrito) { // Verificar si el ID del carrito existe
                    eliminarProductoDelCarrito(idCarrito);
                } else {
                    console.error('El ID del carrito no se ha proporcionado correctamente');
                }
            });
        });

    })
    .catch(error => {
        console.error('Error al obtener el carrito:', error);
    });

    // Función para eliminar un producto del carrito
    function eliminarProductoDelCarrito(idCarrito) {
        // Realizar una solicitud AJAX para eliminar el producto del carrito
        fetch('../../../backend/deleteProdCarrito.php?idCarrito=' + idCarrito, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Mostrar un mensaje de éxito o error según la respuesta del servidor
            if (data.success) {
                alert(data.success);
                // Recargar la página para actualizar el carrito
                location.reload();
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error al eliminar producto del carrito:', error);
        });
    }    
});


document.addEventListener('DOMContentLoaded', function() {
    const cancelarCompraBtn = document.getElementById('checkout-btn');

    cancelarCompraBtn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de cancelar la compra y eliminar todos los productos del carrito?')) {
            cancelarCompra();
        }
    });

    function cancelarCompra() {
        fetch('../../../backend/deleteCarrito.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload(); // Recargar la página después de cancelar la compra
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error al cancelar compra:', error);
        });
    }
});
