import { reactive, ref, computed } from 'vue';
import { getAllForms, createForm, updateForm, deleteForm as apiDeleteForm } from '@/services/communicationManager';

export function useFormScreen(props) {
  const formsJSON = reactive({ data: [] }); // Inicializamos vacío para cargar desde la API
  const searchQuery = ref('');
  const selectedFilter = ref('name');
  const currentPage = ref(1);
  const itemsPerPage = 8;
  const editingForm = ref(null);
  const showEditModal = ref(false);
  const showDetailsModal = ref(false);
  const viewingForm = ref(null);

  // Cargar formularios desde la API
  const loadForms = async () => {
    const forms = await getAllForms();
    if (forms) formsJSON.data = forms;
  };

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

  const changePage = (page) => {
    currentPage.value = page;
  };

  const deleteForm = async (index) => {
    const globalIndex = (currentPage.value - 1) * itemsPerPage + index;
    const formId = formsJSON.data[globalIndex].id;

    const result = await apiDeleteForm(formId);
    if (result) {
      formsJSON.data.splice(globalIndex, 1);
    } else {
      console.error('Error al eliminar el formulario.');
    }
  };

  const editForm = (index) => {
    const globalIndex = (currentPage.value - 1) * itemsPerPage + index;
    editingForm.value = {
      ...formsJSON.data[globalIndex],
      index: globalIndex,
    };
    showEditModal.value = true;
  };

  const saveEdit = async () => {
    if (editingForm.value) {
      const updatedForm = {
        name: editingForm.value.name,
        description: editingForm.value.description,
        questions: editingForm.value.questions,
      };

      const result = await updateForm(editingForm.value.id, updatedForm);
      if (result) {
        formsJSON.data[editingForm.value.index] = result;
        showEditModal.value = false;
        editingForm.value = null;
      } else {
        console.error('Error al guardar los cambios.');
      }
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
    showDetailsModal,
    viewingForm,
    filteredForms,
    paginatedForms,
    totalPages,
    changePage,
    deleteForm,
    editForm,
    saveEdit,
    viewDetails,
    loadForms,
  };
}
