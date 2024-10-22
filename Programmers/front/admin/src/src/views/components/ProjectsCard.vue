<template>
  <div class="card">
    <div class="card-body d-flex flex-column align-items-start">
      <div class="img-container">
        <img :src="img || 'empty_image.png'" class="img-fluid rounded" alt="Project Image" />
      </div>
      <h6 class="mb-0 text-sm title">{{ title }}</h6>
      <p class="text-sm mb-3 description">{{ description }}</p>
      <button @click="goToDetails(id)" class="btn btn-primary">View details</button>
    </div>
  </div>

</template>

<script>
import router from "@/router/index.js";

export default {
  name: "ProjectsCard",
  props: {
    img: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      required: true,
    },
    id: {
      type: String,
      required: true,
    }
  },
  methods: {
    goToDetails(id) {
      router.push({ name: "Course Details", params: { id } });
    },
  },
};
</script>

<style scoped>
.card {
  margin-bottom: 20px;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.img-container {
  width: 100%;
  height: 200px; /* Фиксированная высота */
  overflow: hidden; /* Скрывает часть изображения, выходящую за границы */
  border-radius: 10px;
}

.img-container img {
  width: 100%; /* Ширина изображения 100% от контейнера */
  height: 100%; /* Высота изображения 100% от контейнера */
  object-fit: cover; /* Заполнение контейнера, сохраняя пропорции */
}

.title {
  font-weight: bold;
  color: #333;
  margin-top: 15px;
}

.description {
  color: #666;
}

.btn {
  margin-top: auto; /* Отодвигает кнопку вниз */
  padding: 10px 20px;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: bold;
  text-transform: uppercase;
  transition: background-color 0.3s, transform 0.3s;
}

.btn-primary {
  background-color: #55dd47;
  color: #fff;
  border: none;
}

.btn-primary:hover {
  background-color: #0056b3;
  transform: translateY(-2px);
}
</style>
