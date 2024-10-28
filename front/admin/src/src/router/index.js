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
import AddLessonComponent from "@/views/components/AddLessonComponent.vue";
import LessonDetails from "@/views/components/LessonDetails.vue";

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
    name: 'Course Details',
    component: CourseDetails,
    meta: { requiresAuth: true },
  },

  {
    path: '/lesson/:lessonId',
    name: 'Lesson Details',
    component: LessonDetails,
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
    path: '/courses/:id/lesson/add',
    name: 'Add Lesson',
    component: AddLessonComponent,
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


router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();


  if (to.matched.some((record) => record.meta.requiresAuth)) {

    const isAuthenticated = authStore.isAuthenticated;

    if (!isAuthenticated) {
      next({ name: "Sign In" });
    } else {
      next();
    }
  } else if (to.path === '/') {
    next({ path: '/admin/sign-in' });
  } else {
    next();
  }
});

export default router;

