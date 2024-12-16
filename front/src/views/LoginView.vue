<template>
  <div class="flex min-h-screen bg-gray-50">
    <!-- Left Side (Login Content) -->
    <div class="w-1/2 max-w-md mx-auto flex flex-col justify-center p-8">
      <div>
        <div class="text-indigo-600 text-4xl font-bold mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline-block" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 3a3 3 0 00-3 3v8a3 3 0 003 3h10a3 3 0 003-3V6a3 3 0 00-3-3H5zm2.707 7.707a1 1 0 00-1.414-1.414L5 10.586 3.707 9.293a1 1 0 10-1.414 1.414L4.586 12l-2.293 2.293a1 1 001.414 1.414L5 13.414l1.293 1.293a1 1 001.414-1.414L6.414 12l1.293-1.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <h2 class="text-2xl font-semibold text-gray-900">Inicieu la sessió al vostre compte</h2>
        <p class="mt-3 text-gray-600">
          No ets membre? 
          <a href="#" class="text-indigo-600 hover:underline" @click="triggerRegister">Registra't</a>
        </p>
      </div>

      <div class="mt-8 space-y-6">
        <div class="space-y-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Adreça de correu electrònic</label>
            <input
              id="email"
              name="email"
              type="email"
              autocomplete="email"
              v-model="loginData.email"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contrasenya</label>
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              v-model="loginData.password"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember-me"
              name="remember-me"
              type="checkbox"
              v-model="loginData.rememberMe"
              class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
            />
            <label for="remember-me" class="ml-2 block text-sm text-gray-900">Recorda'm</label>
          </div>

          <div class="text-sm">
            <a href="#" class="font-medium text-indigo-600 hover:underline">Heu oblidat la contrasenya?</a>
          </div>
        </div>

        <div>
          <div v-if="loginError" class="mb-4 text-red-500 text-sm">{{ loginError }}</div>
          <button
            type="submit"
            @click="login"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Iniciar Sessió
          </button>
        </div>
      </div>

      <div class="mt-6">
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-gray-50 text-gray-500">O continuar amb</span>
          </div>
        </div>

        <div class="mt-6 flex flex-col gap-3">
          <div>
            <a
              href="#"
              class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
            >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20px" height="20px">
              <path fill="#EA4335" d="M24 9.5c3.54 0 6.77 1.22 9.33 3.57l7.02-7.03C36.01 2.56 30.3 0 24 0 14.55 0 6.47 5.33 2.47 13.09l8.26 6.42C12.7 13.8 17.98 9.5 24 9.5z" />
              <path fill="#4285F4" d="M46.5 24c0-1.55-.14-3.05-.41-4.5H24v9.29h12.74c-.94 3.51-3.29 6.49-6.33 8.45l8.17 6.35C44.43 39.33 46.5 32.17 46.5 24z" />
              <path fill="#FBBC05" d="M11.03 27.32c-.5-1.47-.79-3.03-.79-4.66s.29-3.19.79-4.66L2.47 13.09C.91 16.16 0 19.51 0 23c0 3.49.91 6.84 2.47 9.91l8.56-6.48z" />
              <path fill="#34A853" d="M24 48c6.3 0 11.63-2.07 15.51-5.62l-8.17-6.35c-2.27 1.52-5.19 2.42-8.34 2.42-6.02 0-11.3-4.3-13.27-10.06l-8.26 6.42C6.47 42.67 14.55 48 24 48z" />
              <path fill="none" d="M0 0h48v48H0z" />
            </svg>
            <span class="ml-2">Google</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side (Image and Registration Form) -->
    <div class="w-1/2 relative flex flex-col justify-center p-8 bg-cover">
      <img 
        src="@/assets/loginImage.avif" 
        alt="Login Image" 
        :class="{'transform -translate-x-full': animateImage, 'transition-transform duration-700': true}" 
        class="absolute top-0 left-0 w-full h-full object-cover cursor-pointer" 
        @click="triggerRegister"
      />
      <div v-if="showText" class="max-w-md mx-auto flex flex-col justify-center p-8">
        <h2 class="text-2xl font-semibold text-gray-900">Registra't</h2>
          <div class="mt-4 space-y-4">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
              <input
                id="name"
                name="name"
                type="text"
                v-model="registerData.username"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              />
            </div>
            <div>
              <label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
              <input
                id="lastname"
                name="lastname"
                type="text"
                v-model="registerData.lastname"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              />
            </div>
            <div class="flex space-x-4">
              <div class="flex-none">
                <label for="type_document" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                <select
                  id="type_document"
                  name="type_document"
                  v-model="registerData.type_document"
                  required
                  class="mt-1 block px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <option value="" disabled selected></option>
                  <option value="DNI">DNI</option>
                  <option value="NIE">NIE</option>
                  <option value="Passport">Pasaporte</option>
                </select>
              </div>
              <div class="flex-grow">
                <label for="id_document" class="block text-sm font-medium text-gray-700">ID del Documento</label>
                <input
                  id="id_document"
                  name="id_document"
                  type="text"
                  v-model="registerData.id_document"
                  required
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
              </div>
            </div>
            <div>
              <label for="birthdate" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
              <input
                id="birthdate"
                name="birthdate"
                type="date"
                v-model="registerData.birthdate"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              />
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
              <input
                id="email"
                name="email"
                type="email"
                v-model="registerData.email"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              />
            </div>
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
              <input
                id="password"
                name="password"
                type="password"
                v-model="registerData.password"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              />
            </div>
            <div>
              <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
              <input
                id="confirm_password"
                name="confirm_password"
                type="password"
                v-model="registerData.confirmPassword"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              />
            </div>
          </div>
          <div v-if="registerError" class="mt-2 text-red-500 text-sm">{{ registerError }}</div>
          <div class="mt-4">
            <button
              type="submit"
              @click="register"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Registra't
            </button>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import { register, login } from '@/services/communicationManager';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';

export default {
  name: "LoginPage",
  data() {
    return {
      animateImage: false,  
      showText: true,      
      loginData: {
        email: '',
        password: '',
        rememberMe: false
      },
      registerData: {
        username: '',
        lastname: '',
        type_document: '',
        id_document: '',
        birthdate: '',
        email: '',
        password: '',
        confirmPassword: ''
      },
      registerError: '',
      loginError: ''
    };
  },
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();

    if (authStore.isAuthenticated) {
      router.push('/');
    }

    return { router, authStore };
  },
  methods: {
    triggerRegister() {
      this.animateImage = !this.animateImage;  
    },
    async register() {
      if (this.registerData.password !== this.registerData.confirmPassword) {
        this.registerError = "Las contraseñas no coinciden";
        return;
      }
      await register(this.registerData)
        .then(response => {
          this.authStore.login(response.user, response.token)
          alert('Registrado Correctamente');
          this.router.push('/'); 
        })
        .catch(error => {
          this.registerError = "Error en el registro";
          console.error("Error en el registro", error);
        });
    },
    async login() {
      await login(this.loginData)
        .then(response => {
          alert('Login Correctamente');
          this.authStore.login(response.user, response.token);  // Llamar al método login de authStore
          if (this.loginData.rememberMe) {
            sessionStorage.setItem('token', response.token); // Guardar el token en sessionStorage
            sessionStorage.setItem('user', JSON.stringify(response.user)); // Guardar los datos del usuario en sessionStorage
          }
          this.router.push('/');  // Redirigir a la ruta home
          console.log("Login exitoso", response);
        })
        .catch(error => {
          this.loginError = "Error en el login";
          console.error("Error en el login", error);
        });
    }
  }
};
</script>

<style scoped>
.transition-transform {
  transition: transform 0.7s ease-out;
}
</style>

