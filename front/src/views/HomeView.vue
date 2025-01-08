<script setup>
import useHome from "@/composable/useHome.js";
import LayoutMain from "@/layout/LayoutMain.vue"; // Importamos el layout

const home = useHome();
</script>

<template>
  <LayoutMain>
    <template #title>
      <i class="bi bi-shield-fill"></i>
      Syncblend
    </template>

    <template #icon>
    </template>

    <div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl md:text-6xl">
            Creando entornos escolares
            <span class="text-primary"> 
              más seguros y saludables
            </span>
          </h1>
          <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
            Plataforma integral para la gestión y análisis del comportamiento estudiantil, facilitando la creación de grupos armoniosos y previniendo situaciones de acoso escolar.
          </p>
        </div>
        <div class="mt-24 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
          <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow border-2 border-gray-200">
            <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center text-primary mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-school ">
                <path d="M14 22v-4a2 2 0 1 0-4 0v4"></path><path d="m18 10 4 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8l4-2"></path><path d="M18 5v17"></path><path d="m4 6 8-4 8 4"></path><path d="M6 5v17"></path><circle cx="12" cy="9" r="2"></circle>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
              Gestión de Clases
            </h3>
            <p class="text-gray-600">
              Organiza y supervisa múltiples clases, manteniendo un seguimiento detallado de cada grupo.
            </p>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow border-2 border-gray-200">
            <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center text-primary mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users ">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
              Perfil de Alumnos
            </h3>
            <p class="text-gray-600">
              Visualiza perfiles detallados de estudiantes, incluyendo su comportamiento y desarrollo social.
            </p>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow border-2 border-gray-200">
            <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center text-primary mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list "><rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M12 11h4"></path><path d="M12 16h4"></path><path d="M8 11h.01"></path><path d="M8 16h.01"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
              Formularios Dinámicos
            </h3>
            <p class="text-gray-600">Crea y gestiona formularios personalizados para evaluar el ambiente escolar.</p>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow border-2 border-gray-200">
            <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center text-primary mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square "><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
              Chat Interno
            </h3>
            <p class="text-gray-600">
              Comunicación segura entre profesores y personal educativo para una mejor coordinación.
            </p>
          </div>
        </div>
        <div class="mt-32">
          <h2 class="text-3xl font-bold text-center text-gray-900 mb-16">
            Beneficios de nuestra plataforma
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
              <div class="w-12 h-12 mx-auto bg-gray-500 rounded-full flex items-center justify-center text-primary mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bar-chart3 "><path d="M3 3v18h18"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">
                Análisis Detallado
              </h3>
              <p class="text-gray-600">
                Obtén insights valiosos sobre las dinámicas sociales en el aula.
              </p>
            </div>
            <div class="text-center p-6">
              <div class="w-12 h-12 mx-auto bg-gray-500 rounded-full flex items-center justify-center text-primary mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus "><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" x2="19" y1="8" y2="14"></line><line x1="22" x2="16" y1="11" y2="11"></line>
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">
                Grupos Equilibrados
              </h3>
              <p class="text-gray-600">
                Crea grupos de trabajo efectivos basados en perfiles de comportamiento.
              </p>
            </div>
            <div class="text-center p-6">
              <div class="w-12 h-12 mx-auto bg-gray-500 rounded-full flex items-center justify-center text-primary mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-handshake "><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path><path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08v0c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66"></path><path d="m18 15-2-2"></path><path d="m15 18-2-2"></path>
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">
                Prevención Activa
              </h3>
              <p class="text-gray-600">
                Identifica y previene situaciones de conflicto antes de que escalen.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <template #footer>
      <div class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
              <div class="flex items-center space-x-2 mb-4">
                <i class="bi bi-shield-fill"></i>
                <h5 class="text-white font-semibold">SyncBlend</h5>
              </div>
              <p class="text-sm">
                Creando entornos educativos seguros y positivos con tecnología innovadora para prevenir y gestionar el comportamiento estudiantil.
              </p>
            </div>
            <div>
              <h5 class="text-white font-semibold mb-4">
                Legal
              </h5>
              <ul class="space-y-2">
                <li>
                  <a href="#" class="hover:text-blue-400">
                    Política de Privacidad
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-blue-400">
                    Términos de Uso
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-blue-400">
                    Aviso Legal
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-blue-400">
                    Cookies
                  </a>
                </li>
              </ul>
            </div>
            <div>
              <h5 class="text-white font-semibold mb-4">
                Contacto
              </h5>
              <ul class="space-y-2">  
                <li class="flex items-center space-x-2">
                  <i class="bi bi-envelope-fill"></i>
                  <span>
                    info@syncblend.com
                  </span>
                </li>
                <li class="flex items-center space-x-2">
                  <i class="bi bi-telephone-fill"></i>
                  <span>+34 900 123 456</span>
                </li>
                <li class="flex items-center space-x-2">
                  <i class="bi bi-geo-alt-fill"></i>
                  <span>Barcelona, España</span>
                </li>
                <li class="flex items-center space-x-2">
                  <i class="bi bi-building-fill"></i>
                  <span>Calle Falsa, 123</span>
                </li>
              </ul>
            </div>
            <div>
              <h5 class="text-white font-semibold mb-4">
                Síguenos
              </h5>
              <div class="flex space-x-4">
                <a href="#" class="hover:text-blue-400">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook h-6 w-6"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                  </svg>
                </a>
                <a href="#" class="hover:text-blue-400">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter h-6 w-6"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                  </svg>
                </a>
                <a href="#" class="hover:text-blue-400">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-linkedin h-6 w-6"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle>
                  </svg>
                </a>
              </div>
            </div>
          </div>
          <div class="border-t border-gray-400 mt-8 pt-8 text-sm text-center">
            <p>© 2025 EduSafe. Todos los derechos reservados.</p>
          </div>
        </div>
      </div>
    </template>

<!--    <div>-->
<!--    -->
<!--    </div>-->
  </LayoutMain>
</template>

<style scoped>
  
</style>


