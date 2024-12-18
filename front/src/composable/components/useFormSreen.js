import { reactive, ref, computed } from 'vue';

export function useFormScreen(props) {
  // Reactive and ref properties
  const formsJSON = reactive({ data: props.formsJSON });
  const searchQuery = ref('');
  const selectedFilter = ref('name');
  const currentPage = ref(1);
  const itemsPerPage = 8;
  const editingForm = ref(null);
  const showEditModal = ref(false);
  const showDetailsModal = ref(false); // Nueva referencia para la ventana modal de detalles
  const viewingForm = ref(null); // Almacena el formulario seleccionado para ver detalles

  // Computed properties
  const filteredForms = computed(() => {
    const query = searchQuery.value.toLowerCase();
    return formsJSON.data.filter((form) =>
      form[selectedFilter.value].toLowerCase().includes(query)
    );
  });

  const paginatedForms = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return filteredForms.value.slice(startIndex, endIndex);
  });

  const totalPages = computed(() =>
    Math.ceil(filteredForms.value.length / itemsPerPage)
  );

  // Methods
  const changePage = (page) => {
    currentPage.value = page;
  };

  const deleteForm = (index) => {
    const globalIndex = (currentPage.value - 1) * itemsPerPage + index;
    formsJSON.data.splice(globalIndex, 1);
  };

  const editForm = (index) => {
    const globalIndex = (currentPage.value - 1) * itemsPerPage + index;
    editingForm.value = {
      ...formsJSON.data[globalIndex],
      index: globalIndex,
      questions: formsJSON.data[globalIndex].questions.map(question => ({
        ...question,
        answers: question.answers || ['']
      })),
    };
    console.log("Form to edit:", editingForm.value);
    showEditModal.value = true;
  };


  const saveEdit = () => {
    if (editingForm.value) {
      formsJSON.data[editingForm.value.index] = {
        name: editingForm.value.name,
        description: editingForm.value.description,
        questions: editingForm.value.questions,
      };
      showEditModal.value = false;
      editingForm.value = null;
    }
  };

  const addQuestion = () => {
    if (editingForm.value) {
      editingForm.value.questions.push({
        question: '',  // El texto de la pregunta
        answers: [''],     // Un array con las respuestas
      });
    }
  }

  const deleteQuestion = (questionIndex) => {
    if (editingForm.value) {
      editingForm.value.questions.splice(questionIndex, 1);
    }
  };

  // Método para agregar una respuesta a una pregunta
const addAnswer = (questionIndex) => {
  if (editingForm.value) {
    editingForm.value.questions[questionIndex].answers.push('');
  }
};


  // Método para eliminar una respuesta de una pregunta
  const deleteAnswer = (questionIndex, answerIndex) => {
    if (editingForm.value) {
      editingForm.value.questions[questionIndex].answers.splice(answerIndex, 1);
    }
  };


  const viewDetails = (index) => {
    const globalIndex = (currentPage.value - 1) * itemsPerPage + index;
    viewingForm.value = formsJSON.data[globalIndex];
    showDetailsModal.value = true;
  };

  return {
    forms: formsJSON,
    searchQuery,
    selectedFilter,
    currentPage,
    itemsPerPage,
    editingForm,
    showEditModal,
    showDetailsModal, // Añadido
    viewingForm, // Añadido
    filteredForms,
    paginatedForms,
    totalPages,
    changePage,
    addAnswer,
    deleteAnswer,
    deleteForm,
    editForm,
    saveEdit,
    addQuestion,
    deleteQuestion,
    viewDetails, // Añadido
  };
}
