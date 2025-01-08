import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';
import { register, login } from '@/services/communicationManager';

export default function useLoginView() {
  const router = useRouter();
  const authStore = useAuthStore();

  const animateImage = ref(false);
  const showText = ref(true);
  const loginError = ref('');
  const registerError = ref('');
  const loginData = reactive({
    email: '',
    password: '',
    rememberMe: false
  });
  const registerData = reactive({
    username: '',
    lastname: '',
    type_document: '',
    id_document: '',
    birthdate: '',
    email: '',
    password: '',
    confirmPassword: ''
  });

  onMounted(() => {
    if (authStore.isAuthenticated) {
      router.push('/');
    }
  });

  function triggerRegister() {
    animateImage.value = !animateImage.value;
  }

  function loginWithGoogle() {
    window.location.href = `http://localhost:8000/auth/google`;
};

  async function registerUser() {
    console.log('registerUser called');
    if (registerData.password !== registerData.confirmPassword) {
      registerError.value = "Las contraseñas no coinciden";
      return;
    }
    try {
      const response = await register(registerData);
      authStore.login(response.user, response.token);
      alert('Registrado Correctamente');
      router.push('/');
    } catch (error) {
      registerError.value = "Error en el registro";
      console.error("Error en el registro", error);
    }
  }

  async function loginUser() {
    console.log('loginUser called');
    try {
      const response = await login(loginData);

      authStore.login(response.user, response.token);
      if (loginData.rememberMe) {
        sessionStorage.setItem('token', response.token);
        sessionStorage.setItem('user', JSON.stringify(response.user));
      }
      router.push('/');
      console.log("Login exitoso", response);
    } catch (error) {
      loginError.value = "Error en el login";
      console.error("Error en el login", error);
    }
  }

  return {
    animateImage,
    showText,
    loginError,
    registerError,
    loginData,
    registerData,
    loginWithGoogle,
    triggerRegister,
    register: registerUser, // Map 'register' to 'registerUser'
    login: loginUser        // Map 'login' to 'loginUser'
  };
}
