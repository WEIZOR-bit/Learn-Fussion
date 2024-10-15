<template>
  <div class="container-fluid">
    <div
      class="mt-4 page-header min-height-300 border-radius-xl"
    >
      <span class="mask bg-gradient-success opacity-6"></span>
    </div>
    <div class="mx-4 overflow-hidden card card-body blur shadow-blur mt-n6">
      <div class="row gx-4">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img
              src="../assets/img/bruce-mars.jpg"
              alt="profile_image"
              class="shadow-sm w-100 border-radius-lg"
            />
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">{{ user ? user.name : 'Loading...' }}</h5>
            <p class="mb-0 text-sm font-weight-bold">email: {{ user ? user.email : 'Loading...' }}</p>
          </div>
        </div>
        <div
          class="mx-auto mt-3 col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0"
        >
          <div class="nav-wrapper position-relative end-0">
            <button type="button" class="btn btn-success" @click="logout">Logout</button>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="mt-4 row">
      <div class="col-12">
        <div class="mb-4 card">
          <div class="p-3 pb-0 card-header">
            <h6 class="mb-1">Courses</h6>
          </div>
          <div class="p-3 card-body">
            <div class="row">


                <div v-for="(course, index) in courses" :key="index" class="mb-4 col-xl-3 col-md-6 mb-xl-0">
                  <projects-card
                     :description="course.description"
                     :title="course.name"
                     :img="asdadasda"/>

                  <button class="btn  btn-sm btn-success" @click="viewDetails(course.id)">
                    View Details
                  </button>
              </div>


              <div class="mb-4 col-xl-3 col-md-6 mb-xl-0">
                <div class="border card h-100 card-plain">
                  <div
                    class="text-center card-body d-flex flex-column justify-content-center"
                  >
                    <a href="javascript:;">
                      <i class="mb-3 fa fa-plus text-secondary"></i>
                      <h5 class="text-secondary">New project</h5>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import VsudSwitch from "@/components/VsudSwitch.vue";
import ProfileCard from "./components/ProfileCard.vue";
import VsudAvatar from "../components/VsudAvatar.vue";
import bgImg from "@/assets/img/curved-images/curved14.jpg"
import ProjectsCard from "./components/ProjectsCard.vue";
import { useAuthStore } from '@/store/auth.js';

import setNavPills from "@/assets/js/nav-pills.js";
import setTooltip from "@/assets/js/tooltip.js";
import VsudButton from "@/components/VsudButton.vue";
import {computed, ref} from "vue";
import router from "@/router/index.js";
import {useCoursesStore} from "@/store/coursesStore.js";

export default {
  name: "ProfileOverview",
  components: {
    VsudButton,
    VsudSwitch,
    ProfileCard,
    VsudAvatar,
    ProjectsCard,
  },
  data() {
    return {
      showMenu: false,
      bgImg,
      user: computed(() => useAuthStore().user),
      isLoading: ref(false),
      courses: computed(() => useCoursesStore().courses),

    };
  },

  setup() {
    const coursesStore = useCoursesStore();
    return { coursesStore };
  },

  async mounted() {
    this.$store.state.isAbsolute = true;
    this.$store.state.isNavFixed = false;
    setNavPills();
    setTooltip();
    useAuthStore().loadUserFromStorage();
    await this.fetchCourses();
  },
  beforeUnmount() {
    this.$store.state.isAbsolute = false;
  },

  methods: {
    logout() {
     useAuthStore().logout();
      router.push({name: 'Sign In'});
      console.log('Logging out');
    },

    async fetchCourses() {
      this.isLoading = true;
      try {
        await this.coursesStore.fetchCourses();
        console.log("Courses loaded:", this.courses);
      } catch (err) {
        console.error(err);
      } finally {
        this.isLoading = false;
      }
    },

    viewDetails(id) {
      router.push({ name: "Course Details", params: { id } });
    }
  }
};
</script>
