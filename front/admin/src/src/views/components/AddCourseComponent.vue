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
            <label for="title" class="form-label">Course Title</label>
            <input
              v-model="course.title"
              type="text"
              class="form-control"
              id="title"
              placeholder="Enter course title"
              required
            />
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
              v-model="course.averageRating"
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

          <!-- Button to Add Lessons -->
          <button @click="showLessonModal = true" type="button" class="btn btn-primary">Add Lessons</button>

          <!-- List of Added Lessons -->
          <div class="mt-4">
            <h6>Added Lessons</h6>
            <ul>
              <li v-for="(lesson, index) in course.lessons" :key="index">
                {{ lesson.title }} - {{ lesson.description }}
              </li>
            </ul>
          </div>

          <!-- Submit Course -->
          <button type="submit" class="btn btn-success mt-4">Submit Course</button>
        </form>
      </div>
    </div>

    <!-- Modal for Adding Lessons -->
    <div v-if="showLessonModal" class="modal-backdrop">
      <div class="modal">
        <h3>Add new lesson</h3>

        <!-- Fields for Adding Lessons -->
        <div class="mb-3">
          <input v-model="newLesson.title" class="form-control" placeholder="Lesson name" />
        </div>
        <div class="mb-3">
          <input v-model="newLesson.description" class="form-control" placeholder="Lesson description" />
        </div>
        <div class="mb-3">
          <input v-model="newLesson.tutorial_link" class="form-control" placeholder="Lesson tutorial link" />
        </div>
        <div class="mb-3">
          <input v-model="newLesson.average_rating" class="form-control" placeholder="Lesson average rating" />
        </div>
        <div class="mb-3">
          <input v-model="newLesson.task" class="form-control" placeholder="Lesson task" />
        </div>

        <!-- Add Lesson Button -->
        <button @click="addLesson" class="btn btn-primary">Add lesson</button>

        <!-- Close Modal -->
        <button @click="showLessonModal = false" class="btn btn-secondary mt-3">End</button>

        <!-- List of Added Lessons in Modal -->
        <div class="mt-4">
          <h6>Lessons:</h6>
          <ul>
            <li v-for="(lesson, index) in course.lessons" :key="index">
              {{ lesson.title }} - {{ lesson.description }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showLessonModal: false,  // Управляет видимостью модального окна
      course: {
        title: '',
        description: '',
        averageRating: null,
        lessons: []  // Список уроков
      },
      newLesson: {
        title: '',
        description: '',
        tutorial_link: '',
        average_rating: null,
        task: ''
      },
    };
  },
  methods: {
    addLesson() {
      // Добавление нового урока в массив уроков
      if (this.newLesson.title && this.newLesson.description) {
        this.course.lessons.push({ ...this.newLesson });
        this.newLesson = { title: '', description: '' };  // Очистка полей для нового урока
      }
    },
    submitCourse() {
      // Логика для отправки данных курса на сервер
      console.log("Course submitted:", this.course, this.course.lessons);
      // Здесь можно реализовать отправку данных на сервер через API
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
  background-color: rgba(0, 0, 0, 0.5); /* Затемненный фон */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 20000; /* Высокий z-index для перекрытия остальных элементов */
}

  .modal {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 20001; /* Выше, чем у backdrop */
  }

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}
</style>
