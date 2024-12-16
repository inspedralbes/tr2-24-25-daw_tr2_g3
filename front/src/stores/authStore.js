import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuthenticated: false, // Estado inicial
    token: null, //Token usuario
    user: null, // Detalles del usuario logueado
  }),
  actions: {
    login(userData, userToken) {
      this.isAuthenticated = true;
      this.user = userData; // Guarda los datos del usuario (ejemplo: nombre, email, etc.)
      this.token = userToken; // Guarda el token del usuario
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
    },
  },
});
