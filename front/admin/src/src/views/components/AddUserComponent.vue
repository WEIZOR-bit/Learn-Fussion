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
  await router.push({ name: 'Users' });
};

const back = () => {
  router.back();
}
</script>

<template>
  <div class="add-user-page py-4 container-fluid">
    <div class="card mb-4">
      <div class="card-header">
        <h6>Добавить нового пользователя</h6>
      </div>
      <div class="card-body pb-2">
        <form @submit.prevent="addUser">
          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input
                v-model="user.name"
                type="text"
                class="form-control"
                id="name"
                placeholder="Введите имя пользователя"
                required
            />
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                v-model="user.email"
                type="email"
                class="form-control"
                id="email"
                placeholder="Введите email пользователя"
                required
            />
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input
                v-model="user.password"
                type="password"
                class="form-control"
                id="password"
                placeholder="Введите пароль пользователя"
                required
            />
          </div>

          <!-- Submit Button -->
          <div class="nav-buttons">
            <button type="submit" class="btn btn-success mt-4">Добавить пользователя</button>
            <button type="button" @click="back" class="btn btn-outline-dark mt-4">Назад</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.add-user-page {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  background-color: #f4f5f7;
}

.card {
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.form-label {
  font-weight: 500;
  color: #344767;
}

.btn {
  padding: 12px 24px;
  border-radius: 30px;
  font-size: 0.9rem;
  font-weight: bold;
  text-transform: uppercase;
  transition: background-color 0.3s ease;
}

.btn-success {
  background-color: #62d8a3;
  color: #fff;
  border: none;
}

.btn-success:hover {
  background-color: #4ec38b;
}

.btn-outline-dark {
  border: 2px solid #62d8a3;
  color: #62d8a3;
}

.btn-outline-dark:hover {
  background-color: #62d8a3;
  color: white;
}

.nav-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 40px;
}
</style>
