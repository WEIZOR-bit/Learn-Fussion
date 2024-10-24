<script setup>
import {ref} from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import axios from "axios";
import {toast} from "vue3-toastify";
import {useUserStore} from "@/stores/userStore.js";

library.add(faEye, faEyeSlash);

const userStore = useUserStore();

const showPassword = ref(false);
const username = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const isAgreementChecked = ref(false);
const isButtonDisabled = ref(false);
const signupButtonText = ref('Sign up');

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
    const response = await axios.post('http://localhost:8000/api/public/signup', {
      name: username.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });

    const token = response.data.token.access_token;
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

        <h3>Sign Up</h3>

        <div class="input-group">
          <label for="username">Username</label>
          <input
              type="text"
              id="username"
              placeholder="JohnDoe"
              v-model="username"
          />
        </div>

        <div class="input-group">
          <label for="email">E-mail</label>
          <input
              type="email"
              id="email"
              placeholder="name@gmail.com"
              v-model="email"
          />
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <input
                :type="showPassword ? 'text' : 'password'"
                id="password"
                placeholder="12345678"
                v-model="password"
            />
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

        <div class="input-group">
          <label for="confirm_password">Confirm password</label>
          <div class="input-with-icon">
            <input
                :type="showPassword ? 'text' : 'password'"
                id="confirm_password"
                placeholder="12345678"
                v-model="password_confirmation"
            />
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

        <div class="user-agreement">
          <input type="checkbox" id="agreement" v-model="isAgreementChecked"/>
          <label for="agreement">I accept the <span>User Agreement</span></label>
        </div>

        <button type="submit" class="action-button" :disabled="!isAgreementChecked || isButtonDisabled">{{signupButtonText}}</button>

        <p class="signin-text">
          Already have an account? <a href="/login">Sign in</a>
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

.user-agreement {
  display: flex;
  align-items: center;
  margin-bottom: 2rem;
}

.user-agreement input {
  margin-right: 0.5rem;
}

.user-agreement span {
  color: #9b64e5;
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
  transition: 0.3s;
}

.action-button:hover {
  background-color: #6c48d3;
}

.action-button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
  opacity: 0.6;
}

.signin-text {
  margin-top: 1.5rem;
  text-align: center;
}

.signin-text a {
  color: #9b64e5;
  text-decoration: none;
}

.signin-text a:hover {
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