<template>
  <div class="py-4 container-fluid">
    <div class="card mb-4">
      <div class="card-header">
        <h6>Add New Course</h6>
      </div>
      <div class="card-body pb-2">
        <form @submit.prevent="submitForm">
          <!-- Course Title -->
          <div class="mb-3">
            <label for="title" class="form-label">Course Name</label>
            <input
              v-model="course.name"
              type="text"
              class="form-control"
              id="title"
              placeholder="Enter course title"
              required
            />
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select v-model="course.category_id" id="category" class="form-control" required>
              <option disabled value="">Select a category</option>
              <option v-for="category in categories.category" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>

          <!-- Course Description -->
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea
              v-model="course.description"
              class="form-control"
              id="description"
              rows="3"
              placeholder="Enter course description"
            ></textarea>
          </div>

          <!-- Average Rating -->
          <div class="mb-3">
            <label for="average-rating" class="form-label">Average Rating</label>
            <input
              v-model="course.average_rating"
              type="number"
              class="form-control"
              id="average-rating"
              placeholder="Enter average rating (0 to 5)"
              min="0"
              max="5"
              step="0.1"
              required
            />
          </div>

          <!-- Submit Course -->
          <button @click="submitCourse" type="submit" class="btn btn-success mt-4">Submit Course</button>
        </form>
      </div>
    </div>

  </div>
</template>

<script>

import {useCoursesStore} from "@/store/coursesStore.js";
import { useAuthStore } from '@/store/auth.js';
import {computed} from "vue";
import router from "@/router/index.js";

export default {
  data() {
    return {
      showLessonModal: false,
      user: computed(() => useAuthStore().user),
      course: {
        name: '',
        category_id: '',
        created_by: '',
        updated_by: '',
        description: '',
        average_rating: null,
      },
      categories: [],

      newLesson: {
        title: '',
        description: '',
        tutorial_link: '',
        average_rating: null,
        task: ''
      },
    };
  },

  mounted() {
    const coursesStore = useCoursesStore();
    coursesStore.getCategories().then(() => {
      this.categories = coursesStore.categories;
      console.log('categories', coursesStore.categories);
    });
    useAuthStore().loadUserFromStorage();
  },
  methods: {
    async submitCourse() {
      console.log('Попытка добавить курс с данными:', this.course)
      this.course.created_by = this.user.id;
      this.course.updated_by = this.user.id;
      await useCoursesStore().addCourse(this.course);
      await router.push({ name: 'Courses' });
    },
  },
};
</script>

<style scoped>
.card {
  border-radius: 0.5rem;
  box-shadow: 0 0 2rem 0 rgba(136, 152, 170, 0.15);
}

.form-label {
  font-weight: 500;
  color: #344767;
}

.btn-primary {
  background-color: #cb0c9f;
  border-color: #cb0c9f;
}

.btn-primary:hover {
  background-color: #9c0a75;
  border-color: #9c0a75;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 20000;
}

  .modal {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 20001;
    transform: translate(-50%, -50%);
    left: 50%;
    top: 50%;
  }

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}
</style>
