document.addEventListener('DOMContentLoaded', function() {
    // Obtener el ID del producto de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    // Obtener elementos HTML por su ID
    const productImage = document.getElementById('product-image');
    const productTitle = document.getElementById('product-title');
    const productDescription = document.getElementById('product-description');
    const productPrice = document.getElementById('product-price');
    const productCantidadDisponible = document.getElementById('product-cantidadDisponible');
    const productFechaPublicacion = document.getElementById('product-FechaPublicacion');
    const productFechaExpiracion = document.getElementById('product-FechaExpiracion');
    const productCategoria = document.getElementById('product-Categoria');

    // Realizar una solicitud AJAX para obtener los detalles del producto
    fetch(`../../../backend/verProdDetalles.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {
            // Verificar si los elementos existen antes de establecer su contenido
            if (productImage && productTitle && productDescription && productPrice && productCantidadDisponible && productFechaPublicacion && productFechaExpiracion && productCategoria) {
                let imageLink = product.Imagen.startsWith('../backend/') ? product.Imagen.substring(11) : product.Imagen;
                // Actualizar los elementos HTML con los detalles del producto
                productImage.src = `../../../backend/${imageLink}`;
                productTitle.textContent = product.titulo;
                productDescription.textContent = product.descripcion;
                productPrice.textContent = `Bellotas: ${product.precioLocal}`;
                productCantidadDisponible.textContent = `Personas Necesarias: ${product.cantidadDisponible}`;
                productFechaPublicacion.textContent = `Fecha de Publicación: ${product.FechaPublicacion}`;
                productFechaExpiracion.textContent = `Fecha de Evento: ${product.FechaExpiracion}`;
                productCategoria.textContent = `Categoría: ${product.categoria}`;
            }
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
    
                // Crear un botón de reporte
                let reportButton = document.createElement('button');
                reportButton.textContent = 'Reportar';
                reportButton.classList.add('report-button');
    
                // Agregar un evento de clic al botón de reporte
                reportButton.addEventListener('click', function() {
                    // Aquí puedes agregar la lógica para reportar la valoración
                    // Obtener el ID del usuario reportado
                    const userReportadoId = valora.userEvaluadorId;

                    // Obtener el ID de la publicación
                    const publicacionId = valora.publicacionId;

                    // Obtener la razón del reporte (por ejemplo, siempre reportado por mal comentario)
                    const razonReporte = 'Reportado por mal comentario';

                    // Crear un FormData para enviar los datos al backend
                    const formData = new FormData();
                    formData.append('publicacionId', publicacionId);
                    formData.append('userReportadoId', userReportadoId);
                    formData.append('razonReporte', razonReporte);

                    // Enviar los datos del reporte al backend usando Fetch
                    fetch('../../../backend/reportarUser.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Usuario Reportado Correctamente");
                            console.log('Reporte insertado correctamente');
                            // Aquí puedes agregar cualquier otra acción necesaria después de insertar el reporte
                        } else {
                            alert("Problemas al Reportar");
                            console.error('Error al insertar el reporte:', data.message);
                        }
                    })
                    .catch(error => console.error('Error al insertar el reporte:', error));
                    });

                    // Agregar el botón de reporte al div del comentario
                    commentDiv.appendChild(reportButton);

                    // Agregar el comentario al contenedor de comentarios
                    document.querySelector('.product-comments').appendChild(commentDiv);
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
    const form = document.querySelector('.contact-form form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const idProducto = document.getElementById('idProducto').value;
        const mensaje = document.getElementById('mensaje').value;

        const formData = new FormData();
        formData.append('idProducto', idProducto);
        formData.append('mensaje', mensaje);
        
        //Las variables idProducto y mensaje si estan siendo capturados de manera correcta
        // Llamada AJAX para enviar el mensaje
        fetch('../../../backend/chatAggProd.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // El mensaje se envió correctamente
                window.location.reload();
                alert(data.message);
                // Puedes redirigir a otra página si es necesario
            } else {
                // Ocurrió un error al enviar el mensaje
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error al enviar el mensaje:', error);
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Obtener el botón de inscripción
    const btnInscribirse = document.querySelector('.btn-service');

    if (btnInscribirse) {
        // Agregar un evento de clic al botón de inscripción
        btnInscribirse.addEventListener('click', function() {
            // Obtener el ID del producto del valor del botón
            const productId = this.value;

            // Realizar una solicitud AJAX para inscribirse en el servicio
            fetch('../../../backend/evento.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `productId=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                // Mostrar mensaje de éxito o error
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                    // Puedes redirigir a otra página si es necesario
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error al inscribirse en el servicio:', error));
        });
    }
});
