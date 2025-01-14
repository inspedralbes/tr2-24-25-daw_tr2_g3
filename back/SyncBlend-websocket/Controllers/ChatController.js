const axios = require('axios');

function handleConnection(socket, io) {
    console.log(`User connected with socket ID: ${socket.id}`);

    // Escuchar evento para unirse a un chat
    socket.on('joinChat', (chatId) => {
        socket.join(chatId);
        console.log(`User ${socket.id} joined chat: ${chatId}`);
    });

    // Escuchar mensajes enviados por el cliente
    socket.on('sendMessage', async (message) => {
        console.log('Server received message:', message.content);
        console.log('Message received:', message);

        // Validación básica
        if (!message.chatId || !message.content || !message.senderId) {
            console.error('Invalid message data:', message);
            return;
        }

        // Emitir mensaje a todos los clientes en la misma sala
        io.to(message.chatId).emit('newMessage', message);
        console.log(`Message sent to chat ${message.chatId}:`, message.content);

        

        try {
            const response = await fetch('http://172.19.0.5:8000/api/chats/storeMessage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${message.token}` 
                },
                body: JSON.stringify({
                    chat_id: message.chatId,
                    sender_id: message.senderId,
                    content: message.content
                })
            });
            console.log('Pase');
            if (response.ok) {
                const json = await response.json();
                console.log('Message saved successfully:', json);
            } else {
                console.error(`Error saving message: ${response.status} ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error details:', {
                message: error.message,
                cause: error.cause,
                stack: error.stack,
            });
        }
          
    });

    // Puedes agregar más lógica aquí, como historial de mensajes, notificaciones, etc.
}

module.exports = { handleConnection };
