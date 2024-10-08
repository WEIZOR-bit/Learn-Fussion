<script setup>
  const TEN_MINUTES = 10 * 60 * 1000;

  onMounted(() => {
    const checkToken = async () => {
      const token = localStorage.getItem('jwt_token');
      const lastChecked = localStorage.getItem('last_token_check');

      const currentTime = Date.now();

      // There is a token stored and was last checked more than 10 minutes before
      if (token && (!lastChecked || currentTime - lastChecked > TEN_MINUTES)) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        try {
          const response = await axios.get('http://localhost:8000/api/public/validate-token');

          if (!response.data.valid) {
            localStorage.removeItem('jwt_token');
            delete axios.defaults.headers.common['Authorization'];
          } else {
            localStorage.setItem('last_token_check', currentTime.toString());
          }
        } catch (error) {
          toast.error('Error checking authorization', {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        }
      }
      else if (token && currentTime - lastChecked < TEN_MINUTES) { // Present token was valid less than 10 minutes ago
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      }
    };

    
    checkToken();
  });

  let socket = io('/', {
    autoConnect: true
  });

  socket.on('connect', () => {
    console.log('connect')
  });

  socket.on('disconnect', (data) => {
    console.log('disconnect')
    console.log(data)
  });
</script>

<script>
import axios from "axios";
import { io } from 'socket.io-client';
import {toast} from "vue3-toastify";
import {onMounted} from "vue";
</script>

<template>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
  <div id="app">
    <RouterView />
  </div>
</template>

<style scoped>

#app {
  min-height: 100vh;
  width: 100vw;
  display: flex;
  flex-direction: column;
}

</style>

<style>
html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, #fff 0%, #fff 70%,#fcd4fc 100%);
  overflow-x: hidden;
  font-family: 'Montserrat', sans-serif;
}

</style>


