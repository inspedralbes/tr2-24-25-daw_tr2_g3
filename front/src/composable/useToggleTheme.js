import {ref} from 'vue';
import {useQuasar} from 'quasar';

export function useToggleTheme() {

  const $q = useQuasar();

// Reference to know if dark mode is active
  const isDarkMode = ref($q.dark.isActive);

// Function to toggle dark mode
  const toggleDarkMode = () => {
    $q.dark.toggle();
    isDarkMode.value = $q.dark.isActive;
  };

  return {
    isDarkMode,
    toggleDarkMode
  }
}
