    document.getElementById('imagen').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagen-preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });


    function updatePrecios() {
        const tipoSeleccionado = document.getElementById('tipo').value;
        if (tipoSeleccionado === 'Productos') {
            convertirPrecioNutPoints(); // Si es Productos, convertir a nutPoints
            document.getElementById('precioSistema').removeAttribute('readonly');
            document.getElementById('precioLocal').setAttribute('readonly', true);
        } else {
            convertirPrecioQuetzales(); // Si es Servicio, convertir a Quetzales
            document.getElementById('precioSistema').setAttribute('readonly', true);
            document.getElementById('precioLocal').removeAttribute('readonly');
        }
    }
    

    function convertirPrecioNutPoints() {
        const precioSistemaInput = document.getElementById('precioSistema');
        const precioLocalInput = document.getElementById('precioLocal');
        const precioSistema = parseFloat(precioSistemaInput.value);
        
        if (!isNaN(precioSistema)) {
            const precioLocal = precioSistema * 10; // Tasa de conversión (1 Quetzal = 10 nutPoints)
            precioLocalInput.value = precioLocal.toFixed(2);
        } else {
            precioLocalInput.value = '';
        }
    }
    
    function convertirPrecioQuetzales() {
        const precioSistemaInput = document.getElementById('precioSistema');
        const precioLocalInput = document.getElementById('precioLocal');
        const precioLocal = parseFloat(precioLocalInput.value);
    
        if (!isNaN(precioLocal)) {
            const precioSistema = precioLocal / 10; // Tasa de conversión (1 Quetzal = 10 nutPoints)
            precioSistemaInput.value = precioSistema.toFixed(2);
        } else {
            precioSistemaInput.value = '';
        }
    }
    
    
    
