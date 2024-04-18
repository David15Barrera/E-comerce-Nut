// Obtener los reportes de usuario
fetch("../../../backend/verReportesUser.php")
    .then(response => response.json())
    .then(data => {
        // Limpiar la tabla antes de agregar nuevas filas
        const tableBody = document.querySelector(".reportes-table tbody");
        tableBody.innerHTML = "";

        // Iterar sobre los datos recibidos y crear filas de tabla
        data.forEach(report => {
            // Crear una nueva fila
            const row = document.createElement("tr");
            console.log(report.idReporte);
            // Agregar las celdas con los datos de cada reporte
            row.innerHTML = `
                <td>${report.nombreReportado}</td>
                <td>${report.apellidoReportado}</td>
                <td>${report.correoReportado}</td>
                <td>${report.razonReporte}</td>
                <td>${report.nombreReportador} ${report.apellidoReportador}</td>
                <td>${report.tituloPublicacion}</td>
                <td>${report.estadoReporte}</td>
                <td>
                    <button class="suspender-btn" data-report-id="${report.idReporte}">Suspender Usuario</button>
                </td>
            `;

            // Agregar la fila a la tabla
            tableBody.appendChild(row);
        });

        // Agregar un evento de clic a los botones de suspender usuario
        const suspendButtons = document.querySelectorAll('.suspender-btn');
        suspendButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el ID del reporte asociado al botón
                const reportId = this.getAttribute('data-report-id');
                console.log(reportId);
                // Crear un objeto FormData y agregar el ID del reporte
                const formData = new FormData();
                formData.append('reportId', reportId);

                // Realizar una solicitud para cambiar el estado del reporte
                fetch("../../../backend/suspenderUser.php", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Si se cambió el estado del reporte correctamente, recargar la página
                        location.reload();
                    } else {
                        // Si ocurrió un error al cambiar el estado del reporte, mostrar un mensaje de error
                        console.error('Error al cambiar el estado del reporte:', data.message);
                    }
                })
                .catch(error => console.error('Error al cambiar el estado del reporte:', error));
            });
        });

    })
    .catch(error => console.error('Error al obtener los reportes:', error));
