<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/store/userStore';
import router from "@/router/index.js";


const user = ref({
  name: '',
  email: '',
  password: '',
});


const userStore = useUserStore();


const addUser = async () => {
    await userStore.addUser(user.value);

    console.log('Redirecting to Users page...');

    await router.push({name: 'Users'});
};
</script>

<template>
  <form @submit.prevent="addUser">
    <!-- Name -->
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input
          v-model="user.name"
          type="text"
          class="form-control"
          id="name"
          placeholder="Enter user name"
          required
      />
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input
          v-model="user.email"
          type="email"
          class="form-control"
          id="email"
          placeholder="Enter user email"
          required
      />
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input
          v-model="user.password"
          type="password"
      class="form-control"
      id="password"
      placeholder="Enter user password"
      required
      />
    </div>


    <button @click="addUser" type="submit" class="btn btn-success mt-4">Add User</button>
  </form>
</template>

<style scoped>

</style>
