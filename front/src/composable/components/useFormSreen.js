import { reactive, ref } from 'vue';

export function useFormScreen(props) {
  const name = ref('');
  const description = ref('');
  const isModalOpen = ref(false);
  const formsJSON = reactive({data: props.formsJSON});

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
    openModal,
    closeModal,
  };
}
