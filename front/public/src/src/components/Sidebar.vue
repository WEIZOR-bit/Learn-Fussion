<script setup>
import { library } from '@fortawesome/fontawesome-svg-core';
import {faHome, faBook, faStar, faTrophy, faComments, faSignOutAlt, faAddressBook, faUser} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

library.add(faHome, faBook, faStar, faTrophy, faComments, faSignOutAlt,faAddressBook, faUser);
</script>

<template>
  <div class="sidebar">
    <div class="logo">
      <img src="@/assets/logo.png" alt="Logo">
    </div>
    <ul>
      <li></li>
      <li @click="navigateTo('home')">
        <font-awesome-icon :icon="'fa-home'" class="font-icon" /> Main
      </li>
      <li @click="navigateTo('courses')">
        <font-awesome-icon :icon="'fa-book'" class="font-icon" /> Courses
      </li>
      <li @click="navigateTo('rating')">
        <font-awesome-icon :icon="'fa-star'" class="font-icon" /> Rating
      </li>
      <li @click="navigateTo('challenges')">
        <font-awesome-icon :icon="'fa-trophy'" class="font-icon" /> Challenges
      </li>
      <li @click="navigateTo('forum')">
        <font-awesome-icon :icon="'fa-comments'" class="font-icon" /> Forum
      </li>
      <li @click="navigateTo('about')">
        <font-awesome-icon :icon="'fa-address-book'" class="font-icon" /> About Us
      </li>
    </ul>
    <ul class="settings" v-if="userLoggedIn">
      <li @click="navigateTo('profile')">
        <font-awesome-icon :icon="'fa-user'" class="font-icon" /> Profile
      </li>
      <li @click="logout">
        <font-awesome-icon :icon="'fa-sign-out-alt'" class="font-icon" /> Logout
      </li>
    </ul>
  </div>
</template>

<script>
import axios from "axios";
import {toast} from "vue3-toastify";

export default {
  data() {
    return {
      userLoggedIn: false,
    };
  },
  mounted() {
    if (axios.defaults.headers.common['Authorization']) {
      this.userLoggedIn = true;
    }
  },
  methods: {
    navigateTo(page) {
      this.$router.push({ name: page });
    },
    async logout() {
      try {
        if (axios.defaults.headers.common['Authorization'] === '') {
          toast.error('Please log in first.', {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
          return;
        }

        const response = await axios.post('http://localhost:8000/api/public/logout', {}, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('jwt_token')}`
          }
        });

        console.log(response.data);

        axios.defaults.headers.common['Authorization'] = '';
        localStorage.removeItem('jwt_token');

        this.$router.push({name: 'home'});
        this.userLoggedIn = false;

      } catch (error) {
        console.log(error);
        toast.error(error.response.data.message, {
          position: toast.POSITION.BOTTOM_RIGHT,
        });
      }
    }
  }
}
</script>

<style scoped>
.sidebar {
  width: 200px;
  background-color: #f4f4f4;
  padding: 20px;
  flex-shrink: 0;
}

.sidebar .logo img {
  width: 100%;
  height: auto;
  object-fit: contain;
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.sidebar ul li {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  cursor: pointer;
  color: black;
}

.sidebar ul li i {
  margin-right: 10px;
  color: black;
}

.settings ul li {
  color: black;
}

.font-icon {
  margin: 5px 10px 5px 5px;
}
</style>