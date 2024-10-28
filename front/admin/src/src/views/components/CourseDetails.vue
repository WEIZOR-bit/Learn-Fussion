<template>
  <div class="course-page">
    <LoaderComponent v-if="isLoading" />
    <div v-else class="course-details">
      <!-- Course Cover Section -->
      <div class="course-cover">
        <img
            :src="course.cover_url || 'empty_image.png'"
            alt="Course cover"
            class="cover-image"
            @click="course.cover_url ? openModal() : openFileModal()"
        />
      </div>

      <div class="course-header">
        <card-component :title="course.name" class="course-title"></card-component>
        <card-component :title="course.description" class="course-description"></card-component>
      </div>

      <div class="info-cards">
        <card-component :title="'Review count: ' + reviewCount" class="info-card"></card-component>
        <card-component :title="'Average rating: ' + course.average_rating" class="info-card"></card-component>
        <card-component :title="'Published: ' + course.published" class="info-card"></card-component>
        <card-component :title="'Created by: ' + course.creator?.name" class="info-card"></card-component>
      </div>

      <div class="lesson-list">
        <div
            v-for="(lesson, index) in course.lessons"
            :key="index"
            class="lesson-card"
            @click="goToLessonDetails(lesson.id)"
        >
        <card-component
            :title="'Lesson ' + (index + 1) + ': ' + lesson.name"
        ></card-component>
      </div>
    </div>

    <div class="nav-buttons">
      <button type="button" @click="goToAddLesson" class="btn btn-success">Add lesson</button>
      <button type="button" @click="goToCourses" class="btn btn-outline-dark">Back</button>
      <button v-if="!published" type="button" @click="publish" class="btn btn-danger">Publish</button>
    </div>

    <!-- Modal for Cover Image -->
    <div v-if="isModalOpen" class="modal cover-modal" @click="closeModal">
      <div class="modal-content" @click.stop>
        <span class="close" @click="closeModal">&times;</span>
        <div class="modal-image-container">
          <img :src="course.cover_url" alt="Course cover" class="modal-image" />
        </div>
        <div class="modal-buttons">
          <button @click="openFileModal" class="btn btn-warning">Change cover</button>
          <button @click="removeCover(course.id)" class="btn btn-danger">Delete cover</button>
        </div>
      </div>
    </div>

    <!-- Modal for File Upload -->
    <div v-if="isFileModalOpen" class="modal file-modal" @click="closeFileModal">
      <div class="file-modal-content" @click.stop>
        <span class="close" @click="closeFileModal">&times;</span>
        <h2 class="modal-title">Загрузка новой обложки</h2>
        <input type="file" @change="handleFileChange" class="form-control file-input" />
        <button @click="uploadCover" class="btn btn-success upload-button">Загрузить</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script setup>
import { useCoursesStore } from '@/store/coursesStore';
import { onMounted, computed, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import CardComponent from "@/examples/Cards/Card.vue";
import LoaderComponent from "@/views/components/LoaderComponent.vue";

const courseStore = useCoursesStore();
const router = useRouter();
const route = useRoute();
const isLoading = computed(() => courseStore.isLoading);

const course = computed(() => courseStore.course);
const reviewCount = computed(() => course.value.review_count ?? 0);
const published = computed(() => course.value.published);

const isModalOpen = ref(false);
const isFileModalOpen = ref(false);  // Управление вторым модальным окном
const selectedFile = ref(null);

onMounted(() => {
  const courseId = route.params.id;
  courseStore.fetchCourseById(courseId);
});

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  closeFileModal(); // Закрыть также модальное окно загрузки файла
};

const openFileModal = () => {
  isFileModalOpen.value = true;
};

const closeFileModal = () => {
  isFileModalOpen.value = false;
};

const goToAddLesson = () => {
  router.push({ name: 'Add Lesson', params: { id: route.params.id } });
};

const goToCourses = async () => {
  await router.back();
};

const goToLessonDetails = (lessonId) => {
  router.push({ name: 'Lesson Details', params: { lessonId } });
};

const publish = async () => {
  await courseStore.publishCourse(route.params.id);
  await courseStore.fetchCourseById(route.params.id);
};

// Обработка выбора файла
const handleFileChange = (event) => {
  selectedFile.value = event.target.files[0]; // Сохраняем выбранный файл
};

// Метод для загрузки новой обложки
const uploadCover = async () => {
  if (!selectedFile.value) {
    alert("Пожалуйста, выберите файл для загрузки.");
    return;
  }

  const formData = new FormData();
  formData.append('cover_url', selectedFile.value);

  // Добавляем остальные данные курса, исключая поле 'cover_url'
  Object.entries(course.value).forEach(([key, value]) => {
    if (key !== 'cover_url' && typeof value !== 'object' && value !== null) {
      formData.append(key, value);
    }
  });

  console.log('Содержимое FormData:');
  formData.forEach((value, key) => {
    console.log(`${key}:`, value);
  });

  try {
    await courseStore.updateCourse(route.params.id, formData);
    await courseStore.fetchCourseById(route.params.id);
    closeFileModal();
    closeModal();

  } catch (error) {
    console.error("Ошибка при обновлении обложки:", error);
  }
};

// Обработка удаления обложки
const removeCover = async (id) => {
  await courseStore.deleteCover(id);
  await courseStore.fetchCourseById(route.params.id);
  closeFileModal();
  closeModal();
};
</script>

<style scoped>
.course-page {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  background-color: #f4f5f7;
}

.course-details {
  background: #ffffff;
  padding: 30px;
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  width: 100%;
}

.course-cover {
  margin-bottom: 30px;
}

.cover-image {
  width: 100%;
  height: auto;
  max-height: 400px;
  object-fit: cover;
  border-radius: 20px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.course-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 40px;
}

.course-title, .course-description {
  width: 100%;
  padding: 20px;
  background-color: #f7f9fc;
  border-radius: 10px;
  margin-bottom: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  font-weight: bold;
  text-align: center;
  font-size: 1.5rem;
}

.info-cards {
  display: flex;
  gap: 20px;
  justify-content: space-between;
  margin-bottom: 40px;
}

.info-card {
  flex: 1;
  padding: 20px;
  background-color: #eff4fa;
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  text-align: center;
  font-size: 1rem;
  color: #4a4a4a;
}

.lesson-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.lesson-card {
  flex: 1 1 calc(33% - 20px);
  padding: 15px;
  background-color: #edf7f2;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  text-align: center;
  transition: transform 0.3s ease;
}

.lesson-card:hover {
  transform: translateY(-5px);
}

.nav-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 40px;
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

.btn-danger {
  background-color: #f56565;
  color: #fff;
  border: none;
}

.btn-danger:hover {
  background-color: #e05353;
}

.btn-outline-dark {
  border: 2px solid #62d8a3;
  color: #62d8a3;
}

.btn-outline-dark:hover {
  background-color: #62d8a3;
  color: white;
}

/* Modal Styles */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 10px;
  padding: 20px;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}

.modal-image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  max-width: 800px;
}

.modal-image {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}

/* File Modal Styles */
.file-modal {
  z-index: 2000;
}

/* Media Queries */
@media (max-width: 768px) {
  .info-cards, .lesson-list {
    flex-direction: column;
  }

  .lesson-card {
    flex: 1 1 100%;
  }

  .modal-buttons {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
  }

  .btn-warning {
    background-color: #f6c23e;
    color: #fff;
    border: none;
  }

  .btn-warning:hover {
    background-color: #e0a800;
  }

  .file-modal {
    z-index: 2000;
    background-color: rgba(0, 0, 0, 0.8); /* Затемнённый фон */
    display: flex;
    justify-content: center;
    align-items: center;
  }


}
.file-modal-content {
  background: #ffffff;
  border-radius: 10px;
  padding: 20px;
  position: relative;
  display: flex;
  flex-direction: column; /* Вертикальное выравнивание элементов */
  align-items: center; /* Центрирование по горизонтали */
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  max-width: 400px; /* Ограничиваем ширину модального окна */
  width: 100%; /* Полная ширина для маленьких экранов */
}

.modal-title {
  margin-bottom: 20px; /* Отступ снизу заголовка */
  font-size: 1.5rem; /* Размер шрифта заголовка */
  text-align: center; /* Центрирование заголовка */
  color: #4a4a4a; /* Цвет текста заголовка */
}

.file-input {
  margin-bottom: 20px; /* Отступ снизу для поля выбора файла */
}

.upload-button {
  display: block; /* Отображение кнопки как блок */
  width: 100%; /* Кнопка занимает всю ширину */
  text-align: center; /* Центрирование текста на кнопке */
}
</style>
