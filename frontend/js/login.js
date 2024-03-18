//-------------------------- Seccion de manejo del del input del login---------------------------------

const inputs = document.querySelectorAll(".input");

function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}

inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});

document.getElementById('Login').addEventListener('submit', function(event) {
    event.preventDefault();

    var correo = document.getElementById('correo').value;
    var password = document.getElementById('password').value;

    if (correo.trim() === '' || password.trim() === '') {
        document.getElementById('mensaje').innerHTML = 'Por favor, completa todos los campos';
        return;
    }

    var formData = new FormData();
    formData.append('correo', correo);
    formData.append('password', password);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if (xhr.responseText === 'success_usuario') {
                    window.location.href = '../views/comun/inicioComun.html';
                } else if (xhr.responseText === 'success_administrador') {
                    window.location.href = '../views/admin/inicioAdmin.html';
                } else {
                    document.getElementById('mensaje').innerHTML = 'Credenciales inválidas';
                }
            } else {
                console.log('Hubo un problema con la solicitud.');
            }
        }
    };
    xhr.open('POST', '../../backend/login.php', true);
    xhr.send(formData);
});
