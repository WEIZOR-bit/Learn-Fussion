<script setup>
import {ref} from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from 'axios';
import {useUserStore} from "@/stores/userStore.js";

library.add(faEye, faEyeSlash);

const userStore = useUserStore();

const showPassword = ref(false);
const email = ref('');
const password = ref('');
const isButtonDisabled = ref(false);
const loginButtonText = ref('Log in');

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

if (userStore.isAuthenticated) {
  window.location.href='/';
}

const handleSubmit = async (event) => {
  event.preventDefault();
  isButtonDisabled.value = true;

  try {
    const response = await axios.post('http://localhost:8000/api/public/login', {
      email: email.value,
      password: password.value,
    });

    const token = response.data.token.access_token;
    localStorage.setItem('jwt_token',token);
    userStore.setToken(token);
    window.location.href = '/';

  } catch (error) {
    console.log(error);
    toast.error(error.response.data.message, {
      position: toast.POSITION.BOTTOM_RIGHT,
    });
    isButtonDisabled.value = false;
  }
};
</script>

<template>
  <div class="container-wrapper">
    <div class="left-section">
      <img alt="filler image" class="logo" src="@/assets/login_circle.svg" />
    </div>
    <div class="right-section">
      <img alt="Project logo" class="logo" src="@/assets/logo.png" />
      <form class="form-wrapper" @submit="handleSubmit">

        <h3>Login</h3>

        <div class="input-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" v-model="email" placeholder="name@gmail.com"/>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <input :type="showPassword ? 'text' : 'password'"
                   id="password" v-model="password" placeholder="12345678" />
            <button
                type="button"
                class="toggle-button"
                @click="togglePasswordVisibility"
            >
              <font-awesome-icon
                  :icon="showPassword ? 'eye-slash' : 'eye'"
              />
            </button>
          </div>
        </div>

        <div class="options">
          <div class="remember-me">
            <input type="checkbox" id="remember"/>
            <label for="remember">Remember me</label>
          </div>
          <a href="/password-reset" class="forgot-link">Forgot?</a>
        </div>

        <button type="submit" class="action-button" :disabled="isButtonDisabled">{{ loginButtonText }}</button>

        <p class="signup-text">
          Don't have an account? <a href="/signup">Sign up</a>
        </p>
      </form>
    </div>
  </div>
</template>

<style scoped>

.container-wrapper {
  display: flex;
  height: 100%;
  overflow: hidden;
}

.left-section {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  scale: 3;
  z-index: 1;
}

.right-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 2rem;
  z-index: 2;
}

.logo {
  max-width: 150px;
}

.form-wrapper {
  width: 100%;
  max-width: 400px;
  padding: 2rem;
  color:black;
}

.form-wrapper h3{
  text-align: center;
  font-weight: bold;
  margin-bottom: 1rem;
}

.input-group {
  margin-bottom: 1.5rem;
}

.input-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.input-group input {
  width: 100%;
  padding: 0.75rem;
  border-radius: 30px;
  border: 1px solid #ddd;
  background-color: #f3f4f7;
  outline: none;
}

.input-group input::placeholder {
  color: #b1b1b1;
}

.options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.remember-me {
  display: flex;
  align-items: center;
}

.remember-me input {
  margin-right: 0.5rem;
}

#remember {
  stroke: #7d57f5;
}

.forgot-link {
  color: #9b64e5;
  text-decoration: none;
}

.forgot-link:hover {
  text-decoration: underline;
  background: none;
}

.action-button {
  width: 100%;
  padding: 0.75rem;
  background-color: #7d57f5;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 30px;
  cursor: pointer;
}

.action-button:hover {
  background-color: #6c48d3;
}

.action-button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
  opacity: 0.6;
}

.signup-text {
  margin-top: 1.5rem;
  text-align: center;
}

.signup-text a {
  color: #9b64e5;
  text-decoration: none;
}

.signup-text a:hover {
  text-decoration: underline;
  background: none;
}

input[type="checkbox"] {
  appearance: none;
  -webkit-appearance: none;
  display: flex;
  align-content: center;
  justify-content: center;
  font-size: 2rem;
  padding: 0.1rem;
  border: 0.25rem solid #7d57f5;
  border-radius: 0.5rem;
}

input[type="checkbox"]::before {
  content: "";
  width: 0.8rem;
  height: 0.8rem;
  clip-path: polygon(20% 0%, 0% 20%, 30% 50%, 0% 80%, 20% 100%, 50% 70%, 80% 100%, 100% 80%, 70% 50%, 100% 20%, 80% 0%, 50% 30%);
  transform: scale(0);
  background-color: #7d57f5;
}

input[type="checkbox"]:checked::before {
  transform: scale(1);
}

.input-with-icon {
  position: relative;
}

.input-with-icon input {
  width: calc(100% - 40px);
  padding-right: 40px;
}

.toggle-button {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
}

.toggle-button:hover {
  opacity: 0.7;
}

</style>