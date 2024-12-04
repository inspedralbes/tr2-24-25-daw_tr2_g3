import {onMounted, reactive, ref} from "vue";
import socket from "@/services/sockets.js";

export function useAssignSite() {
  const name = ref('Kevin');
  const droppedItems = reactive([]);
  const draggedItem = ref(null);

  const heightS = ref('40px');

  const students = reactive([]);
  const contador = ref(0);

  const seats =reactive( Array(24).fill(null).map((_, index) => ({
    position: index,
    occupied: false,
    users: []
  })));

  const studentsPlaceholder = Array(24).fill({}); // Crear 24 elementos vacíos para simular tarjetas vacías

  onMounted(() => {

  });

  const widhts = reactive({
    widhtS: '40px',
    widhtM: '60px',
    widhtL: '80px'
  })

  function clickName(index) {
    const seat  = seats[index];
    if(seat.occupied){
      alert("Asiento Ocupado")
      return
    }
    const data = {
      position: index,
      user: {
        id: 1,
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVHuaHBzb1_5EWWuVXAIAZwyreKC09F-0oAg&s',
        firstname: 'Pepe',
        lastname: 'Gonzalez'
      }
    }

    socket.emit('assignSite', data);
  }

  socket.on('assignedSite', (data) => {

    const {position, user} = data;

    // Verifica si la posición está dentro del rango de asientos
    if (seats[position]) {
      // Eliminar al usuario de cualquier otra posición ocupada
      seats.forEach((seat) => {
        if (seat.users.some((u) => u.id === user.id)) {
          seat.occupied = false;
          seat.users = [];
        }
      });

      // Verifica si el asiento está vacío antes de asignar
      const seat = seats[position];
      if (seat.occupied) {
        console.log("Este asiento ya está ocupado.");
        return; // No hacer nada si el asiento ya está ocupado
      }

      // Asignar el usuario a la nueva posición
      seat.occupied = true;
      seat.users = [user];

      // Actualizar contador
      contador.value = seats.filter((seat) => seat.occupied).length;
    } else {
      console.error("Posición no válida:", position);
    }
  });

  function saveAssigned(){
    console.log("FIN", seats)
  }

  return {
    name,
    heightS,
    widhts,
    seats,
    droppedItems,
    draggedItem,
    students,
    studentsPlaceholder,
    contador,
    clickName,
    saveAssigned
  }
}
