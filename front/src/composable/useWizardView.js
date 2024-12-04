import {onBeforeMount, reactive, ref} from 'vue';
import questions from '../assets/questions.json'


export function useWizardView() {

  // Sidebar Status
  const showSidebar = ref(true);
  const templateData = reactive({questions: questions})

  // Lista de estudiantes
  const students = ref([
    {id: 1, name: 'Juan Pérez', image: 'https://via.placeholder.com/50'},
    {id: 2, name: 'María López', image: 'https://via.placeholder.com/50'},
    {id: 3, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50'},
    {id: 4, name: 'Juan Pérez', image: 'https://via.placeholder.com/50'},
    {id: 5, name: 'María López', image: 'https://via.placeholder.com/50'},
    {id: 6, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50'},
    {id: 7, name: 'Juan Pérez', image: 'https://via.placeholder.com/50'},
    {id: 8, name: 'María López', image: 'https://via.placeholder.com/50'},
    {id: 9, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50'},
    {id: 10, name: 'Juan Pérez', image: 'https://via.placeholder.com/50'},
    {id: 11, name: 'María López', image: 'https://via.placeholder.com/50'},
    {id: 12, name: 'Carlos Ramírez', image: 'https://via.placeholder.com/50'},
  ]);

  const responses = ref([null, null, null]);
  const draggedStudent = ref(null); // Estudiante arrastrado

  //Save the student dragged
  const onDragStart = (student) => {
    draggedStudent.value = student;
  };

  const wordCount = () => {
    // Verifica si hay descripción en la pregunta
    if (templateData.questions[2].description) {
      const description = templateData.questions[2].description.trim().split(/\s+/);  // Divide el texto en palabras

      // Si la cantidad de palabras es mayor que 25, se hace un salto de línea
      const CANT = 22
      if (description.length > CANT) {
        // Divide el texto en dos partes
        const firstPart = description.slice(0, CANT).join(' ');  // Primer parte (25 palabras)
        const secondPart = description.slice(CANT).join(' ');   // Resto de palabras
        return { firstPart, secondPart };  // Devuelve un objeto con las dos partes del texto
      }

      // Si no hay más de 25 palabras, devuelve el texto completo
      return { firstPart: description, secondPart: '' };
    }

    return { firstPart: '', secondPart: '' };  // Si no hay descripción, devuelve texto vacío
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

  onBeforeMount(() => {
    templateData.questions = questions.questions;
    wordCount()
  })

  return {
    showSidebar,
    students,
    responses,
    onDragStart,
    onDrop,
    templateData,
    wordCount,
  };
}
