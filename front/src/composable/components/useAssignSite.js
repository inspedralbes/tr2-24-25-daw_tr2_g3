import {onMounted, reactive, ref} from "vue";
import socket from "@/services/sockets.js";

export function useAssignSite() {
  const name = ref('Kevin');
  const droppedItems = reactive([]);
  const draggedItem = ref(null);

  const heightS = ref('40px');

  const students = reactive([]);

  const studentsPlaceholder = Array(24).fill({}); // Crear 24 elementos vacíos para simular tarjetas vacías

  onMounted(() => {

  });

  const widhts = reactive({
    widhtS: '40px',
    widhtM: '60px',
    widhtL: '80px'
  })

  function clickName(index) {
    const data = {
      id: index,
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

    const {id, user} = data;

    // Buscar si el usuario ya está asignado a otra posición
    const existingIndex = students.findIndex(student => student?.id === user.id);
    if (existingIndex !== -1) {
      // Limpiar la posición anterior
      //students[existingIndex].pop();
      students.splice(existingIndex, 1)
    }

    // Asignar el usuario a la nueva posición
    students[id] = user;
  });

  function saveAssigned(){
    console.log("FIN", students)
  }

/*
  function onDragStart(itemId) {
    console.log("B", itemId);
    draggedItem.value = itemId;
  }

  function onDrop(event) {
    if (draggedItem.value) {
      const rect = event.target.getBoundingClientRect();
      const x = event.clientX - rect.left;
      const y = event.clientY - rect.top;

      // Calcular la fila y la columna en la cuadrícula
      const col = Math.floor(x / 50);  // 50px de ancho por cada "cuadrado"
      const row = Math.floor(y / 50);  // 50px de altura por cada "cuadrado"

      // Verificar si la celda está ocupada
      const isOccupied = droppedItems.some(item => {
        const itemCol = Math.floor(parseInt(item.style.left) / 50);
        const itemRow = Math.floor(parseInt(item.style.top) / 50);
        return itemCol === col && itemRow === row;
      });

      if (isOccupied) {
        console.warn(`La celda (${col}, ${row}) ya está ocupada.`);
        return; // No permitir colocar el elemento en una celda ocupada
      }

      // Definir el ancho dependiendo del elemento
      const width =
        draggedItem.value === "c1"
          ? widhts.widhtS
          : draggedItem.value === "c2"
            ? widhts.widhtM
            : widhts.widhtL;

      // Agregar un nuevo elemento con la posición en la cuadrícula
      droppedItems.push({
        id: `${draggedItem.value}-${droppedItems.length}`, // ID único
        style: {
          position: "absolute",
          left: `${col * 50}px`, // Coloca el botón en la columna correspondiente
          top: `${row * 50}px`,  // Coloca el botón en la fila correspondiente
          width: width,
          height: "40px",
          backgroundColor: "black",
          border: "3px solid black",
        },
      });

      // Limpiar el elemento arrastrado
      draggedItem.value = null;
    }
  }*/

  return {
    name,
    heightS,
    widhts,
    droppedItems,
    draggedItem,
    students,
    studentsPlaceholder,
    clickName,
    saveAssigned
  }
}
