<template>
  <div class="loader">
    <div class="loader-circle"></div>
    <div class="loader-text">Loading...</div>
  </div>
</template>

<script setup>
// Здесь можно добавить любые необходимые настройки или методы, если потребуется
</script>

<style scoped>
.loader {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh; /* Занимает всю высоту экрана */
}

.loader-circle {
  width: 50px; /* Размер круга */
  height: 50px; /* Размер круга */
  border: 8px solid rgba(0, 255, 0, 0.3); /* Полупрозрачный зеленый цвет */
  border-top: 8px solid green; /* Яркий зеленый цвет */
  border-radius: 50%; /* Круглая форма */
  animation: spin 1s linear infinite; /* Анимация вращения */
}

.loader-text {
  margin-top: 10px; /* Отступ сверху */
  font-size: 20px; /* Размер текста */
  color: green; /* Цвет текста */
  font-weight: bold; /* Жирный шрифт */
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
