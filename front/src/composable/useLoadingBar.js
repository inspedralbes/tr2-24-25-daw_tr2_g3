import {useQuasar} from 'quasar';
import {ref} from 'vue';

export function useLoadingBar() {

  const $q = useQuasar();

  const progress = ref(0);

  // Function for init loading and handle loading bar
  const startLoading = () => {
    $q.loadingBar.start();

    let interval = setInterval(() => {
      if (progress.value >= 100) {
        $q.loadingBar.stop();
        clearInterval(interval);
      } else {
        // Increment progress
        progress.value += 10;
        $q.loadingBar.increment(10);
      }
    }, 500); // Increment progress every 500ms
  };

  return {
  startLoading,
  }
}
