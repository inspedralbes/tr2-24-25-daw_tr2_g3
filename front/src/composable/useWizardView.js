import { ref } from 'vue';

export function useWizardView() {

   // Sidebar Status
   const showSidebar = ref(true);

   // Lista de estudiantes
   const students = ref([
     { id: 1, name: 'Juan Pérez', image: 'https://via.placeholder.com/50' },
     { id: 2, name: 'María López', image: 'https://via.placeholder.com/50' },
     { id: 3, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50' },
     { id: 4, name: 'Juan Pérez', image: 'https://via.placeholder.com/50' },
     { id: 5, name: 'María López', image: 'https://via.placeholder.com/50' },
     { id: 6, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50' },
     { id: 7, name: 'Juan Pérez', image: 'https://via.placeholder.com/50' },
     { id: 8, name: 'María López', image: 'https://via.placeholder.com/50' },
     { id: 9, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50' },
     { id: 10, name: 'Juan Pérez', image: 'https://via.placeholder.com/50' },
     { id: 11, name: 'María López', image: 'https://via.placeholder.com/50' },
     { id: 12, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50' },
   ]);
 
   const responses = ref([null, null, null]); 
   const draggedStudent = ref(null); // Estudiante arrastrado
 
   //Save the student dragged
   const onDragStart = (student) => {
     draggedStudent.value = student;
   };
 
   //Cuando sueltas el estudiante
   const onDrop = (index) => {
     if (draggedStudent.value) {
       // Agregar al espacio de respuesta
       responses.value[index] = draggedStudent.value;
 
       // Quitar del sidebar
       students.value = students.value.filter(
         (student) => student.id !== draggedStudent.value.id
       );
 
       // Limpiar estudiante arrastrado
       draggedStudent.value = null;
     }
   };
 
   return {
     showSidebar,
     students,
     responses,
     onDragStart,
     onDrop,
   };
}
