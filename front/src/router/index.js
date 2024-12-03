import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/authStore';
import HomeView from '@/views/HomeView.vue'
import LoginView from "@/views/LoginView.vue";
import WizardView from "@/views/WizardView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      // meta: { requiresAuth: true }, // Indica que requiere autenticación
    },
    {
      path:'/login',
      name: 'login',
      component: LoginView,
    },
    {
      path:'/wizard',
      name: 'wizard',
      component: WizardView,
    },

  ],
})

// router.beforeEach((to, from, next) => {
//   const authStore = useAuthStore(); // Obtén el estado de autenticación
//
//   if (to.meta.requiresAuth && !authStore.isAuthenticated) {
//     // Redirige a /auth si intenta acceder a una ruta protegida
//     next({ name: 'login' });
//   } else {
//     next(); // Permite la navegación
//   }
// });
export default router
