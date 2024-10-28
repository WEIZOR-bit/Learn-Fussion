<script setup>
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSearch,faFire,faHeart,faHeartBroken,faBolt} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import LoadingCircle from "@/components/LoadingCircle.vue";
library.add(faSearch,faFire,faHeart,faHeartBroken,faBolt);
</script>

<template>
  <div class="top-content">
    <div class="search-bar">
      <font-awesome-icon
          :icon="'fa-search'"
          class="font-icon"
          style="color: black"
      />
      <input type="text" placeholder="Search..." />
    </div>

    <LoadingCircle v-if="loading"/>

    <div v-if="statsLoaded && !loading" class="badges">
      <div class="badge">
        <font-awesome-icon
            :icon="'fa-fire'"
            class="font-icon"
            :class="{ activeClass: user.streakDays > 0, inactiveClass: !(user.streakDays > 0) }"
        /> <span>{{ user.streakDays }}</span>
      </div>
      <div class="badge">
        <font-awesome-icon
            :icon="user.hearts > 0 ? 'fa-heart' : 'fa-heart-broken'"
            class="font-icon"
            style="color: indianred;"
        /> <span>{{ user.hearts }}</span>
      </div>
      <div class="badge">
        <font-awesome-icon
            :icon="'fa-bolt'"
            class="font-icon"
            style="color: #f4ce1a;"
        /> <span>{{ user.mastery_level }}</span>
      </div>
    </div>

    <div v-if="!statsLoaded && !loading" class="auth-buttons">
      <button class="register-btn" @click="navigateTo('signup')">
        Registration
      </button>
      <button class="login-btn" @click="navigateTo('login')">
        Login
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import {useUserStore} from "@/stores/userStore.js";

export default {
  data() {
    return {
      user: {
        streakDays: '',
        mastery_level: '',
        hearts: ''
      },
      statsLoaded: false,
      loading: true,
    };
  },
  async mounted() {
    await this.fetchUserStats();
  },
  methods: {
    navigateTo(page) {
      this.$router.push({ name: page });
    },
    async fetchUserStats() {
      const userStore = useUserStore();
      try {

        this.user = await userStore.getUser();

        let response_streak = await axios.get(`http://0.0.0.0/api/public/profile/users/${this.user.id}/streak`);
        this.user = {
          ...this.user,
          streakDays: response_streak.data,
        };

        this.statsLoaded = true;
        this.loading = false;

      } catch (error) {
        console.error('Error fetching user data:', error);
        this.statsLoaded = false;
        this.loading = false;
      }
    },
  }
}
</script>

<style scoped>
.font-icon {
  margin: 5px 10px 5px 5px;
}

.top-content {
  display: grid;
  grid-template-columns: 83% 17%;
  align-items: center;
  gap: 20px;
  width: 100%;
  height: 50px;
  margin: 5px auto;
  padding: 10px;
}

.search-bar {
  display: flex;
  align-items: center;
  background-color: #f4f4f4;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  padding: 10px 15px;
  border-radius: 30px;
  margin-right: 20px;
  margin-left: 10px;
}

.search-bar i {
  margin-right: 10px;
  color: #888;
}

.search-bar input {
  border: none;
  outline: none;
  background: none;
  width: 100%;
  font-size: 16px;
  color: #333;
}

.search-bar input:focus {
  background: none;
}

.badges {
  display: flex;
  gap: 10px;
}

.badge {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
  border-radius: 100px;
  padding: 15px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  min-width: 40px;
  height: 40px;
}

.badge font-awesome-icon {
  margin-right: 5px;
}

.badge span {
  font-weight: bold;
  color: #333;
}

.activeClass {
  color: orangered;
}

.inactiveClass {
  color: gray;
}

.auth-buttons {
  display: flex;
  gap: 10px;
}

.register-btn {
  background-color: transparent;
  border: 2px solid #333; /* Change this color to match the one in the image */
  border-radius: 50px; /* Circular border */
  color: #333;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.register-btn:hover {
  background-color: #f4f4f4; /* Light background on hover */
}

.login-btn {
  background-color: #333; /* Dark background for Login */
  border: none;
  border-radius: 50px;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.login-btn:hover {
  background-color: #555; /* Slightly lighter color on hover */
}
</style>