<template>
  <LoaderComponent v-if="isLoading" />
  <div v-else class="content">
  <div class="container-fluid">
    <div class="mt-4 page-header min-height-300 border-radius-xl">
      <span class="mask bg-gradient-success opacity-6"></span>
    </div>
    <div class="mx-4 overflow-hidden card card-body blur shadow-blur mt-n6">
      <div class="row gx-4 align-items-center">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img :src="user && user.avatar_url ? user.avatar_url : 'empty_avatar.png'" alt="User Avatar" />
          </div>
        </div>

        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">{{ user ? user.name : 'Loading...' }}</h5>
            <p class="mb-0 text-sm font-weight-bold">email: {{ user ? user.email : 'Loading...' }}</p>
          </div>
        </div>

        <div class="col-auto my-auto d-flex flex-column justify-content-end">
          <button type="button" class="btn btn-success m-4" @click="showUploadModal = true">Change avatar</button>
        </div>

        <div class="col-auto my-auto ms-auto d-flex flex-column justify-content-end">
          <button type="button" class="btn btn-success m-4" @click="logout">Logout</button>
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
              <div v-for="(course, index) in courses.data" :key="index" class="mb-4 col-xl-3 col-md-6 mb-xl-0">
                <projects-card
                    :description="course?.description"
                    :title="course?.name"
                    :img="course?.cover_url"
                    :id="course?.id"/>
              </div>

              <div class="mb-4 col-xl-3 col-md-6 mb-xl-0">
                <div
                    class="border card h-100 card-plain"
                    @click="navigateToNewProject"
                    style="cursor: pointer;"
                >
                <div class="text-center card-body d-flex flex-column justify-content-center">
                  <i class="mb-3 fa fa-plus text-secondary"></i>
                  <h5 class="text-secondary">New project</h5>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Avatar upload modal -->
    <div v-if="showUploadModal" class="modal-backdrop">
      <div class="modal-content rounded shadow-lg" style="width: 400px; margin: auto;">
        <h5 class="modal-title text-center" style="color: #28a745;">Upload New Avatar</h5>
        <form method="POST" enctype="multipart/form-data" class="p-3">
          <div class="mb-3">
            <input type="file" name="avatar" @change="onFileSelected" class="form-control" />
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-secondary" @click="showUploadModal = false">Cancel</button>
            <button type="button" class="btn btn-success" @click="uploadAvatar">Upload</button>
          </div>
        </form>
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
import LoaderComponent from "@/views/components/LoaderComponent.vue";


export default {
  name: "ProfileOverview",
  components: {
    LoaderComponent,
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
      showUploadModal: false,
      selectedFile: null,
    };
  },

  setup() {
    const user = computed(() => useAuthStore().user);
    const coursesStore = useCoursesStore();
    return { user, coursesStore };
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

    onFileSelected(event) {
      const files = event.target.files;
      console.log("Selected files:", files); // Это должно показать выбранные файлы
      this.selectedFile = files[0]; // Выбор первого файла
    },


    async uploadAvatar() {
      if (!this.selectedFile) {
        alert('Please select a file first.');
        return;
      }

      const formData = new FormData();
      formData.append('avatar', this.selectedFile);

      try {
        // Отправка файла на сервер
        const response = await useAuthStore().uploadAvatar(formData, this.user.id);
        await useAuthStore().loadUserFromStorage();
        this.showUploadModal = false;
      } catch (error) {
        console.error('Error uploading avatar:', error);
      }
    },

    navigateToNewProject() {
      router.push({ name: 'Add Course' });
    }

  }
};
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000; /* Убедись, что модальное окно над другими элементами */
}

.modal-content {
  background-color: white; /* Цвет фона для модального окна */
  border-radius: 8px; /* Закругленные углы */
  padding: 20px; /* Отступы внутри модального окна */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Тень для модального окна */
}

.btn-success {
  background-color: #28a745; /* Зеленый фон для кнопок */
  border-color: #28a745; /* Цвет границы кнопок */
}

.btn-outline-secondary {
  color: #28a745; /* Цвет текста для кнопки "Cancel" */
  border-color: #28a745; /* Цвет границы для кнопки "Cancel" */
}

.btn-outline-secondary:hover {
  background-color: #28a745; /* Цвет фона при наведении для кнопки "Cancel" */
  color: white; /* Цвет текста при наведении для кнопки "Cancel" */
}

.avatar img {
  width: 70px; /* Ширина аватарки */
  height: 70px; /* Высота аватарки */
  border-radius: 50%; /* Делаем изображение круглым */
  object-fit: cover; /* Обрезаем изображение по границам контейнера */
}

</style>
