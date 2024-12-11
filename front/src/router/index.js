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
      path: '/profile',
      name: 'profile',
      component: () => import ('@/views/ProfileView.vue')
    },
    {
      path: '/classes',
      name: 'classes',
      component: () => import('@/views/ClassesView.vue')
    },
    {
      path: '/messages',
      name: 'mensajes',
      component: ()=> import('@/views/MessagesView.vue')
    },
    {
      path: '/sidebartest',
      name: 'testsidebar',
      component: ()=>import ('@/components/Sidebar/Sidebar.vue')
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: () => import ('@/views/errors/View404.vue'),
    },
    {
      path:'/class/:tab?',
      name: 'class',
      component: ()=>import('@/views/ClassView.vue'),
      props: route => ({ initialTab: route.params.tab || 'sociogram' }),
    },
    {
      path: "/forms",
      name: "forms",
      component: ()=>import('@/views/FormView.vue'),
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
