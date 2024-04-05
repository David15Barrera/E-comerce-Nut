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
    
    
    
    function cargarCiudades() {
        var paisSeleccionado = document.getElementById("pais").value;
        var ciudadSelect = document.getElementById("ciudad");
        ciudadSelect.innerHTML = ""; // Limpiar opciones anteriores

        if (paisSeleccionado === "Estados Unidos") {
            ciudades = ["Nueva York", "Los Ángeles", "Chicago", "Houston"];
        } else if (paisSeleccionado === "Canada") {
            ciudades = ["Toronto", "Montreal", "Vancouver", "Ottawa"];
        } else if (paisSeleccionado === "Mexico") {
            ciudades = ["Ciudad de Mexico", "Guadalajara", "Monterrey", "Puebla", "Chiapas", "Chihuahua", "Baja California", "Campeche", "Coahuila", "Colima", "Durango", "Guanajuato"];
        } else if (paisSeleccionado === "Guatemala") {
            ciudades = ["Guatemala City", "Quetzaltenango", "Escuintla", "Chichicastenango", "Quiche", "Huehuetenango", "Santa Rosa", "Baja Verapaz", "Alta Verapaz", "Progreso", "Solola", "Totonicapan", "Suchitepequez", "Retalhuleu", "San Marcos", "Peten", "Izabal", "Zacapa", "Chimaltenango"];
        } else if (paisSeleccionado === "Espana") {
            ciudades = ["Madrid", "Barcelona", "Valencia", "Sevilla", "Bilbao", "Malaga", "Alicante", "Murcia", "Cordoba", "Valladolid", "Vigo", "Gijon", "LHospitalet de Llobregat"];
        } else if (paisSeleccionado === "Japon") {
            ciudades = ["Tokio", "Osaka", "Nagoya", "Sapporo", "Fukuoka", "Kobe", "Yokohama", "Kyoto", "Kawasaki", "Hiroshima", "Sendai", "Kitakyushu", "Chiba"];
        } else if (paisSeleccionado === "El Salvador") {
            ciudades = ["San Salvador", "Santa Ana", "Soyapango", "San Miguel", "Mejicanos", "Apopa", "Delgado", "Sonsonate", "Ilopango", "Usulutan", "Cojutepeque", "San Marcos", "Zacatecoluca"];
        } else if (paisSeleccionado === "Brasil") {
            ciudades = ["Sao Paulo", "Rio de Janeiro", "Brasilia", "Salvador", "Fortaleza", "Belo Horizonte", "Manaos", "Curitiba", "Recife", "Goiania", "Belem", "Porto Alegre", "Campinas"];
        } else if (paisSeleccionado === "Argentina") {
            ciudades = ["Buenos Aires", "Cordoba", "Rosario", "Mendoza", "Tucuman", "La Plata", "Mar del Plata", "Salta", "Santa Fe", "San Juan", "Resistencia", "Corrientes", "Posadas"];
        } else if (paisSeleccionado === "Chile") {
            ciudades = ["Santiago", "Valparaiso", "Concepción", "Antofagasta", "Viña del Mar", "Temuco", "Rancagua", "Talca", "Arica", "Iquique", "Puerto Montt", "La Serena", "Chillán"];
        } else if (paisSeleccionado === "Costa Rica") {
            ciudades = ["San Jose", "Alajuela", "Cartago", "Heredia", "Liberia", "Puntarenas", "Limon", "San Francisco", "San Rafael", "San Antonio", "Tibas", "Pavas", "Escazu"];
        } else if (paisSeleccionado === "Panama") {
            ciudades = ["Panama", "Colon", "David", "La Chorrera", "Tocumen", "Arraijan", "Las Cumbres", "La Cabima", "Santiago de Veraguas", "Chitre", "San Miguelito", "Penonome", "Pedregal"];
        } else {
            var ciudades = []; // Si no se selecciona un país válido, no se muestran ciudades
        }

        // Agregar opciones de ciudades al select
        ciudades.forEach(function(ciudad) {
            var option = document.createElement("option");
            option.text = ciudad;
            option.value = ciudad;
            ciudadSelect.add(option);
        });
    }