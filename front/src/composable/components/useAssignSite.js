import {reactive, ref} from "vue";

export function useAssignSite() {
  const name = ref('Kevin');
  const droppedItems = reactive([]);
  const draggedItem = ref(null);

  const heightS = ref('40px');

  const students = reactive([]);

  const widhts = reactive({
    widhtS: '40px',
    widhtM: '60px',
    widhtL: '80px'
  })

  function clickName() {
    console.log("CLICADO");
    students.push({
      id: (students.length+1),
      image: "https://via.placeholder.com/150",
      firstName: 'Pepe',
      lastName: 'Gonzalez'
    });
  }

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
  }

  return {
    name,
    heightS,
    widhts,
    droppedItems,
    draggedItem,
    students,
    onDragStart,
    onDrop,
    clickName
  }
}
