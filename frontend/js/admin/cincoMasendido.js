// Obtener los productos más vendidos
fetch("../../../backend/cincoMasVendido.php")
    .then(response => response.json())
    .then(data => {
        // Limpiar la tabla antes de agregar nuevas filas
        const tableBody = document.querySelector(".reportes-table tbody");
        tableBody.innerHTML = "";

        // Iterar sobre los datos recibidos y crear filas de tabla
        data.forEach(producto => {
            // Crear una nueva fila
            const row = document.createElement("tr");

            // Agregar las celdas con los datos de cada producto
            row.innerHTML = `
                <td>${producto.titulo}</td>
                <td>${producto.total_ventas}</td>
                <td>${producto.name}</td>
                <td>${producto.nombre_usuario}</td>
                
            `;

            // Agregar la fila a la tabla
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Error al obtener los productos más vendidos:', error));


    // Obtener el ranking de puntos
fetch("../../../backend/usuarioPuntos.php")
.then(response => response.json())
.then(data => {
    // Limpiar la tabla antes de agregar nuevas filas
    const tableBody = document.querySelector(".reportes2-table tbody");
    tableBody.innerHTML = "";

    // Iterar sobre los datos recibidos y crear filas de tabla
    data.forEach(usuario => {
        // Crear una nueva fila
        const row = document.createElement("tr");
        
        // Agregar las celdas con los datos de cada usuario
        row.innerHTML = `
            <td>${usuario.nombre}</td>
            <td>${usuario.apellido}</td>
            <td>${usuario.puntos_totales}</td>
        `;
        
        // Agregar la fila a la tabla
        tableBody.appendChild(row);
    });
})
.catch(error => console.error('Error al obtener el ranking de puntos:', error));


// Obtener los servicios más usados
fetch("../../../backend/serviciosUsados.php")
    .then(response => response.json())
    .then(data => {
        // Limpiar la tabla antes de agregar nuevas filas
        const tableBody = document.querySelector(".reportes3-table tbody");
        tableBody.innerHTML = "";

        // Iterar sobre los datos recibidos y crear filas de tabla
        data.forEach(servicio => {
            // Crear una nueva fila
            const row = document.createElement("tr");
            
            // Agregar las celdas con los datos de cada servicio
            row.innerHTML = `
                <td>${servicio.titulo_servicio}</td>
                <td>${servicio.inscripciones}</td>
                <td>${servicio.nombres} ${servicio.apellidos}</td>
            `;
            
            // Agregar la fila a la tabla
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Error al obtener los servicios más usados:', error));

    

    fetch("../../../backend/ingresosTotalesProd.php")
    .then(response => response.json())
    .then(data => {
        // Limpiar la tabla antes de agregar nuevas filas
        const tableBody = document.querySelector(".reportes4-table tbody");
        tableBody.innerHTML = "";

        // Iterar sobre los datos recibidos y crear filas de tabla
        data.forEach(ingreso => {
            // Crear una nueva fila
            const row = document.createElement("tr");
            
            // Agregar las celdas con los datos de cada servicio
            row.innerHTML = `
                <td>${ingreso.nombre_producto}</td>
                <td>${ingreso.ingresos_totales}</td>
             `;
            
            // Agregar la fila a la tabla
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Error al obtener los servicios más usados:', error));

       