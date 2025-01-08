// src/plugins/socket.js
import { io } from 'socket.io-client';

// Cambia 'http://localhost:3000' por la URL de tu servidor
const socket = io('http://localhost:3000', {
  transports: ['websocket'], // Usa WebSocket como transporte principal
  reconnection: true,        // Intenta reconectar automáticamente
  reconnectionAttempts: 5    // Número máximo de intentos
});

export default socket;
