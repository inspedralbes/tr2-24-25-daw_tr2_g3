import { createRouter, createWebHistory } from 'vue-router'
import {useAuthStore} from "@/stores/authStore.js";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: () => import ('@/views/HomeView.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
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
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: '/test',
      name: 'test',
      component: () => import ('@/views/PageTest.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import ('@/views/ProfileView.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: '/classes',
      name: 'classes',
      component: () => import('@/views/ClassesView.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: '/messages',
      name: 'mensajes',
      component: ()=> import('@/views/MessagesView.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: '/sidebartest',
      name: 'testsidebar',
      component: ()=>import ('@/components/Sidebar/Sidebartest.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
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
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: "/forms",
      name: "forms",
      component: ()=>import('@/views/FormView.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: "/students/",
      name: "students",
      component: () => import ('@/views/StudentsView.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: "/student/",
      name: "student",
      component: () => import ('@/views/StudentView.vue'),
      meta: { requiresAuth: true }, // Requiere autenticación
    },
    {
      path: '/login/callback',
      component: () => import('@/views/CallbackView.vue'),
    },
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
