document.addEventListener("DOMContentLoaded", function() {
    const chatList = document.querySelector(".chat-list");
    const chatMessages = document.querySelector(".chat-messages");

    // Función para obtener y mostrar los nombres de los usuarios interesados
    function mostrarUsuariosInteresados() {
        // Obtener la información de los usuarios que quieren interactuar con el usuario actual
        fetch('../../../backend/chatver.php')
            .then(response => response.json())
            .then(data => {
                // Limpiar el chatList antes de agregar los nuevos elementos
                chatList.innerHTML = "";

                // Mostrar la información de los usuarios interesados
                data.forEach(user => {
                    const chatItem = document.createElement('div');
                    chatItem.classList.add('chat-person');
                    chatItem.setAttribute('data-contact', user.nombre +" "+ user.lastname);
                    chatItem.setAttribute('data-publicacionId', user.publicacionesId);

                    const img = document.createElement('img');
                    img.src = "../../img/avatar.png";
                    img.alt = "Avatar";
                    img.classList.add('avatar');
                    chatItem.appendChild(img);

                    const info = document.createElement('div');
                    info.classList.add('info');

                    const name = document.createElement('h3');
                    name.textContent = user.nombre +" "+ user.lastname; 
                    info.appendChild(name);

                    const product = document.createElement('p');
                    product.textContent = user.titulo_publicacion;
                    info.appendChild(product);

                    chatItem.appendChild(info);

                    chatList.appendChild(chatItem);
                });
            })
            .catch(error => console.error('Error al obtener la información:', error));
    }

    // Función para obtener y mostrar los mensajes según el contacto seleccionado
    function mostrarConversacion(publicacionId) {
        // Obtener los mensajes del chat relacionados con la publicación
        fetch(`../../../backend/chats.php?publicacionesId=${publicacionId}`)
            .then(response => response.json())
            .then(data => {
                // Limpiar los mensajes anteriores
                chatMessages.innerHTML = "";

                data.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('message');
                    
                    // Determinar si el mensaje fue enviado por el usuario actual
                    const isSentByUser = message.emisor == data.userId;                    
                    console.log(data.userId);
                    // Determinar si el mensaje fue recibido por el usuario actual
                    const isReceivedByUser = message.receptor == data.userId;                    
                    console.log(isReceivedByUser)
                    // Si el mensaje fue enviado por el usuario actual, aplicar la clase 'sent'
                    if (isSentByUser) {
                        messageDiv.classList.add('received');
                    } else if (isReceivedByUser) {
                        // If the message was received, apply the 'received' class
                        messageDiv.classList.add('sent');
                    }
                
                    messageDiv.innerHTML = `
                        <p>${message.mensaje}</p>
                        <div class="message-timestamp">${message.timeMessage}</div>
                    `;
                    
                    chatMessages.appendChild(messageDiv);
                });

                const composeDiv = document.createElement('div');
                composeDiv.classList.add('compose');
                composeDiv.innerHTML = `
                    <textarea placeholder="Escribe un mensaje..."></textarea>
                    <button>Enviar</button>
                `;
                chatMessages.appendChild(composeDiv);

            })
            .catch(error => console.error('Error al obtener la conversación:', error));
    }

    // Llamar a la función al cargar la página
    mostrarUsuariosInteresados();

    // Agregar el evento click a los elementos chat-person
    chatList.addEventListener('click', function(event) {
        const chatPerson = event.target.closest('.chat-person');
        if (chatPerson) {
            // Obtener el ID de la publicación
            const publicacionId = chatPerson.getAttribute('data-publicacionId');
            // Mostrar la conversación correspondiente
            mostrarConversacion(publicacionId);
        }
    });
});
