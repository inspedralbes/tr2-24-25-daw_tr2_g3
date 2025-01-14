const express = require("express");
const cors = require("cors"); // Importar CORS
const UserController = require('./Controllers/UserController');
const SocketController = require('./Controllers/SocketController');
const ClusterController = require("./Controllers/ClusterController");

const app = express();
const port = 3000;

app.use(express.json());

app.use(cors({
    origin: '*', // Permite todos los orígenes
    methods: ["GET", "POST"], // Métodos HTTP permitidos
    allowedHeaders: ["Content-Type"], // Permite encabezados específicos si es necesario
    credentials: true // Permite el envío de cookies y cabeceras de autorización
}));

// Crear servidor HTTP
const http = require('http').Server(app);
// Inicializar Socket.IO
const io = require('socket.io')(http, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

// Rutas
app.get("/", UserController.getHello);
app.post("/load-data", ClusterController.loadData)


// Inicializar controlador de sockets
SocketController.initialize(io);

http.listen(port, () => {
    console.log(`Server running on port ${port}`);
});