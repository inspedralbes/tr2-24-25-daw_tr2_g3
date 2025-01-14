import { reactive, ref } from 'vue';

export function useFormView() {
  // Variables reactivas
  const name = ref('');
  const description = ref('');
  const isModalOpen = ref(false);
  const currentStep = ref(1); // Paso actual (1: Información del formulario, 2: Preguntas y respuestas)
  const currentQuestionIndex = ref(0); // Índice de la pregunta visible
  const showModal = ref(false); // Controlar la visibilidad del modal

  // Lista inicial de formularios
  const formsJSON = reactive([
    {
          "id": 1,
          "name": "Formulario de Inscripción",
          "description": "Formulario utilizado para registrar nuevos estudiantes en el sistema."
        },
        {
          "id": 2,
          "name": "Formulario de Encuesta",
          "description": "Encuesta para evaluar la satisfacción de los usuarios con el servicio."
        },
        {
          "id": 3,
          "name": "Formulario de Contacto",
          "description": "Formulario para recopilar información de contacto de clientes potenciales."
        },
        {
          "id": 4,
          "name": "Formulario de Feedback",
          "description": "Formulario para obtener retroalimentación sobre un producto o servicio."
        },
        {
          "id": 5,
          "name": "Formulario de Solicitud",
          "description": "Formulario para realizar solicitudes de recursos o permisos específicos."

        }
  ]);

  // Función para cargar datos en el formulario al editar
  const editForm = (id) => {
    const form = formsJSON.find((f) => f.id === id);
    if (form) {
      name.value = form.name;
      description.value = form.description;
      questions.splice(0, questions.length, ...form.questions.map((q) => ({
        question: q.question,
        answers: [...q.answers]
      })));
      showModal.value = true;
    }
  };

  // Lista de preguntas y respuestas
  const questions = reactive([{ question: '', answers: [''] }]);

  // Funciones para manejar preguntas y respuestas
  const addQuestion = () => {
    questions.push({ question: '', answers: [''] });
    currentQuestionIndex.value = questions.length - 1; // Mover a la nueva pregunta
  };

  const removeQuestion = (index) => {
    if (questions.length > 1) {
      questions.splice(index, 1);
      currentQuestionIndex.value = Math.min(currentQuestionIndex.value, questions.length - 1); // Ajustar índice actual
    }
  };

  const addAnswer = () => {
    questions[currentQuestionIndex.value].answers.push('');
  };

  const removeAnswer = (aIndex) => {
    if (questions[currentQuestionIndex.value].answers.length > 1) {
      questions[currentQuestionIndex.value].answers.splice(aIndex, 1);
    }
  };

  // Navegación entre preguntas
  const nextQuestion = () => {
    if (currentQuestionIndex.value < questions.length - 1) {
      currentQuestionIndex.value++;
    }
  };

  const prevQuestion = () => {
    if (currentQuestionIndex.value > 0) {
      currentQuestionIndex.value--;
    }
  };

  // Guardar formulario completo
  const saveFullForm = () => {
    const formIndex = formsJSON.findIndex((form) => form.name === name.value);

    const newForm = {
      name: name.value,
      description: description.value,
      questions: JSON.parse(JSON.stringify(questions))
    };

    if (formIndex !== -1) {
      formsJSON[formIndex] = newForm;
    } else {
      formsJSON.push(newForm);
    }

    name.value = '';
    description.value = '';
    questions.splice(0, questions.length, { question: '', answers: [''] });
    currentStep.value = 1;
    currentQuestionIndex.value = 0;
    showModal.value = false;
  };

  // Navegación entre pasos del formulario
  const goToNextStep = () => {
    if (currentStep.value === 1) currentStep.value = 2;
  };

  const goToPreviousStep = () => {
    if (currentStep.value === 2) currentStep.value = 1;
  };

  // Ir a la pregunta seleccionada
  const goToQuestion = (index) => {
    currentQuestionIndex.value = index; // Actualizar el índice de la pregunta actual
  };

  const cancelForm = () => {
    showModal.value = false;
    name.value = '';
    description.value = '';
    questions.splice(0, questions.length, { question: '', answers: [''] });
    currentStep.value = 1;
    currentQuestionIndex.value = 0;
  };

  // Abrir y cerrar modal
  const openModal = () => {
    isModalOpen.value = true;
  };

  const closeModal = () => {
    isModalOpen.value = false;
  };

  return {
    name,
    description,
    isModalOpen,
    formsJSON,
    currentStep,
    questions,
    currentQuestionIndex,
    showModal,
    addQuestion,
    removeQuestion,
    addAnswer,
    removeAnswer,
    nextQuestion,
    prevQuestion,
    saveFullForm,
    goToNextStep,
    goToPreviousStep,
    goToQuestion,
    cancelForm,
    openModal,
    editForm,
    closeModal
  };
}
