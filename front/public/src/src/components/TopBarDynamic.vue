<script setup>
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSearch,faFire,faHeart,faHeartBroken,faBolt} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
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

    <div class="badges">
      <div class="badge">
        <font-awesome-icon
            :icon="'fa-fire'"
            class="font-icon"
            :class="{ activeClass: streakDays > 0, inactiveClass: !(streakDays > 0) }"
        /> <span>{{ streakDays }}</span>
      </div>
      <div class="badge">
        <font-awesome-icon
            :icon="hearts > 0 ? 'fa-heart' : 'fa-heart-broken'"
            class="font-icon"
            style="color: indianred;"
        /> <span>{{ hearts }}</span>
      </div>
      <div class="badge">
        <font-awesome-icon
            :icon="'fa-bolt'"
            class="font-icon"
            style="color: #f4ce1a;"
        /> <span>{{ mastery_level }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    streakDays: {
      type: Number,
      required: true
    },
    hearts: {
      type: Number,
      required: true
    },
    mastery_level: {
      type: Number,
      required: true
    }
  },
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