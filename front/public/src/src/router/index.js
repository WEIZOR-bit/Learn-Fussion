import { createRouter, createWebHistory } from 'vue-router'
import ProfileView from "@/views/ProfileView.vue";
import LoginView from "@/views/auth/LoginView.vue";
import SignupView from "@/views/auth/SignupView.vue";
import PasswordResetView from "@/views/auth/PasswordResetView.vue";
import HomeView from "@/views/HomeView.vue";
import AboutView from "@/views/AboutView.vue";
import CoursesView from "@/views/CoursesView.vue";
import RatingView from "@/views/RatingView.vue";
import ChallengesView from "@/views/ChallengesView.vue";
import ForumView from "@/views/ForumView.vue";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      component: AboutView
    },
    {
      path: '/profile',
      name: 'profile',
      component: ProfileView
    },
    {
      path: '/courses',
      name: 'courses',
      component: CoursesView
    },
    {
      path: '/rating',
      name: 'rating',
      component: RatingView
    },
    {
      path: '/challenges',
      name: 'challenges',
      component: ChallengesView
    },
    {
      path: '/forum',
      name: 'forum',
      component: ForumView
    },
    {
      path: '/verify-email',
      name: 'EmailVerify',
      component: () => import('@/components/EmailVerify.vue'),
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
      path: '/signup',
      name: 'signup',
      component: SignupView
    },
    {
      path: '/password-reset',
      name: 'password-reset',
      component: PasswordResetView
    },
  ]
})

export default router
