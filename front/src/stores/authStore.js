import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuthenticated: false, // Estado inicial
    user: null, // Detalles del usuario logueado
  }),
  actions: {
    login(userData) {
      this.isAuthenticated = true;
      this.user = userData; // Guarda los datos del usuario (ejemplo: nombre, email, etc.)
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
    },
  },
});
