
<script>
import { RouterLink, RouterView } from 'vue-router'
import axios from "axios";
import { io } from 'socket.io-client';

let socket = io('/', {
  autoConnect: true
});

socket.on('connect', (data) => {
  console.log('connect')
})

socket.on('disconnect', (data) => {
  console.log('disconnect')
  console.log(data)
})

socket.on ('socket.ping', (data) => {
  console.log("Pinged");
})

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
  },
}
</script>

<template>
  <div id="app">
    <header>
      <img alt="Vue logo" class="logo" src="@/assets/logo.png" />

      <div class="wrapper">
        <h1> Public </h1>
        <button @click="login">Login</button>
        <button @click="logout">Logout</button>
        <button @click="signup">Signup</button>
        <button @click="sendView">Send View</button>
        <button @click="create">Create</button>
        <button @click="destroy">Destroy</button>
      </div>
    </header>

    <RouterView />
  </div>
</template>

<style scoped>

#app {
  min-height: 100vh; /* Ensures it covers the full viewport height */
  width: 100vw; /* Full width of the viewport */
  display: flex;
  flex-direction: column;
}

header {
  width: 100%;
  height: 5vh; /* Using vh for consistency with the rest of the layout */
  background: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1rem;
  color: black;
  box-sizing: border-box;
}

.wrapper {
  display: flex;
  gap: 1rem;
  flex: 1;
  justify-content: space-evenly;
  align-items: center;
}

button {
  background-color: #0f6674;
  color: white;
  font-weight: bold;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #0a4650;
}

.logo {
  height: 80%;
  width: auto;
  max-height: 80%;
  max-width: 125px;
}

h1 {
  margin: 0;
}

</style>

<!-- Global styles to affect the entire page -->
<style>
html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, #fff 0%, #fff 70%,#fcd4fc 100%);
  overflow-x: hidden; /* Prevent horizontal scroll */
}

body {

}
</style>


