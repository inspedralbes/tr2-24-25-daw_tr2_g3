import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuthenticated: false, // Estado inicial
    token: sessionStorage.getItem('token') || null, //Token usuario
    user: JSON.parse(sessionStorage.getItem('user')) || null, // Detalles del usuario logueado
  }),
  actions: {
    login(userData, userToken) {
      this.isAuthenticated = true;
      this.user = userData;
      this.token = userToken;
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
      this.token = null;
      sessionStorage.removeItem('token');
      sessionStorage.removeItem('user');
    },
    initialize() {
      const token = sessionStorage.getItem('token');
      const user = JSON.parse(sessionStorage.getItem('user'));
      if (token && user) {
        this.login(user, token);
      }
    }
  },
});

// // Initialize the auth store when the application starts
// const authStore = useAuthStore();
// authStore.initialize();
