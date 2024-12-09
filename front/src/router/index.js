import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: () => import ('@/views/HomeView.vue'),
      // meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path:'/login',
      name: 'login',
      component: () => import ('@/views/LoginView.vue'),
    },
    {
      path:'/wizard',
      name: 'wizard',
      component: () => import ('@/views/WizardView.vue'),
    },
    {
      path: '/assign',
      name: 'assign',
      component: () => import ('@/views/AssignSiteView.vue'),
    },
    {
      path: '/test',
      name: 'test',
      component: () => import ('@/views/PageTest.vue'),
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: () => import ('@/views/errors/View404.vue'),
    },
    {
      path: "/students",
      name: "students",
      component: () => import ('@/views/StudentsView.vue'),
    },
    {
      path: "/students/:id",
      name: "student",
      component: () => import ('@/views/StudentView.vue'),
    }
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
