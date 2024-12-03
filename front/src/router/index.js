import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/authStore';
import HomeView from '../views/HomeView.vue'
import LoginView from "@/views/LoginView.vue";
import LayoutMain from "@/layout/LayoutMain.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: LayoutMain,
      children: [
        {
          path: '',
          name: 'home',
          component: HomeView,
          // meta: { requiresAuth: true }, // Requiere autenticación
        },
      ],
    },
    {
      path:'/login',
      name: 'login',
      component: LoginView,
    }
  ],
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore(); // Obtén el estado de autenticación

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    // Redirige a /auth si intenta acceder a una ruta protegida
    next({ name: 'login' });
  } else {
    next(); // Permite la navegación
  }
});
export default router
