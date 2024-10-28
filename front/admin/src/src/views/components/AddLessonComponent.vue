<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from "vue-router";
import { useAuthStore } from '@/store/auth.js';
import { useCoursesStore } from "@/store/coursesStore.js";
import router from "@/router/index.js";
import LoaderComponent from "@/views/components/LoaderComponent.vue";

const showQuestionModal = ref(false);
const showAnswerModal = ref(false);
const route = useRoute();
const authStore = useAuthStore();
const coursesStore = useCoursesStore();
const lessons = ref([]);

const lesson = ref({
  order: 1,
  name: '',
  tutorial_link: '',
  description: '',
  average_rating: '',
  review_count: 0,
  question_count: 0,
  created_by: null,
  updated_by: null,
  course_id: parseInt(route.params.id, 10),
  questions: [],
});

onMounted(() => {
  authStore.loadUserFromStorage();
  if (authStore.user) {
    lesson.value.created_by = authStore.user.id;
    lesson.value.updated_by = authStore.user.id;
  }
});

const newQuestion = ref({
  name: '',
  matter: 1,
  answers: [],
});

const newAnswer = ref({
  text: '',
  correct: false,
});

const openQuestionModal = () => {
  showQuestionModal.value = true;
  newQuestion.value = { name: '', matter: 1, answers: [] };
};

const addQuestion = () => {
  if (newQuestion.value.name) {
    // Вычисляем порядок, основываясь на текущем количестве вопросов
    newQuestion.value.order = lesson.value.questions.length + 1;

    lesson.value.questions.push({ ...newQuestion.value });
    lesson.value.question_count = lesson.value.questions.length;
    showQuestionModal.value = false;
  }
};

const openAnswerModal = () => {
  showAnswerModal.value = true;
  newAnswer.value = { text: '', correct: false };
};

const addAnswer = () => {
  if (newAnswer.value.text) {
    newQuestion.value.answers.push({ ...newAnswer.value });
    showAnswerModal.value = false;
  }
};

const addLesson = () => {
  const lessonToAdd = {
    ...lesson.value,
    questions: [...lesson.value.questions],
  };
  const id = parseInt(route.params.id, 10);
  lessons.value.push(lessonToAdd);
  console.log(lessons.value);
  coursesStore.addLesson({ lessons: lessons.value }, { id });
  router.push({ name: 'Course Details', params: { this: lesson.id } });
};
</script>

<template>
  <div>
    <LoaderComponent v-if="isLoading" />
    <div v-else class="add-lesson-page py-4 container-fluid">
      <div class="card mb-4">
        <div class="card-header">
          <h6>Добавить новый урок</h6>
        </div>
        <div class="card-body pb-2">
          <!-- Поля для добавления урока -->
          <div class="mb-3">
            <input v-model="lesson.name" class="form-control" placeholder="Название урока" />
          </div>
          <div class="mb-3">
            <input v-model="lesson.description" class="form-control" placeholder="Описание урока" />
          </div>
          <div class="mb-3">
            <input v-model="lesson.tutorial_link" class="form-control" placeholder="Ссылка на урок" />
          </div>
          <div class="mb-3">
            <input v-model="lesson.average_rating" class="form-control" placeholder="Средний рейтинг" type="number" />
          </div>

          <!-- Кнопка для добавления вопросов -->
          <button @click="openQuestionModal" class="btn btn-outline-success mb-3">Добавить вопросы</button>

          <!-- Список добавленных вопросов -->
          <div v-if="lesson.questions.length">
            <h5>Вопросы:</h5>
            <ul>
              <li v-for="(question, index) in lesson.questions" :key="index">
                {{ question.name }} (Сложность: {{ question.matter }})
                <ul>
                  <li v-for="(answer, answerIndex) in question.answers" :key="answerIndex">
                    {{ answer.text }} <span v-if="answer.correct">(Верно)</span>
                  </li>
                </ul>
              </li>
            </ul>
          </div>

          <!-- Кнопка завершения добавления урока -->
          <button @click="addLesson" class="btn btn-success mt-3">Завершить урок</button>

          <!-- Модальное окно для добавления вопросов -->
          <div v-if="showQuestionModal" class="modal-backdrop">
            <div class="modal-card">
              <h3>Добавить новый вопрос</h3>
              <div class="mb-3">
                <input v-model="newQuestion.name" class="form-control" placeholder="Текст вопроса" />
              </div>
              <div class="mb-3">
                <input v-model="newQuestion.matter" type="number" class="form-control" placeholder="Сложность вопроса" />
              </div>

              <!-- Кнопка для добавления ответов -->
              <button @click="openAnswerModal" class="btn btn-outline-success mb-3">Добавить ответы</button>

              <!-- Список добавленных ответов -->
              <div v-if="newQuestion.answers.length">
                <h5>Ответы:</h5>
                <ul>
                  <li v-for="(answer, index) in newQuestion.answers" :key="index">
                    {{ answer.text }} <span v-if="answer.correct">(Верно)</span>
                  </li>
                </ul>
              </div>

              <!-- Кнопка для добавления вопроса -->
              <button v-if="newQuestion.answers.some(answer => answer.correct)" @click="addQuestion" class="btn btn-success mt-3">Добавить вопрос</button>
              <button @click="showQuestionModal = false" class="btn btn-danger mt-3">Закрыть</button>
            </div>
          </div>

          <!-- Модальное окно для добавления ответов -->
          <div v-if="showAnswerModal" class="modal-backdrop">
            <div class="modal-card">
              <h3>Добавить новый ответ</h3>
              <div class="mb-3">
                <input v-model="newAnswer.text" class="form-control" placeholder="Текст ответа" />
              </div>
              <div class="mb-3">
                <label>
                  <input v-model="newAnswer.correct" type="checkbox" />
                  Верный ответ
                </label>
              </div>

              <!-- Кнопка для добавления ответа -->
              <button @click="addAnswer" class="btn btn-outline-success mt-3">Добавить ответ</button>
              <button @click="showAnswerModal = false" class="btn btn-danger mt-3">Закрыть</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.add-lesson-page {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 20px;
  background-color: #f4f5f7;
}

.card {
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
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

.modal-card {
  background-color: white;
  padding: 30px;
  border-radius: 20px;
  width: 500px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
  z-index: 20001;
  transition: opacity 0.3s ease, transform 0.3s ease;
  opacity: 0;
  transform: scale(0.9);
}

.modal-backdrop .modal-card {
  opacity: 1;
  transform: scale(1);
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

.btn-outline-success {
  border: 2px solid #62d8a3;
  color: #62d8a3;
  background-color: transparent;
}

.btn-outline-success:hover {
  background-color: #62d8a3;
  color: white;
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
  background-color: #dc3545;
  color: #fff;
  border: none;
}

.btn-danger:hover {
  background-color: #c82333;
}
</style>
