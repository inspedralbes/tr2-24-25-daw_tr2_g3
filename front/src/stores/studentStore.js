import { ref } from 'vue';
import { defineStore } from 'pinia';

export const useStudentStore = defineStore('student', {
  state: () => {
    const id = ref("");
    const email = ref("");
    const authenticate = ref(false);
    const form_id = ref("");
    const group_code = ref("");

    return {id, email, authenticate, form_id, group_code };
  },
  persist: {
    enabled: true, // Activar persistencia

  },
});
