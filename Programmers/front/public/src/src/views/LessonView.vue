<script setup>
import LoadingCircle from "@/components/LoadingCircle.vue";
import Sidebar from "@/components/Sidebar.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faArrowLeft, faArrowRight} from '@fortawesome/free-solid-svg-icons';
import {library} from "@fortawesome/fontawesome-svg-core";
import TopBarDynamic from "@/components/TopBarDynamic.vue";
import {useUserStore} from "@/stores/userStore.js";

library.add(faArrowLeft, faArrowRight);

</script>

<template>
  <div class="container">
    <div id="page-wrapper">
      <Sidebar/>
      <div id="page-content">
        <TopBarDynamic :mastery_level="user.mastery_level" :hearts="user.hearts" :streak-days="user.streakDays" v-if="statsLoaded"/>
        <LoadingCircle v-if="loading" style="margin-top: 30px"/>
        <div id="main-content" v-else>
          <div id="lesson-header">
            <router-link :to="`/courses/${lesson.course_id}`" id="back-container">
              <font-awesome-icon icon="arrow-left" class="arrow-icon"/>
              <span id="back-text">back to course</span>
            </router-link>
            <div>
              <span id="lesson-name">{{ lesson.name }}</span>
            </div>
          </div>

          <div id="question-container">
            <div id="question-upper-container">
              <span>Question: </span>
            </div>
            <div id="question-lower-container">
              <div id="question-number">
                <span>{{currentIndex+1}}</span>
              </div>
              <div id="question-content">
                <span>{{lesson.questions[currentIndex].matter}}</span>
              </div>
            </div>
          </div>

          <div id="options-container">
            <p>Options:</p>
            <div
                v-for="(option, index) in lesson.questions[currentIndex].answers"
                :key="index"
                class="option"
            >
              <input
                  type="radio"
                  :id="'option' + index"
                  :value="index"
                  v-model="selectedOption"
                  @change="resetFeedback"
                  :disabled="!canChooseOptions"
              />
              <label
                  :for="'option' + index"
                  :class="{
                    selected: selectedOption === index,
                    'correct-answer': showCorrectAnswer && option.correct,
                    'incorrect-answer': showIncorrectAnswer && index === selectedOption
                  }"
              >
                {{ option.text }}
              </label>
            </div>
          </div>

          <div id="action-button-container">
            <button
                id="action-button"
                :disabled="selectedOption === null"
                @click="checkAnswer"
            >
              {{ this.actionButtonState }}
              <img src="@/assets/arrow-right.png" alt="arrow">
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import {toast} from "vue3-toastify";
  import {useUserStore} from "@/stores/userStore.js";

  export default {
    data() {
      return {
        user: {},
        lesson: {},
        loading:true,
        currentIndex: 0,
        selectedOption: null,
        showCorrectAnswer: false,
        showIncorrectAnswer: false,
        statsLoaded:false,
        actionButtonState: 'Check',
        canChooseOptions: true,
      }
    },
    async mounted() {

      const userStore = useUserStore();

      if (!userStore.isAuthenticated) {
        this.$router.push({name: 'login'});
      }

      this.user = await userStore.getUser();

      if (this.user.hearts <= 0) {
        this.$router.push({name: 'home'});
      }

      let response_streak = await axios.get(`http://localhost/api/public/profile/users/${this.user.id}/streak`);

      this.user = {
        ...this.user,
        streakDays: response_streak.data,
      }
      this.statsLoaded = true;
      localStorage.setItem('streak_days',response_streak.data);

      try {
        const response_lesson = await axios.get(`http://localhost/api/public/profile/lessons/${this.$route.params.id}`);
        console.log(response_lesson);
        this.lesson = response_lesson.data;

        this.loading = false;
      }
      catch (error) {
        console.log(error);
        toast.error(error.response.data.message, {
          position: toast.POSITION.BOTTOM_RIGHT,
        });
      }
    },
    methods: {
      resetFeedback() {
        this.showCorrectAnswer = false;
        this.showIncorrectAnswer = false;
      },
      async checkAnswer() {

        if (this.actionButtonState === 'Check') {
          const userStore = useUserStore();
          this.canChooseOptions = false;
          if (this.lesson.questions[this.currentIndex].answers[this.selectedOption].correct) {

            this.showCorrectAnswer = true;

            if (this.currentIndex + 1 >= this.lesson.questions.length) {
              this.actionButtonState = 'End';
            }
            else {
              this.actionButtonState = 'Next';
            }
          }
          else {

            this.showCorrectAnswer = true;
            this.showIncorrectAnswer = true;

            try {
              this.user.hearts--;

              var temp = this.selectedOption;
              this.selectedOption = null;

              const response = await axios.post(`http://localhost/api/public/profile/users/${userStore.user.id}/decrease-hearts`);
              userStore.setUser(response.data);

              this.selectedOption = temp;

              if (this.user.hearts <= 0) { // User lost all hearts
                this.selectedOption = null;
                toast.error("Sorry! It seems you're out of hearts. Come back tomorrow though!", {
                  position: toast.POSITION.TOP_CENTER,
                });
                setTimeout(() => {
                  this.$router.push({name: 'home'});
                },3000);
                // Handle zero hearts case (e.g., end lesson, show message)
              }
              else if (this.currentIndex + 1 >= this.lesson.questions.length) { //User got last question wrong, but still finished
                this.actionButtonState = 'End';
              }
              else { // User got question wrong, proceeding to next one
                this.actionButtonState = 'Next';
              }
            } catch (error) {
              console.log(error);
              toast.error(error.response.data.message, {
                position: toast.POSITION.BOTTOM_RIGHT,
              });
            }
          }
        }
        else if (this.actionButtonState === 'Next'){

          this.showCorrectAnswer = false;
          this.showIncorrectAnswer = false;
          this.selectedOption = null;

          this.currentIndex++;
          this.actionButtonState = 'Check';
          this.canChooseOptions = true;
        }
        else if (this.actionButtonState === 'End') {
          toast.success('Congratulations!', {
            position: toast.POSITION.TOP_CENTER,
          });
          // TODO отправить реквест на окончание урока, на бэке проверять закончил ли курс и если что делать энтри в бд
          // TODO LessonFinishedController почему то не работает как нужно(post реквест http://localhost/api/public/profile/lessons-finished/ не авторизирован)
        }
      }
    }
  }
</script>

<style scoped>
.container {
  width: 100%;
  height: 100vh;
}

#page-wrapper {
  display: flex;
  overflow: hidden;
  height: 100%;
}

#page-content {
  display: flex;
  flex-direction: column;
  width: calc(100% - 200px);
  height: 100%;
}

#main-content {
  height: 95%;
  width: 100%;
  overflow-y: auto;
  padding: 20px;
  color: #333;
  display: flex;
  flex-direction: column;
}

#lesson-header {
  background-color: #8559BA;
  color: white;
  padding: 15px 30px;
  border-radius: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

#back-container {
  color: white;
}

#back-container:hover {
  background:none;
}

.arrow-icon {
  font-size: 20px;
  display: inline-block;
  margin-right: 5px;
}

#back-text {
  font-size: 14px;
  text-transform: uppercase;
  line-height: 1;
  position: relative;
  top: -2px;
}

#lesson-name {
  font-size: 20px;
  font-weight: bold;
}

#question-container {
  background-color: #f8f8f8;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 100%;
  margin: 10px 0;
}

#question-upper-container {
  margin-bottom: 10px;
}

#question-upper-container>span {
  color: #BFBFBF;
  font-size: 16px;
  font-weight: bold;
}

#question-lower-container {
  display: flex;
  align-items: center;
  width: 100%;
}

#question-number {
  background-color: #8559BA;
  color: white;
  font-weight: bold;
  font-size: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 15px;
}

#question-content {
  font-size: 20px;
  color: black;
}

#options-container {
  background-color: #f8f8f8;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 100%;
  margin: 10px 0 20px 0;
}

#options-container>p {
  color: #BFBFBF;
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 15px;
}

.option {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

#options-container input[type="radio"] {
  margin-right: 10px;
}

#options-container label {
  padding: 10px 20px;
  background-color: #fff;
  border-radius: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: background-color 0.5s ease;
}

#options-container label.selected {
  background-color: #7b4bc4;
  color: white;
  font-weight: bold;
}

#action-button-container {
  display: flex;
  justify-content: end;
  padding: 10px;
}

#action-button {
  padding: 15px 20px;
  background-color: #7b4bc4;
  color: white;
  border: none;
  border-radius: 100px;
  cursor: pointer;
  opacity: 0.5;
  transition: opacity 0.3s ease;
  font-size: 16px;
  font-weight: bold;
  display: flex;
  justify-content: center;
  align-items: center;
}

#action-button:disabled {
  cursor: not-allowed;
}

#action-button:not(:disabled) {
  opacity: 1;
}

#action-button > img {
  width: 20px;
  height: 20px;
  margin-left: 5px;
}

.correct-answer {
  background-color: green !important;
  color: white;
}

.incorrect-answer {
  background-color: red !important;
  color: white;
}

</style>