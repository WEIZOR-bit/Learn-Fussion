<script setup>
import { ref } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Add icons to the library
library.add(faEye, faEyeSlash);

// Refs to toggle visibility
const showPassword = ref(false);

// Toggle password visibility
const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

</script>

<template>
  <div class="login-container">
    <div class="left-section">
      <img alt="filler image" class="logo" src="@/assets/login_circle.svg" />
    </div>
    <div class="right-section">
      <img alt="Project logo" class="logo" src="@/assets/logo.png" />
      <form class="login-form">

        <div class="input-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" placeholder="name@gmail.com"/>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <input
                :type="showPassword ? 'text' : 'password'"
                id="password"
                placeholder="12345678"
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

        <div class="options">
          <div class="remember-me">
            <input type="checkbox" id="remember"/>
            <label for="remember">Remember me</label>
          </div>
          <a href="#" class="forgot-link">Forgot?</a>
        </div>

        <button type="submit" class="login-button">Log in</button>

        <p class="signup-text">
          Don't have an account? <a href="/register">Sign up</a>
        </p>
      </form>
    </div>
  </div>
</template>

<style scoped>

.login-container {
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
  margin-bottom: 2rem;
}

.login-form {
  width: 100%;
  max-width: 400px;
  padding: 2rem;
  color:black;
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

.login-button {
  width: 100%;
  padding: 0.75rem;
  background-color: #7d57f5;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 30px;
  cursor: pointer;
}

.login-button:hover {
  background-color: #6c48d3;
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