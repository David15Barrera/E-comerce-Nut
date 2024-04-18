document.addEventListener('DOMContentLoaded', function() {
    const tablaBody = document.querySelector('.tabla tbody');

    // Llamada fetch para obtener las ventas del usuario
    fetch('../../../backend/verCompras.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const ventas = data.data;

                // Iterar sobre cada venta y agregar una fila a la tabla
                ventas.forEach(venta => {
                    const fila = document.createElement('tr');

                    // Agregar celdas con los datos de la venta
                    const fechaCompra = new Date(venta.dateRegistro);
                    const fechaFormateada = `${fechaCompra.getDate()}/${fechaCompra.getMonth() + 1}/${fechaCompra.getFullYear()}`;
                    const moneda = venta.moneda === 'local' ? 'Bellotas' : 'Moneda Real';
                    fila.innerHTML = `
                        <td>${fechaFormateada}</td>
                        <td>${venta.titulo}</td>
                        <td>${venta.categoria}</td>
                        <td>${venta.precioLocal}</td>
                        <td>${venta.total}</td>
                        <td>${moneda}</td>
                    `;

                    // Agregar la fila a la tabla
                    tablaBody.appendChild(fila);
                });
            } else {
                console.error('Error al obtener las ventas:', data.message);
            }
        })
        .catch(error => {
            console.error('Error al obtener las ventas:', error);
        });
});

document.addEventListener('DOMContentLoaded', function() {
    const tablaBody = document.querySelector('.tabla2 tbody');

    // Llamada fetch para obtener las ventas del usuario
    fetch('../../../backend/verServicios.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const ventas = data.data;

                // Iterar sobre cada venta y agregar una fila a la tabla
                ventas.forEach(venta => {
                    const fila = document.createElement('tr');

                    // Agregar celdas con los datos de la venta
                    const fechaCompra = new Date(venta.FechaExpiracion);
                    const fechaFormateada = `${fechaCompra.getDate()}/${fechaCompra.getMonth() + 1}/${fechaCompra.getFullYear()}`;
                    fila.innerHTML = `
                        <td>${fechaFormateada}</td>
                        <td>${venta.titulo}</td>
                        <td>Guatemala</td>
                        <td>${venta.precioLocal}</td>
                        <td>${venta.tipo}</td>
                        <td>${venta.duracion}</td>
                        <td>${venta.estado}</td>

                    `;

                    // Agregar la fila a la tabla
                    tablaBody.appendChild(fila);
                });
            } else {
                console.error('Error al obtener las ventas:', data.message);
            }
        })
        .catch(error => {
            console.error('Error al obtener las ventas:', error);
        });
});
