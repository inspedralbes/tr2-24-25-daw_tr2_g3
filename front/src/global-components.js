import { createApp } from 'vue';
import LoadingScreen from '@/components/LoadingScreen.vue';
import App from './App.vue'

const app = createApp(App);

// Registering the component globally
app.component('loadingScreen', LoadingScreen);
