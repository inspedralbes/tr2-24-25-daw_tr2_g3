import { createApp } from 'vue';
import LoadingScreen from '@/components/LoadingScreen.vue'; // Ruta del componente
import App from './App.vue'

const app = createApp(App);

// Registrando el componente globalmente
app.component('loadingScreen', LoadingScreen);
