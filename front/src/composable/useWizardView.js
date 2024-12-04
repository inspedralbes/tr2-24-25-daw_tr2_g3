import { onBeforeMount, reactive, ref } from 'vue';
import questions from '../assets/questions.json'


export function useWizardView() {

  //Data of questions
  const templateData = reactive({ questions: questions })
  const currentQuestionIndex = ref(0)

  // List of students
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
  const draggedStudent = ref(null); 

  //Save the student dragged
  const onDragStart = (student) => {
    draggedStudent.value = student;
  };

  //When I delete the student, I add him to the answers and remove him from the sidebar
  const onDrop = (index) => {
    if (draggedStudent.value) {
      responses.value[index] = draggedStudent.value;

      students.value = students.value.filter(
        (student) => student.id !== draggedStudent.value.id
      );

      draggedStudent.value = null;
    }
  };

  //Function that returns the answer to the students array and removes the answers
  const onDropReturn = () => {
    const indexStudent = students.value.findIndex((student) => student && student.id === draggedStudent.value.id);
    if (draggedStudent.value && indexStudent == -1) {
      //Check if the student exists
      const exists = students.value.some((s) => s.id === draggedStudent.id);
      if (!exists) {
        students.value.push(draggedStudent.value);

        //Delete response
        const indexInResponses = responses.value.findIndex((response) => response && response.id === draggedStudent.value.id);
        if (indexInResponses !== -1) {
          responses.value[indexInResponses] = null;
          draggedStudent.value = null;
        }
      }
    }
  }

  //Calculate the progress for the sidebar
  const calculateProgress = () => {
    const totalQuestions = templateData.questions.length; // Total questions
    const currentProgress = currentQuestionIndex.value + 1; // Current question (starting from 1)
    return (currentProgress / totalQuestions) * 100;
  }

  const nextQuestion = () => {

    if (currentQuestionIndex.value < templateData.questions.length - 1) {
      currentQuestionIndex.value++;
    } else {
      console.log("Ya estás en la última pregunta.");
    }
  }

  onBeforeMount(() => {

    templateData.questions = questions.questions;
    console.log(templateData.questions)
  })

  return {
    students,
    responses,
    currentQuestionIndex,
    onDragStart,
    onDrop,
    onDropReturn,
    calculateProgress,
    nextQuestion,
    templateData,
  };
}
