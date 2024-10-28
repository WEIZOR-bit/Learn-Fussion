<script setup>
  import {useUserStore} from "@/stores/userStore.js";

  const userStore = useUserStore();

  userStore.fetchUser();

  let socket = io('/', {
    autoConnect: true
  });

  socket.on('connect', () => {
    console.log('socket connected')
  });

  socket.on('disconnect', (data) => {
    console.log('disconnect')
    console.log(data)
  });
</script>

<script>
import { io } from 'socket.io-client';
</script>

<template>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quattrocento:wght@400;500;700&display=swap" rel="stylesheet">
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


