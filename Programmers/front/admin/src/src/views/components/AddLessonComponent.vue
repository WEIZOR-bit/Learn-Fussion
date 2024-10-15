<script setup>
import {computed, onMounted, ref} from 'vue';
import {useRoute} from "vue-router";
import { useAuthStore } from '@/store/auth.js';
import {useCoursesStore} from "@/store/coursesStore.js";
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
  course_id:parseInt(route.params.id, 10),
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
    // Создаем новый объект урока, чтобы избежать ссылок на один и тот же объект
    const lessonToAdd = {
      ...lesson.value, // Копируем все значения
      questions: [...lesson.value.questions], // Копируем массив вопросов
    };
    const id = parseInt(route.params.id, 10);
    lessons.value.push(lessonToAdd); // Добавляем новый урок в массив
    console.log(lessons.value); // Проверка структуры массива
    coursesStore.addLesson({ lessons: lessons.value}, {id} ); // Отправляем массив уроков
    router.push({ name: 'Course Details', params: {this:lesson.id} });
};
</script>

<template>
  <div>
    <LoaderComponent v-if="isLoading"/>
  <div v-else>
    <h3>Add new lesson</h3>
    <!-- Поля для добавления урока -->
    <div class="mb-3">
      <input v-model="lesson.name" class="form-control" placeholder="Lesson name" />
    </div>
    <div class="mb-3">
      <input v-model="lesson.description" class="form-control" placeholder="Lesson description" />
    </div>
    <div class="mb-3">
      <input v-model="lesson.tutorial_link" class="form-control" placeholder="Lesson tutorial link" />
    </div>
    <div class="mb-3">
      <input v-model="lesson.average_rating" class="form-control" placeholder="Lesson average rating" type="number" />
    </div>

    <!-- Кнопка для добавления вопросов -->
    <button @click="openQuestionModal" class="btn btn-primary mb-3">Add Questions</button>

    <!-- Список добавленных вопросов -->
    <div v-if="lesson.questions.length">
      <h5>Questions:</h5>
      <ul>
        <li v-for="(question, index) in lesson.questions" :key="index">
          {{ question.name }} (Matter: {{ question.matter }})
          <ul>
            <li v-for="(answer, answerIndex) in question.answers" :key="answerIndex">
              {{ answer.text }} <span v-if="answer.correct">(Correct)</span>
            </li>
          </ul>
        </li>
      </ul>
    </div>

    <!-- Кнопка завершения добавления урока -->
    <button @click="addLesson" class="btn btn-success mt-3">Finish Lesson</button>

    <!-- Модальное окно для добавления вопросов -->
    <div v-if="showQuestionModal" class="modal-backdrop">
      <div class="modal">
        <h3>Add new question</h3>
        <div class="mb-3">
          <input v-model="newQuestion.name" class="form-control" placeholder="Question text" />
        </div>
        <div class="mb-3">
          <input v-model="newQuestion.matter" type="number" class="form-control" placeholder="Question matter" />
        </div>

        <!-- Кнопка для добавления ответов -->
        <button @click="openAnswerModal" class="btn btn-secondary mb-3">Add Answers</button>

        <!-- Список добавленных ответов -->
        <div v-if="newQuestion.answers.length">
          <h5>Answers:</h5>
          <ul>
            <li v-for="(answer, index) in newQuestion.answers" :key="index">
              {{ answer.text }} <span v-if="answer.correct">(Correct)</span>
            </li>
          </ul>
        </div>

        <!-- Кнопка для добавления вопроса -->
        <button v-if="newQuestion.answers.some(answer => answer.correct)" @click="addQuestion" class="btn btn-success mt-3">Add Question</button>
        <button @click="showQuestionModal = false" class="btn btn-danger mt-3">Exit</button>
      </div>
    </div>

    <!-- Модальное окно для добавления ответов -->
    <div v-if="showAnswerModal" class="modal-backdrop">
      <div class="modal">
        <h3>Add new answer</h3>
        <div class="mb-3">
          <input v-model="newAnswer.text" class="form-control" placeholder="Answer text" />
        </div>
        <div class="mb-3">
          <label>
            <input v-model="newAnswer.correct" type="checkbox" />
            Is Correct
          </label>
        </div>

        <!-- Кнопка для добавления ответа -->
        <button @click="addAnswer" class="btn btn-primary mt-3">Add Answer</button>
        <button @click="showAnswerModal = false" class="btn btn-danger mt-3">Exit</button>
      </div>
    </div>
  </div>
  </div>
</template>

<style scoped>
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
}
</style>
