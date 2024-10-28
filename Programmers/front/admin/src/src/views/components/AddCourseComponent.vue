<template>
  <div class="add-course-page py-4 container-fluid">
    <div class="card mb-4 full-width">
      <div class="card-header">
        <h6>Добавить новый курс</h6>
      </div>
      <div class="card-body pb-2">
        <form @submit.prevent="submitCourse">
          <!-- Course Title -->
          <div class="mb-3">
            <label for="title" class="form-label">Название курса</label>
            <input
                v-model="course.name"
                type="text"
                class="form-control"
                id="title"
                placeholder="Введите название курса"
                required
            />
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Категория</label>
            <select v-model="course.category_id" id="category" class="form-control" required>
              <option disabled value="">Выберите категорию</option>
              <option v-for="category in categories.category" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>

          <!-- Course Description -->
          <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea
                v-model="course.description"
                class="form-control"
                id="description"
                rows="5"
                placeholder="Введите описание курса"
                style="resize: vertical;"
            ></textarea>
          </div>

          <!-- Average Rating -->
          <div class="mb-3">
            <label for="average-rating" class="form-label">Средний рейтинг</label>
            <input
                v-model="course.average_rating"
                type="number"
                class="form-control"
                id="average-rating"
                placeholder="Введите средний рейтинг (0 до 5)"
                min="0"
                max="5"
                step="0.1"
                required
            />
          </div>

          <!-- Submit Course -->
          <div class="nav-buttons">
            <button type="submit" class="btn btn-success mt-4">Добавить курс</button>
            <button type="button" @click="back" class="btn btn-outline-dark mt-4">Назад</button>
          </div>
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

    back() {
      router.back();
    }
  },
};
</script>

<style scoped>
.add-course-page {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  background-color: #f4f5f7;
}

.card {
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  width: 100%; /* Установите ширину карточки на 100% */
  max-width: 600px; /* Максимальная ширина карточки */
  padding: 20px; /* Добавьте внутренние отступы */
}

.form-label {
  font-weight: 500;
  color: #344767;
}

.btn {
  padding: 12px 24px;
  border-radius: 30px;
  font-size: 0.9rem;
  font-weight: bold;
  text-transform: uppercase;
  transition: background-color 0.3s ease;
}

.btn-success {
  background-color: #62d8a3;
  color: #fff;
  border: none;
}

.btn-success:hover {
  background-color: #4ec38b;
}

.btn-outline-dark {
  border: 2px solid #62d8a3;
  color: #62d8a3;
}

.btn-outline-dark:hover {
  background-color: #62d8a3;
  color: white;
}

.nav-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 40px;
}
</style>
