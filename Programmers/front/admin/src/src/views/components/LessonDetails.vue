<script setup>
import { ref, onMounted, computed } from 'vue';
import { useLessonStore } from '@/store/lessonStore';
import LoaderComponent from "@/views/components/LoaderComponent.vue";
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();

const lessonStore = useLessonStore();
const lessonId = route.params.lessonId;

onMounted(() => {
  lessonStore.fetchLessons(lessonId);
});

const lesson = computed(() => lessonStore.lesson);
const isLoading = computed(() => lessonStore.isLoading);

const isEditMode = ref(false);
const editableLesson = ref(null);

const goBack = () => {
  router.back();
};

const toggleEditMode = () => {
  if (isEditMode.value) {
    saveLesson();
  } else {
    editableLesson.value = { ...lesson.value };
  }
  isEditMode.value = !isEditMode.value;
};

const saveLesson = () => {
  lesson.value.name = editableLesson.value.name;
  lesson.value.description = editableLesson.value.description;
  lesson.value.average_rating = editableLesson.value.average_rating;
  lesson.value.tutorial_link = editableLesson.value.tutorial_link;
};

const getYouTubeVideoId = (url) => {
  const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|watch|results\?search_query)=|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
  const match = url.match(regex);
  return match ? match[1] : null;
};

const videoId = computed(() => lesson.value?.tutorial_link ? getYouTubeVideoId(lesson.value.tutorial_link) : null);

const expandedQuestions = ref({});
const toggleQuestion = (questionId) => {
  expandedQuestions.value[questionId] = !expandedQuestions.value[questionId];
};

const updateQuestion = (question, newText, newRating) => {
  question.name = newText;
  question.rating = newRating;
};

const updateAnswer = (answer, newText) => {
  answer.text = newText;
};

const addQuestion = () => {
  const newQuestion = {
    id: Date.now(),
    name: '',
    rating: null,
    questions_answers: []
  };
  lesson.value.lesson_questions.push(newQuestion);
  expandedQuestions.value[newQuestion.id] = true;
};

const addAnswer = (question) => {
  const newAnswer = {
    id: Date.now(),
    text: '',
    correct: false
  };
  question.questions_answers.push(newAnswer);
};

const deleteQuestion = (question) => {
  lesson.value.lesson_questions = lesson.value.lesson_questions.filter(q => q.id !== question.id);
};

const deleteAnswer = (question, answer) => {
  question.questions_answers = question.questions_answers.filter(a => a.id !== answer.id);
};

const prepareLessonData = () => {
  return {
    lesson: {
      name: editableLesson.value.name,
      description: editableLesson.value.description
    },
    questions: lesson.value.lesson_questions.map(question => ({
      id: question.id || null,
      name: question.name,
      rating: question.rating || null,
      matter: question.matter || 0,
      questions_answers: question.questions_answers.map(answer => ({
        id: answer.id || null,
        text: answer.text,
        correct: answer.correct
      }))
    }))
  };
};

const confirmChanges = async (id) => {
  const lessonData = prepareLessonData();
  await lessonStore.updateLesson(id, lessonData);
  isEditMode.value = false;  // После подтверждения выходим из режима редактирования
};


const cancelEdit = () => {
  isEditMode.value = false;
  editableLesson.value = { ...lesson.value };
};

const toggleCorrectAnswer = (question, answer) => {
  // Снимаем все существующие отметки правильного ответа в вопросе
  question.questions_answers.forEach((ans) => {
    if (ans !== answer) ans.correct = false;
  });

  // Устанавливаем/снимаем отметку на выбранном ответе
  answer.correct = !answer.correct;
};

</script>

<template>
  <div>
    <LoaderComponent v-if="isLoading"/>
    <div v-else-if="lesson" class="lesson-details">
      <div class="header">
        <h1 v-if="!isEditMode" class="lesson-title">{{ lesson.name }}</h1>
        <input
            v-else
            type="text"
            v-model="editableLesson.name"
            placeholder="Edit lesson title"
            class="lesson-title-edit input-style"
        />
      </div>
      <p v-if="!isEditMode" class="lesson-description">{{ lesson.description }}</p>
      <textarea
          v-else
          v-model="editableLesson.description"
          placeholder="Edit lesson description"
          class="lesson-description-edit input-style"
      ></textarea>

      <div class="lesson-info">
        <p><strong>Course:</strong> {{ lesson.course?.name }}</p>
        <p><strong>Average Rating:</strong>
          <span v-if="!isEditMode">{{ Number(lesson.average_rating).toFixed(1) }}</span>
          <input
              v-else
              type="number"
              v-model="editableLesson.average_rating"
              min="0"
              max="5"
              step="0.1"
              placeholder="Edit rating"
              class="input-style"
          />
        </p>
        <p><strong>Review Count:</strong> {{ lesson.review_count }}</p>
        <p><strong>Question Count:</strong> {{ lesson.question_count }}</p>
        <p><strong>Tutorial Link:</strong>
          <span v-if="!isEditMode">
            <a :href="lesson.tutorial_link" target="_blank" class="video-link">{{ lesson.tutorial_link }}</a>
          </span>
          <input
              v-else
              type="text"
              v-model="editableLesson.tutorial_link"
              placeholder="Edit video link"
              class="input-style"
          />
        </p>
      </div>

      <div v-if="videoId" class="video-container">
        <iframe
            width="560"
            height="315"
            :src="'https://www.youtube.com/embed/' + videoId"
            frameborder="0"
            allowfullscreen>
        </iframe>
      </div>

      <div class="questions-container">
        <h2>Questions:</h2>
        <div v-for="(question, qIndex) in lesson.lesson_questions" :key="question.id" class="question-item">
          <h3 @click="toggleQuestion(question.id)" class="question-header">
            {{ qIndex + 1 }}. {{ question.name }}
            <span v-if="!expandedQuestions[question.id]">[+]</span>
            <span v-else>[-]</span>
            <button v-if="isEditMode" @click.stop="deleteQuestion(question)" class="btn btn-danger btn-delete">Delete Question</button>
          </h3>
          <div v-if="expandedQuestions[question.id]" class="question-edit">
            <input
                v-if="isEditMode"
                type="text"
                v-model="question.name"
                @change="updateQuestion(question, question.name, question.rating)"
                placeholder="Edit question text"
                class="input-style"
            />
            <input
                v-if="isEditMode"
                type="number"
                v-model="question.rating"
                min="0"
                max="5"
                step="0.1"
                placeholder="Set question rating"
                class="input-style"
            />
            <ul>
              <li v-for="(answer, aIndex) in question.questions_answers" :key="answer.id">
                <input
                    v-if="isEditMode"
                    type="text"
                    v-model="answer.text"
                    @change="updateAnswer(answer, answer.text)"
                    :placeholder="`Edit answer ${aIndex + 1}`"
                    class="input-style"
                />
                <span v-else>{{ answer.text }}</span>
                <span v-if="answer.correct">(Correct)</span>
                <div v-if="isEditMode">
                  <input type="checkbox" :checked="answer.correct" @change="toggleCorrectAnswer(question, answer)" /> Mark as correct
                  <button @click="deleteAnswer(question, answer)" class="btn btn-danger">Delete Answer</button>
                  <span v-if="answer.correct && question.questions_answers.filter(ans => ans.correct).length > 1" class="error-message">Only one correct answer allowed</span>
                </div>
              </li>
            </ul>
            <button v-if="isEditMode" @click="addAnswer(question)" class="btn btn-add">Add Answer</button>
          </div>
        </div>
      </div>
      <button v-if="isEditMode" @click="addQuestion" class="btn btn-add">Add Question</button>

      <button v-if="isEditMode" @click="confirmChanges(lesson.id)" class="btn btn-primary">Confirm changes</button>
      <button v-if="isEditMode" @click="cancelEdit" class="btn btn-secondary">Cancel</button>
      <button @click="toggleEditMode" class="btn btn-primary">{{ isEditMode ? "Save" : "Edit" }}</button>
      <button @click="goBack" class="btn btn-back">Go back</button>
    </div>
  </div>
</template>



<style scoped>
.lesson-details {
  max-width: 800px; /* Максимальная ширина компонента */
  margin: 0 auto; /* Центрируем компонент */
  padding: 20px; /* Отступы вокруг контента */
  border-radius: 15px; /* Закруглённые углы */
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Тень для эффекта глубины */
  background-color: #f9f9f9; /* Фоновый цвет */
}

.header {
  display: flex;
  justify-content: space-between; /* Равное распределение пространства */
  align-items: center; /* Вертикальное центрирование */
}

.lesson-title {
  font-size: 1.5em; /* Размер шрифта для заголовка урока */
}

.lesson-title-edit {
  width: 100%; /* Ширина инпута */
  padding: 10px; /* Отступы внутри инпута */
  border: 1px solid #ccc; /* Рамка инпута */
  border-radius: 5px; /* Закруглённые углы */
  font-size: 1em; /* Размер шрифта для инпута */
}

.lesson-description-edit {
  width: 100%; /* Ширина текстовой области */
  padding: 10px; /* Отступы внутри текстовой области */
  border: 1px solid #ccc; /* Рамка текстовой области */
  border-radius: 5px; /* Закруглённые углы */
  font-size: 1em; /* Размер шрифта для текстовой области */
}

.input-style {
  width: 100%; /* Ширина инпутов */
  padding: 10px; /* Отступы внутри инпутов */
  border: 1px solid #ccc; /* Рамка инпутов */
  border-radius: 5px; /* Закруглённые углы */
  font-size: 1em; /* Размер шрифта для инпутов */
  margin-bottom: 10px; /* Отступ снизу */
  transition: border-color 0.3s; /* Плавный переход для рамки */
}

.input-style:focus {
  border-color: #007bff; /* Цвет рамки при фокусировке */
  outline: none; /* Убираем стандартный контур */
}

.video-container {
  margin: 20px 0; /* Отступы вокруг видео */
}

.questions-container {
  margin: 20px 0; /* Отступы вокруг блока вопросов */
}

.question-item {
  margin-bottom: 15px; /* Отступы между вопросами */
}

.btn {
  padding: 10px 15px; /* Отступы внутри кнопок */
  border: none; /* Убираем стандартные рамки */
  border-radius: 5px; /* Закруглённые углы для кнопок */
  cursor: pointer; /* Курсор при наведении */
}

.btn-primary {
  background-color: #007bff; /* Цвет фона кнопки "Подтвердить" */
  color: white; /* Цвет текста кнопки "Подтвердить" */
}

.btn-secondary {
  background-color: #6c757d; /* Цвет фона кнопки "Отменить" */
  color: white; /* Цвет текста кнопки "Отменить" */
}

.btn-outline-dark {
  background-color: transparent; /* Прозрачный фон для кнопки "Назад" */
  color: #343a40; /* Цвет текста кнопки "Назад" */
  border: 1px solid #343a40; /* Рамка кнопки "Назад" */
}

.btn-add {
  background-color: #28a745; /* Цвет фона кнопки "Добавить" */
  color: white; /* Цвет текста кнопки "Добавить" */
}

.btn-edit {
  background-color: #ffc107; /* Цвет фона кнопки "Редактировать" */
  color: black; /* Цвет текста кнопки "Редактировать" */
}

.error-message {
  color: red; /* Цвет сообщения об ошибке */
  font-size: 0.9em; /* Размер шрифта для сообщения об ошибке */
}

.video-link {
  word-wrap: break-word; /* Позволяет переносить длинные слова */
  overflow-wrap: break-word; /* Для лучшей совместимости с браузерами */
  white-space: normal; /* Позволяет перенос строк */
  display: inline-block; /* Обеспечивает, что элемент будет вести себя как блочный, но в строковом контексте */
  max-width: 100%; /* Ограничивает ширину ссылки до 100% от родительского элемента */
}

</style>
