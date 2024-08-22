<<<<<<< HEAD
<script>
import { RouterLink, RouterView } from 'vue-router'
import axios from "axios";
export default {
  methods: {
    async sendView() {
      const response = await axios.get('http://0.0.0.0:80/api/public/courses',)
      console.log(response.data);
    },
   async login() {
     const response = await axios.post('http://0.0.0.0:80/api/public/login', {
       email: 'john12@gmail.com',
       password: '123123123123'})
     console.log(response.data);
     const token = response.data.token.access_token;
     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },

    async logout() {
      const response = await axios.post('http://0.0.0.0:80/api/public/logout')
      console.log(response.data);
    },

    async signup() {
      const response = await axios.post('http://0.0.0.0:80/api/public/signup', {
        email: 'john12@gmail.com',
        password: '123123123123',
        name: 'Johner',
        password_confirmation: '123123123123'})
      console.log(response.data);
      const token = response.data.token.access_token;
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },
    async create() {
      const response = await axios.post('http://0.0.0.0:80/api/admin/courses', {
        name: 'designer',
        average_rating: '123123123123',
        description: 'description',
        review_count: 0,
        created_by: 'AdminOdium',
        updated_by: 'AdminOdium',})
      console.log(response.data);
    },
  }
}
</script>

<template>
  <header>
    <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" />

    <div class="wrapper">
      <h1> Public </h1>
      <button @click="login">Login</button>
      <button @click="logout">logout</button>
      <button @click="signup">Signup</button>
      <button @click="sendView">sendView</button>
      <button @click="create">create</button>
      <button @click="destroy">destroy</button>

    </div>
  </header>

  <RouterView />
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
