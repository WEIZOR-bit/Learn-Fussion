<script setup>
import Sidebar from "@/components/Sidebar.vue";
import TopBar from "@/components/TopBar.vue";
import {useUserStore} from "@/stores/userStore.js";

const userStore = useUserStore();

if (!userStore.isAuthenticated) {
  window.location.href='/login';
}
</script>

<template>
  <div class="profile-container">
    <Sidebar/>

    <div class="page-content">

      <TopBar/>

      <div class="bottom-content">
        <div class="main-content">

          <div class="profile-header">
            <h2>Profile</h2>
            <h4>A little something about yourself</h4>
            <div class="cover-img">
              <img class="profile-img" src="@/assets/user.png" alt="Profile Image">
            </div>
          </div>

          <div class="basics">
            <h3>Basics</h3>
            <div class="basic-info">
              <div>
                <label>Username</label>
                <input type="text" v-model="userStore.user.name" :disabled="!userStore.user.name" />
              </div>
              <div>
                <label>Mastery Tag</label>
                <input type="text" v-model="userStore.user.mastery_tag" :disabled="!userStore.user.mastery_tag" />
              </div>
              <div>
                <label>Email Address</label>
                <input type="text" v-model="userStore.user.email" :disabled="!userStore.user.email" />
              </div>
              <div>
                <label>Mastery Level</label>
                <input type="text" v-model="userStore.user.mastery_level" :disabled="!userStore.user.mastery_level" />
              </div>
            </div>
          </div>


          <div class="courses">
            <h3>Courses</h3>
            <div v-if="userStore.user.courses_finished.length === 0">
              <p>No courses completed yet.</p>
            </div>
            <ul>
              <li v-for="(course, index) in userStore.user.courses_finished" :key="index">
                {{ course.course.name }} (Rating: {{ course.course.average_rating }})
              </li>
            </ul>
          </div>

          <div class="subscription">
            <div class="subscription-box">
              <h3>Premium</h3>
              <p>Join the premium users to enjoy exclusive Super benefits</p>
              <button>UPGRADE MY EXPERIENCE</button>
            </div>
          </div>

          <button @click="logout" id="logout-button">
            Log Out
          </button>
        </div>

        <div class="friends-list">
          <h3>Your Friends</h3>
          <h4>To be added...</h4>
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
      streakDays: null,
      friends: [],
    };
  },
  async mounted() {
    await this.fetchStats();
    const userStore = useUserStore();
  },
  methods: {
    async fetchStats() {
      const userStore = useUserStore();

      try {

        let response_count = await axios.get(`http://0.0.0.0/api/public/profile/users/${userStore.user.id}/streak`);

        this.streakDays =  response_count.data;

      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
    async logout() {

      const userStore = useUserStore();

      try {
        if (!userStore.isAuthenticated) {
          toast.error('Please log in first.', {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
          return;
        }

        const response = await axios.post('http://0.0.0.0:8000/api/public/logout', {}, {
          headers: {
            'Authorization': `Bearer ${userStore.token}`
          }
        });

        console.log(response.data);

        userStore.logout();

        this.$router.push({name: 'home'});
      } catch (error) {
        console.log(error);
        toast.error(error.response.data.message, {
          position: toast.POSITION.BOTTOM_RIGHT,
        });
      }
    }
  }
};
</script>

<style scoped>
.profile-container {
  display: flex;
  width: 100%;
  height: 100vh;
}

.page-content {
  display: flex;
  flex-direction: column;
  width: calc(100% - 200px);
  height: 100%;
}

.bottom-content {
  height: 95%;
  width: 100%;
  overflow-y: auto;
  padding: 20px;
  display: flex;
}

.main-content {
  flex-grow: 1;
  padding: 20px;
  color: black;
}

.profile-header {
  position: relative;
  text-align: center;
  padding: 20px;
}

.profile-header h2 {
  text-align: left;
  font-weight: bold;
}

.profile-header h4 {
  text-align: left;
}

.cover-img {
  width: 100%;
  height: 200px;
  background: url('../assets/user-background.jpg') no-repeat center center;
  background-size: cover;
  border-radius: 20px;
  position: relative;
}

.profile-img {
  width: 100px;
  height: 100px;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

.basics {
  margin-top: 20px;
}

.basics h3 {
  font-weight: bold;
  margin: 1rem;
}

.basic-info {
  padding: 10px 20px;
  background: white;
  border-radius: 20px;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 20px;
}

.basic-info div {
  width: 48%;
  margin-bottom: 20px;
}

.basic-info div label {
  display: block;
  margin-bottom: 5px;
  font-size: 16px;
  font-weight: 400;
}

.basic-info div input {
  width: 100%;
  padding: 10px 15px;
  border-radius: 20px;
  border: none;
  background-color: #f4f4f4;
  color: #333;
  font-size: 16px;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
  outline: none;
}

input[type="text"]:focus {
  background-color: #eaeaea;
}

.subscription {
  margin-top: 20px;
}

.friends-list {
  background: #eee;
  border-radius: 20px;
  padding: 5px 20px 10px 10px;
  margin: 40px 25px 20px 10px;
  height: fit-content;
  color:black;
}

.friends-list h3{
  font-size: 20px;
  font-weight: 600;
  margin: 10px 5px;
}

.courses {
  margin-left: 20px;
}

.subscription-box {
  background: url('../assets/subscription-background.jpg') no-repeat center center;
  background-size: cover;
  padding: 30px;
  border-radius: 15px;
  width: 100%;
  max-width: 400px;
  margin: 10px 0 10px 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.subscription-box h3 {
  font-size: 20px;
  font-weight: 900;
  color: black;
  margin-bottom: 10px;
  padding: 1px 10px;
  background: #eee;
  border-radius: 10px;
  width: fit-content;
}

.subscription-box p {
  font-size: 16px;
  color: #fff;
  margin-bottom: 20px;
  font-weight: 600;
}

.subscription-box button {
  background-color: #6c5ce7;
  color: white;
  padding: 12px 25px;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.subscription-box button:hover {
  background-color: #4b3ac1;
}

input, button, h2, h3, p, label {
  color: black;
}

#logout-button {
  background: #c30000;
  font-size: 14px;
  font-weight: bold;
  color:white;
  padding: 12px 20px;
  border-radius: 30px;
  border: none;
  margin-left: 20px;
}

</style>