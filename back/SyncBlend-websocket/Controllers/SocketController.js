const ChatController = require('./ChatController');
class SocketController {
    static initialize(io) {
        var userNumber = 0;
        const generator = require('generate-password');

        io.on('connection', (socket) => {
            console.log('A user connected');
            socket.idUser = userNumber++;
            socket.on('message', (data) => {
                console.log('Message received:', data);
                io.emit('message', {id: socket.idUser, message: data});
            });
            
            ChatController.handleConnection(socket, io);


            socket.on('createClass', () => {
                let code = generator.generate({
                    length: 6,
                    numbers: true,
                    symbols: false,
                });
                io.emit('codeCreated', code);
            });

            socket.on('assignSite', (data) => {
                console.log("Back Json", data);
                const {position, user} = data;
                io.emit('assignedSite', {position, user});
            });

            socket.on('disconnect', () => {
                console.log('User disconnected');
            });
        });
    }
}

module.exports = SocketController;