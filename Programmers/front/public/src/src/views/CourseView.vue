<script setup>
import Sidebar from "@/components/Sidebar.vue";
import TopBar from "@/components/TopBar.vue";
import LoadingCircle from "@/components/LoadingCircle.vue";
import Footer from "@/components/Footer.vue";
import {faArrowLeft, faCheck, faQuestion, faBookOpen, faCircleExclamation} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {library} from "@fortawesome/fontawesome-svg-core";

library.add(faArrowLeft, faCheck, faQuestion, faBookOpen, faCircleExclamation);
</script>

<script>

import axios from "axios";
import {toast} from "vue3-toastify";
import {useUserStore} from "@/stores/userStore.js";

export default {

  setup() {
    const userStore = useUserStore();

    return { userStore };
  },

  data() {
    return {
      course: {},
      loading:true,
      nextLessonIndex:-1,
      userLoggedIn: false
    }
  },

  async mounted() {
    try {

      const userStore = useUserStore();

      console.log(userStore.user);
      if (userStore.isAuthenticated) {
        this.userLoggedIn = true;
        const response_course = await axios.get(`http://localhost/api/public/profile/courses/${this.$route.params.id}/user/${userStore.user.id}`);
        console.log(response_course);
        this.course = {
          name: response_course.data.name,
          lessons: response_course.data.lessonsForUser,
        }
      }
      else {
        const response_course = await axios.get(`http://localhost/api/public/profile/courses/${this.$route.params.id}`);
        console.log(response_course);
        this.course = {
          name: response_course.data.name,
          lessons: response_course.data.lessons,
        }
      }
      this.course = {
        name: this.course.name,
        lessons: this.course.lessons.sort((a, b) => a.order - b.order)
      }

      const lastCompletedIndex = this.course.lessons.findIndex(lesson => lesson.completed === false);
      this.nextLessonIndex = lastCompletedIndex === -1 ? 0 : lastCompletedIndex;

      this.loading = false;
    }
    catch (error) {
      console.log(error);
      toast.error(error.response.data.message, {
        position: toast.POSITION.BOTTOM_RIGHT,
      });
    }
  }
}
</script>

<template>
  <div id="container">
    <div id="page-wrapper">
      <Sidebar/>
      <div id="page-content">
        <TopBar/>
        <LoadingCircle v-if="loading" style="margin-top: 30px"/>
        <div id="main-content" v-else>
          <div id="course-header">
            <router-link :to="'/courses'" id="back-container">
              <font-awesome-icon icon="arrow-left" id="back-icon"/>
              <span id="back-text">all courses</span>
            </router-link>
            <div>
              <span id="course-name">{{ course.name }}</span>
            </div>
          </div>
          <div id="login-container" v-if="!userLoggedIn">
            <font-awesome-icon icon="circle-exclamation" style="font-size: 26px; color: #ed2c2c;"/>
            <span>Log in first to start tracking progress</span>
            <font-awesome-icon icon="circle-exclamation" style="font-size: 26px; color: #ed2c2c;"/>
          </div>
          <div id="lessons-container">
            <div v-for="(lesson, index) in course.lessons" class="lesson-card">
              <div class="lesson-icon-container">
                <div
                    class="lesson-icon-inner-container"
                    :style="{
                      background: lesson.completed
                        ? '#1c7430'
                        : index === nextLessonIndex && userLoggedIn
                          ? '#8559BA'
                          : '#d3d3d3'
                    }">
                  <font-awesome-icon :icon="lesson.completed ? 'check' : 'book'" class="lesson-icon"/>
                </div>
              </div>

              <router-link :to="`/lessons/${lesson.id}`" v-if="index === this.nextLessonIndex && this.userLoggedIn"
                           class="lesson-info lesson-info-next">
                <h3>{{lesson.name}}</h3>
                <hr>
                <div class="lesson-stats-container">
                  <div class="lesson-stats-inner-container">
                    <span>
                      <font-awesome-icon icon="question" style="font-weight: bold"/>
                    </span>
                    <h5>{{lesson.question_count}}</h5>
                  </div>
                </div>
              </router-link>

              <div class="lesson-info" v-else>
                <h3>{{lesson.name}}</h3>
                <hr>
                <div class="lesson-stats-container">
                  <div class="lesson-stats-inner-container">
                    <span>
                      <font-awesome-icon icon="question" style="font-weight: bold"/>
                    </span>
                    <h5>{{lesson.question_count}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Footer/>
  </div>
</template>

<style scoped>
#container {
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

#course-header {
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

#back-icon {
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

#course-name {
  font-size: 20px;
  font-weight: bold;
}

#login-container {
  width: 30%;
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
  margin: 10px auto;
  margin-top: 20px;
  border-radius: 20px;
  background: white;
  padding: 20px 10px;
  border: 2px groove #ed2c2c;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

#login-container>span {
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  padding: 10px 5px;
}

.lesson-card {
  width: 100%;
  padding: 10px 15px;
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
  border-radius: 40px;
  background: white;
  margin: 10px auto;
  display: flex;
}

.lesson-icon-container {
  display: flex;
  justify-content: center;
  margin-right: 12px;
  margin-top: 24px;
}

.lesson-icon-inner-container {
  border-radius: 50%;
  width: 52px;
  height: 52px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.lesson-icon {
  color: white;
  font-size: 26px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.lesson-info {
  padding: 8px 0;
  width: calc(100% - 50px);
}

.lesson-info-next {
  color: black;
}

.lesson-info-next:hover {
  background: none;
}

.lesson-info > h3 {
  font-size: 16px;
  text-transform: uppercase;
  font-weight: bold;
  margin: 0;
  font-family: 'Quattrocento', sans-serif;
}

.lesson-info > hr {
  border: 0;
  height: 2px;
  background-color: dimgray;
  margin-top: 6px;
  border-radius: 30px;
}

.lesson-stats-container {
  display: flex;
  justify-content: end;
  margin-top:5px;
}

.lesson-stats-inner-container {
  display: flex;
  margin: 0 10px;
  padding: 3px 5px;
}

.lesson-stats-inner-container > span,
.lesson-stats-inner-container > h5 {
  font-size: 14px;
  padding: 5px 10px;
  border: 1px solid dimgray;
}

.lesson-stats-inner-container > span {
  border-radius: 20px 0 0 20px;
}

.lesson-stats-inner-container > h5 {
  background: #b5b8bd;
  border-radius: 0 20px 20px 0;
  border-left: none;
  font-weight: bold;
}

</style>