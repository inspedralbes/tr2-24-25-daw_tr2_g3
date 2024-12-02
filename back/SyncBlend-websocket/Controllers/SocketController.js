class SocketController {
    static initialize(io) {
        var userNumber = 0;

        io.on('connection', (socket) => {
            console.log('A user connected');
            socket.idUser = userNumber++;
            socket.on('message', (data) => {
                console.log('Message received:', data);
                io.emit('message', {id:socket.idUser,message:data});
            });

            socket.on('disconnect', () => {
                console.log('User disconnected');
            });
        });
    }
}

module.exports = SocketController;