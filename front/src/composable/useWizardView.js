import {onBeforeMount, reactive, ref} from 'vue';
import questions from '../assets/questions.json'
import {Notify} from 'quasar';

export default function useWizardView() {

  const showSidebar = ref(true);
  //Data questions
  const templateData = reactive({questions: questions || []})
  const currentQuestionIndex = ref(0)
  // List students
  const students = ref([]);
  const responses = ref([null, null, null]);
  const selectedStudent = ref(null);
  const totalResponses = ref([]);
  const draggedStudent = ref(null);

  const isModalOpen = ref(false);

  // Data students
  const totalStudents = ref([
    {id: 1, name: 'Juan Pérez', image: '../src/assets/50.png'},
    {id: 2, name: 'María López', image: '../src/assets/50.png'},
    {id: 3, name: 'Carlos Ramírez', image: '../src/assets/50.png'},
    {id: 4, name: 'Juan Pérez', image: '../src/assets/50.png'},
    {id: 5, name: 'María López', image: '../src/assets/50.png'},
    {id: 6, name: 'Carlos Ramírez', image: '../src/assets/50.png'},
    {id: 7, name: 'Juan Pérez', image: '../src/assets/50.png'},
    {id: 8, name: 'María López', image: '../src/assets/50.png'},
    {id: 9, name: 'Carlos Ramírez', image: '../src/assets/50.png'},
    {id: 10, name: 'Juan Pérez', image: '../src/assets/50.png'},
    {id: 11, name: 'María López', image: '../src/assets/50.png'},
    {id: 12, name: 'Carlos Ramírez', image: '../src/assets/50.png'},
  ]);

  const openModal = () => {
    isModalOpen.value = true
    console.log(isModalOpen.value)
  }

  const closeModal = () => {
    isModalOpen.value = false
    console.log(isModalOpen.value)
  }

  // ** Select student click on sidebar **
  // Function for selecting a student
  const selectStudent = (student) => {

    // Verify if the student selected is the same as the current
    if (selectedStudent.value && selectedStudent.value.id === student.id) {
      // If the same, deselect the student
      console.log('Estudiante deseleccionado:', selectedStudent.value.id);
      selectedStudent.value = null;
    } else {
      // If diferent, select the new student
      selectedStudent.value = student;
      console.log('Estudiante seleccionado en la variable global:', selectedStudent.value.id);
      console.log('Estudiante seleccionado:', student.id);
    }
  };

  // Function for dropping a student in a cell
  const dropStudent = (index) => {
    if (selectedStudent.value) {

      const alreadyAssigned = responses.value.some( // Avoid duplicates in other cells
        (response) => response && response.id === selectedStudent.value.id
      );

      if (alreadyAssigned) {
        customAlert('Aquest alumne ja ha estat assignat.', 'negative', 'warning', 'top-left', 2000)
        return;
      }

      responses.value[index] = selectedStudent.value;
      students.value = students.value.filter((s) => s.id !== selectedStudent.value.id); // Delete to the list

      console.log(`Estudiante ${selectedStudent.value.name} asignado a la casilla ${index + 1}`);

      selectedStudent.value = null;
    } else {
      customAlert('Selecciona un estudiant primer.', 'warning', 'info', 'top-right', 2000)
    }
  };

  // Return student to the list
  const returnStudent = (index) => {
    if (responses.value[index]) {
      const returnedStudent = responses.value[index];

      console.log('Estudiante a devolver a la lista de estudiantes:', returnedStudent)

      students.value.push(returnedStudent);

      responses.value[index] = null;

      customAlert(`${returnedStudent.name} ha sigut retornat a la llista.`, 'positive', 'info', 'top-right', 2000)
    }
  }

  // ** Drag student **
  //Save the student dragged
  const onDragStart = (student) => {
    draggedStudent.value = student;
  };

  // Verify the student is already assigned
  const isStudentAssigned = (student) => {
    return responses.value.some((response) => response && response.id === student.id);
  };

  // When delete the student, add him to the answers and remove him from the sidebar
  const onDrop = (index) => {
    if (draggedStudent.value) {
      // Verify if the student is already assigned
      let isDuplicate = responses.value.some( // some function verify that only one element meets the condition
        (response) => response && response.id === draggedStudent.value.id
      );

      if (isDuplicate) {
        customAlert('Aquest company ja ha estat assignat.', 'negative', 'warning', 'top-left', 2000)
        draggedStudent.value = null;
        return;
      }

      responses.value[index] = draggedStudent.value;

      // Delete student of the list
      students.value = students.value.filter(
        (student) => student.id !== draggedStudent.value.id
      );

      draggedStudent.value = null;
    }
  };

  // Verify that if a student votes that he is bad, he can't vote that he is good
  const restrictContradictoryVoting = () => {
    const seenIds = new Set();
    const duplicates = [];

    // console.log(currentQuestionIndex.value);

    for (let questionIndex = 0; questionIndex < totalResponses.value.length; questionIndex++) {
      for (let i = 0; i < responses.value.length; i++) {
        const currentResponse = totalResponses.value[questionIndex][i];

        if (currentResponse !== null && currentResponse?.id !== undefined) {
          if (seenIds.has(currentResponse.id)) { // When find a duplicate, add it to the duplicates list
            duplicates.push(currentResponse.id);
          } else { // If not a duplicate, add it to the Set
            seenIds.add(currentResponse.id);
          }
        }
      }
    }

    if (duplicates.length > 0) {
      customAlert("S'han esborrat les respostes duplicades.", 'negative', 'warning', 'top-left', 4500);
      customAlert("No pots votar al mateix company en múltiples respostes.", 'negative', 'warning', 'top-left', 4500);

      duplicates.forEach((id) => returnStudentToList(id)); // Return all duplicated students

      return true; // When find duplicates
    }

    return false; // When no find duplicates
  };


  const returnStudentToList = (studentId) => {

    const responseIndex = responses.value.findIndex(
      (response) => response && response.id === studentId
    );

    if (responseIndex !== -1) { // Get the student to return
      const studentToReturn = responses.value[responseIndex];

      // Verify if the student is already exist
      const studentExists = students.value.some((s) => s.id === studentToReturn.id);

      if (!studentExists) { // Add the student to the list
        students.value.push(studentToReturn);
      }

      responses.value[responseIndex] = null;
      console.log(`El estudiante ${studentToReturn.name} ha sido devuelto automáticamente a la lista.`);
    }
  };

  //Function that returns the answer to the students array and removes the answers
  const onDropReturn = () => {
    const indexStudent = students.value.findIndex((student) => student && student.id === draggedStudent.value.id);

    if (draggedStudent.value && indexStudent === -1) {
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
    const totalQuestions = templateData.questions.length;
    const currentProgress = currentQuestionIndex.value + 1; // Current question (starting from 1)
    return (currentProgress / totalQuestions) * 100;
  }

  // Synchronize `students` with `totalStudents` and current `responses`
  const syncStudentsWithResponses = () => {
    const currentResponses = totalResponses.value[currentQuestionIndex.value] || [];
    students.value = totalStudents.value.filter(
      (student) => !currentResponses.some((response) => response?.id === student.id)
    );
    responses.value = [...currentResponses]; // Sync responses to match current question
  };

  const nextQuestion = () => {

    console.log(totalResponses.value)
    if (currentQuestionIndex.value < templateData.questions.length - 1) {
      totalResponses.value[currentQuestionIndex.value] = responses.value;

      if (currentQuestionIndex.value === 0 || currentQuestionIndex.value === 1) {
        if (restrictContradictoryVoting()) {
          console.log('No se puede avanzar debido a respuestas duplicadas.');
          return
        }
      }
      currentQuestionIndex.value++;
      syncStudentsWithResponses();
    } else {
      console.log("Ya estás en la última pregunta.");
    }
  }

  const previousQuestion = () => {

    if (currentQuestionIndex.value > 0) {
      totalResponses.value[currentQuestionIndex.value] = [...responses.value];

      if (currentQuestionIndex.value === 0 || currentQuestionIndex.value === 1) {
        if (restrictContradictoryVoting()) {
          console.log('No se puede avanzar debido a respuestas duplicadas.');
          return
        }
      }
      currentQuestionIndex.value--;
      syncStudentsWithResponses();
    } else {
      console.log('Ya estás en la primera pregunta.');
    }
  };

  const customAlert = (text, color, icon, position, time) => {
    Notify.create({
      message: text,
      color: color,
      icon: icon,
      position: position,
      timeout: time
    });
  }

  const sendDataQuestions = () => {
    console.log('peticion para enviar los datos');
  }

  const handleSendData = () => {
    sendDataQuestions();
    console.log('Cerrando modal...')
    closeModal();
    currentQuestionIndex.value = 0
    console.log(totalResponses.value)
    window.location.reload();
  }

  onBeforeMount(() => {

    templateData.questions = questions.questions;
    totalResponses.value = templateData.questions.map(() => [null, null, null]);
    students.value = [...totalStudents.value];

  })

  return {
    showSidebar,
    students,
    responses,
    currentQuestionIndex,
    templateData,
    selectedStudent,
    isModalOpen,
    onDragStart,
    onDrop,
    onDropReturn,
    calculateProgress,
    nextQuestion,
    previousQuestion,
    isStudentAssigned,
    selectStudent,
    dropStudent,
    returnStudent,
    openModal,
    closeModal,
    sendDataQuestions,
    handleSendData,
  };
}
