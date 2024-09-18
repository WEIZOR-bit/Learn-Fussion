import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/ProfileView.vue'
import ProfileView from "@/views/ProfileView.vue";

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
  ]
})

export default router
