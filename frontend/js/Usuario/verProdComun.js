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

        fetch(`../../../backend/verValoraciones.php?id=${productId}`)
        .then(response => response.json())
        .then(valoraciones => {
            valoraciones.forEach(valora => {
                let commentDiv = document.createElement('div');
                commentDiv.classList.add('comment');
                commentDiv.innerHTML = `
                    <div class="comment-header">
                        <span class="comment-author">${valora.name} ${valora.lastName}</span>
                        <span class="comment-date">Fecha de Valoración: ${valora.dateValoracion}</span>
                    </div>
                    <div class="comment-body">
                        <span class="comment-rating">Puntuación: ${valora.puntuacion}</span>
                        <p class="comment-text">${valora.comentario}</p>
                    </div>
                `;
                document.querySelector('.product-comments').appendChild(commentDiv);
            });
        })
        .catch(error => console.error('Error al obtener las valoraciones:', error));
    

});


document.addEventListener('DOMContentLoaded', function() {
    // Obtener el formulario de comentario
    const formComentario = document.getElementById('form-comentario');

    // Agregar un evento de escucha para el envío del formulario
    formComentario.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
        
        // Obtener los datos del formulario
        const formData = new FormData(formComentario);

        // Realizar una solicitud AJAX para enviar los datos del formulario al servidor
        fetch('../../../backend/crearComentario.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Verificar si la respuesta del servidor indica un éxito
            if (data.success) {
                // Redirigir al usuario a la página deseada
                alert('Comentario publicado');
                window.location.reload();
                console.log(data.success);

            } else {
                // Mostrar un mensaje de error si no se pudo crear el comentario
                alert('Error al crear el comentario: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error al enviar el formulario:', error);
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const btnComprar = document.querySelector('.btn-comprar');
    const inputCantidad = document.querySelector('.input-cantidad');

    btnComprar.addEventListener('click', function() {
        const productId = this.value; // Obtener el ID del producto del botón "Comprar"
        const cantidad = inputCantidad.value;

        // Validar la cantidad
        if (cantidad <= 0) {
            alert('La cantidad debe ser mayor que cero.');
            return; // Detener la ejecución si la cantidad es 0 o menor
        }

        const cantidadDisponible = parseInt(document.getElementById('product-cantidadDisponible').textContent.split(': ')[1]);
        if (cantidad > cantidadDisponible) {
            alert('No hay suficiente cantidad disponible para comprar.');
            return; // Detener la ejecución si la cantidad excede la cantidad disponible
        }

        // Realizar una solicitud AJAX al servidor PHP para agregar el producto al carrito
        fetch('../../../backend/aggCarrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `productId=${productId}&cantidad=${cantidad}`
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Error en la solicitud AJAX: ' + response.statusText);
        })
        .then(data => {
            // Mostrar un mensaje de compra completada si la respuesta es exitosa
            alert(data); // Muestra el mensaje devuelto por el servidor
            console.log(data); // Puedes manejar la respuesta como desees
            window.location.reload();
        })
        .catch(error => {
            console.error('Error en la solicitud AJAX:', error);
        });
    });
});
