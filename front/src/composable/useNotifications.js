import Toastify from 'toastify-js'; // Importar Toastify
import 'toastify-js/src/toastify.css'; // Importar los estilos de Toastify

export function useNotifications() {

  // Función para mostrar una notificación con Toastify
  const showNotification = (message, status) => {
    Toastify({
      text: message,
      duration: 3000,   // Duración en milisegundos
      close: true,      // Mostrar botón de cierre
      gravity: "top",   // Posición: "top" o "bottom"
      position: "right", // Posición: "left", "center", "right"
      backgroundColor: status === 'success' ? 'green' : (status === 'error' ? 'red' : 'blue'), // Cambiar color según el estado
      stopOnFocus: true, // Detener la animación cuando el mouse pase sobre la notificación
    }).showToast();
  };

  return {
    showNotification
  }
}
