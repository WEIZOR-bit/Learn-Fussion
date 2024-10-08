import { createRouter, createWebHashHistory } from "vue-router";
import Dashboard from "@/views/Dashboard.vue";
import Courses from "@/views/Courses.vue";
import Billing from "@/views/Users.vue";
import VirtualReality from "@/views/VirtualReality.vue";
import Profile from "@/views/Profile.vue";
import Rtl from "@/views/Rtl.vue";
import SignIn from "@/views/SignIn.vue";
import AddCourseComponent from "@/views/components/AddCourseComponent.vue";
import Users from "@/views/Users.vue";
import CourseDetails from "@/views/components/CourseDetails.vue";
import EditCourse from "@/views/components/EditCourse.vue";
import DeleteCourse from "@/views/components/DeleteCourse.vue";
import { useAuthStore } from "@/store/auth";
import AddUserComponent from "@/views/components/AddUserComponent.vue";

const routes = [
  {
    path: "/",
    name: "/",
    redirect: "/dashboard",
    meta: { requiresAuth: true },
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true },
  },
  {
    path: "/courses",
    name: "Courses",
    component: Courses,
    meta: { requiresAuth: true },
  },
  {
    path: '/courses/add',
    name: 'Add Course',
    component: AddCourseComponent,
    meta: { requiresAuth: true },
  },

  {
    path: '/courses/:id',
    name: 'CourseDetails',
    component: CourseDetails,
    meta: { requiresAuth: true },
  },
  {
    path: '/courses/:id/edit',
    name: 'EditCourse',
    component: EditCourse,
    meta: { requiresAuth: true },
  },
  {
    path: '/courses/:id/delete',
    name: 'DeleteCourse',
    component: DeleteCourse,
    meta: { requiresAuth: true },
  },
  {
    path: "/users",
    name: "Users",
    component: Users,
    meta: { requiresAuth: true },
  },
  {
    path: '/users/add',
    name: 'Add User',
    component: AddUserComponent,
    meta: { requiresAuth: true },
  },

  {
    path: "/virtual-reality",
    name: "Virtual Reality",
    component: VirtualReality,
    meta: { requiresAuth: true },
  },
  {
    path: "/profile",
    name: "Profile",
    component: Profile,
    meta: { requiresAuth: true },
  },
  {
    path: "/rtl-page",
    name: "Rtl",
    component: Rtl,
    meta: { requiresAuth: true },
  },
  {
    path: "/sign-in",
    name: "Sign In",
    component: SignIn,

  },
];

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes,
  linkActiveClass: "active",
});

// Глобальный гвард для проверки аутентификации
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore(); // Получаем экземпляр хранилища

  // Проверяем, требует ли маршрут авторизации
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    // Проверяем, аутентифицирован ли пользователь
    const isAuthenticated = authStore.isAuthenticated; // Используем состояние из Pinia

    if (!isAuthenticated) {
      // Если не аутентифицирован, перенаправляем на страницу входа
      next({ name: "Sign In" });
    } else {
      // Если аутентифицирован, продолжаем навигацию
      next();
    }
  } else {
    // Если маршрут не требует авторизации, продолжаем навигацию
    next();
  }
});

export default router;

