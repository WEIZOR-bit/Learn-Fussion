import { createRouter, createWebHistory } from 'vue-router'
import ProfileView from "@/views/ProfileView.vue";
import LoginView from "@/views/auth/LoginView.vue";
import RegisterView from "@/views/auth/RegisterView.vue";
import PasswordResetView from "@/views/auth/PasswordResetView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/profile',
      name: 'profile',
      component: ProfileView
    },
    {
      path: '/verify-email',
      name: 'EmailVerify',
      component: () => import('@/components/EmailVerify.vue'), // Загружаем компонент для верификации
      props: route => ({
        id: route.query.id,
        expires: route.query.expires,
        signature: route.query.signature,
      })
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/password-reset',
      name: 'password-reset',
      component: PasswordResetView
    },
  ]
})

export default router
