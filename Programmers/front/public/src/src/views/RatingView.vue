<script setup>

import TopBar from "@/components/TopBar.vue";
import Sidebar from "@/components/Sidebar.vue";
import LoadingCircle from "@/components/LoadingCircle.vue";
import Footer from "@/components/Footer.vue";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faBolt} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
library.add(faBolt);
</script>

<script>
import {toast} from "vue3-toastify";
import axios from "axios";

export default {
  data() {
    return {
      loading: true,
      users: []
    };
  },
  async mounted() {
    try {
      const response = await axios.get(`http://localhost/api/public/profile/users/rating`);
      console.log(response.data);
      this.users = response.data;
      this.loading = false
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
          <h1>Top 10 scores</h1>
          <div id="users-container">
            <div v-for="(user, index) in users" class="user-card">
              <span class="user-place">{{index+1}}</span>
              <img src="@/assets/user.png" class="img-profile-picture" alt="Profile Picture" />
              <h4 class="username">{{user.name}}</h4>
              <div class="level-stats">
                <font-awesome-icon icon="bolt" class="level-icon"/>
                <h6 class="level-text">{{user.masteryLevel}}</h6>
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

.user-card {
  width: 100%;
  background: white;
  border-radius: 100px;
  margin-top: 20px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  height: 75px;
  display: flex;
  align-items: center;
}

.user-card:nth-child(1) {
  border: #ecb53f 2px groove;
}

.user-card:nth-child(2) {
  border: silver 2px groove;
}

.user-card:nth-child(3) {
  border: #e87211 2px groove;
}

.user-place, .username {
  font-size: 16px;
  font-weight: bold;
}

.user-place {
  margin-left: 20px;
  margin-right: 40px;
}

.img-profile-picture {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 50px;
}

.level-stats {
  display: flex;
  width: 100%;
  justify-content: right;
  padding-right: 40px;
}

.level-icon {
  height: 30px;
  width: 30px;
  color: #f4ce1a;
  margin-right: 10px;
}

.level-text {
  font-size: 18px;
  font-weight: bold;
}

</style>