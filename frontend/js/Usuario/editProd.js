    // Llamada AJAX para obtener las publicaciones desde el servidor
    fetch('../../../backend/verProdUser.php')
        .then(response => response.json())
        .then(publicaciones => {
            const productContainer = document.querySelector('.product-list');

           // Iterar sobre las publicaciones y crear elementos HTML dinámicamente
            publicaciones.forEach(publicacion => {

                const productDiv = document.createElement('div');
                productDiv.classList.add('product');

                const img = document.createElement('img');

                console.log(publicacion.Imagen);

                // Verificar si la ruta de la imagen comienza con '../backend/'
                let imagePath = publicacion.Imagen.startsWith('../backend/') ? publicacion.Imagen.substring(11) : publicacion.Imagen;
                console.log(imagePath);

                img.src = `../../../backend/${imagePath}`;
                img.alt = publicacion.titulo;

                img.addEventListener('click', () => {
                    window.location.href = `editProdunitario.php?id=${publicacion.idPublicaciones}`;
                });

                const h3 = document.createElement('h3');
                h3.textContent = publicacion.titulo;

                const p = document.createElement('p');
                p.textContent = publicacion.descripcion;

                const span = document.createElement('span');
                span.textContent = publicacion.precio + ' NutPoints - ';

                const span2 = document.createElement('span');
                span2.textContent = 'Q ' +publicacion.precioSistema

                const verButton = document.createElement('button');

                productDiv.appendChild(img);
                productDiv.appendChild(h3);
                productDiv.appendChild(p);
                productDiv.appendChild(span);
                productDiv.appendChild(span2);

                productContainer.appendChild(productDiv);
            });
        })
        .catch(error => console.error('Error al obtener las publicaciones:', error));