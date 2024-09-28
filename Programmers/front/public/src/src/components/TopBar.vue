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

    <div v-if="statsLoaded" class="badges">
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
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      user: {
        streakDays: '',
        mastery_level: '',
        hearts: ''
      },
      statsLoaded: false,
    };
  },
  async mounted() {
    await this.fetchUserStats();
  },
  methods: {
    async fetchUserStats() {
      try {
        const response_user = await axios.get('http://localhost:8000/api/public/me');

        this.user.id = response_user.data.id;

        let response_stats = await axios.get(`http://localhost/api/public/profile/users/${this.user.id}/stats`);

        this.user = {
          streakDays: response_stats.data.streakDays,
          mastery_level: response_stats.data.masteryLevel,
          hearts: response_stats.data.hearts,
        };

        this.statsLoaded = true;

      } catch (error) {
        console.error('Error fetching user data:', error);
        this.statsLoaded = false;
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
  height: 5%;
  width: 98%;
  margin: 5px auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: white;
  padding: 10px;
  border-radius: 30px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.search-bar {
  display: flex;
  align-items: center;
  background-color: #f4f4f4;
  padding: 10px 15px;
  border-radius: 30px;
  flex-grow: 1;
  margin-right: 20px;
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
  border-radius: 50%;
  padding: 10px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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

</style>