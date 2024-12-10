import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/authStore';
import HomeView from '@/views/HomeView.vue'
import LoginView from "@/views/LoginView.vue";
import LayoutMain from "@/layout/LayoutMain.vue";
import WizardView from "@/views/WizardView.vue";
import AssignView from "@/views/AssignSiteView.vue";
import PageTest from "@/views/PageTest.vue";
import View404 from "@/views/errors/View404.vue";
import ProfileView from "@/views/ProfileView.vue";
import ClassesView from "@/views/ClassesView.vue";
import MessagesView from "@/views/MessagesView.vue";
import ClassView from "@/views/ClassView.vue";
import Sidebartest from "@/components/Sidebar/Sidebartest.vue";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: HomeView,
      // meta: { requiresAuth: true }, // Requiere autenticación
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
    {
      path: '/assign',
      name: 'assign',
      component: AssignView,
    },
    {
      path: '/test',
      name: 'test',
      component: PageTest
    },
    {
      path: '/profile',
      name: 'profile',
      component: ProfileView
    },
    {
      path: '/classes',
      name: 'classes',
      component: ClassesView
    },
    {
      path: '/messages',
      name: 'mensajes',
      component: MessagesView
    },
    {
      path: '/sidebartest',
      name: 'testsidebar',
      component: Sidebartest
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: View404,
    },
    {
      path:'/class/:tab?',
      name: 'class',
      component: ClassView,
      props: route => ({ initialTab: route.params.tab || 'sociogram' }),
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
