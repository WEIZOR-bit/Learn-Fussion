<script setup>
import Sidebar from "@/components/Sidebar.vue";
import TopBar from "@/components/TopBar.vue";

if (!axios.defaults.headers.common['Authorization']) {
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
                <input type="text" v-model="user.name" disabled />
              </div>
              <div>
                <label>Mastery Tag</label>
                <input type="text" v-model="user.mastery_tag" disabled />
              </div>
              <div>
                <label>Email Address</label>
                <input type="text" v-model="user.email" disabled />
              </div>
              <div>
                <label>Mastery Level</label>
                <input type="text" v-model="user.mastery_level" disabled />
              </div>
            </div>
          </div>

          <div class="courses">
            <h3>Courses</h3>
            <p>Finished ({{user.finished_courses}})</p>
          </div>

          <div class="subscription">
            <div class="subscription-box">
              <h3>Premium</h3>
              <p>Join the premium users to enjoy exclusive Super benefits</p>
              <button>UPGRADE MY EXPERIENCE</button>
            </div>
          </div>
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

export default {
  data() {
    return {
      user: {
        name: '',
        mastery_level: '',
        mastery_tag: '',
        email: '',
      },
      friends: []
    };
  },
  async mounted() {
    await this.fetchUser();
  },
  methods: {
    async fetchUser() {
      try {
        const response_user = await axios.get('http://localhost:8000/api/public/me');

        this.user = {
          id: response_user.data.id,
          name: response_user.data.name,
          mastery_level: response_user.data.mastery_level,
          mastery_tag: response_user.data.mastery_tag,
          email: response_user.data.email,
        };

        let response_count = await axios.get(`http://localhost/api/public/profile/courses-finished/user/${this.user.id}/count`);

        this.user = {
          ...this.user,
          finished_courses: response_count.data,
        };

        response_count = await axios.get(`http://localhost/api/public/profile/users/${this.user.id}/streak`);

        this.user = {
          ...this.user,
          streakDays: response_count.data,
        };

      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
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

</style>