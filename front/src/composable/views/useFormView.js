import { ref } from 'vue';

export function useFormScreen() {
const name = ref('');
const description = ref ('');
const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

return {
  name,
  isModalOpen,
  description,
  openModal,
  closeModal,
};
}
