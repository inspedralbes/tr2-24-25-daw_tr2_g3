<template>
    <div>
      <p>Procesando inicio de sesión...</p>
    </div>
  </template>
  
  <script>
  import { useRouter } from 'vue-router';
  import { useAuthStore } from '@/stores/authStore';
  
  export default {
    setup() {
      const router = useRouter();
      const authStore = useAuthStore();
  
      // Procesar el token del callback
      async function handleCallback() {
        const urlParams = new URLSearchParams(window.location.search);
        const userParam = urlParams.get('user');
  
        if (userParam) {
          try {
            const userData = JSON.parse(decodeURIComponent(userParam));
            const { token, ...user } = userData;
  
            // Guardar token y usuario en el store
            authStore.login(user, token);
  
            router.push('/');
          } catch (error) {
            console.error('Error al procesar el callback:', error);
            alert('Hubo un problema con el inicio de sesión.');
            router.push('/login');
          }
        } else {
          console.error('No se encontró token en la URL');
          alert('Inicio de sesión fallido.');
          router.push('/login');
        }
      }
  
      handleCallback();
  
      return {};
    },
  };
  </script>
