<template>
  <div class="card">
    <div class="card-body d-flex flex-column align-items-start">
      <img :src="img" class="img-fluid rounded mb-3" alt="Project Image" />
      <h6 class="mb-0 text-sm">{{ title }}</h6>
      <p class="text-sm mb-3">{{ description }}</p>
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
  },
  };
</script>

<style scoped>
.card {
  margin-bottom: 20px;
}
</style>
