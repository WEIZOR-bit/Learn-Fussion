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
  <div class="container-wrapper">
    <div class="left-section">
      <img alt="filler image" class="logo" src="@/assets/login_circle.svg" />
    </div>
    <div class="right-section">
      <img alt="Project logo" class="logo" src="@/assets/logo.png" />
      <form class="form-wrapper">

        <h3>Password reset</h3>

        <div class="input-group">
          <label for="password">New password</label>
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

        <div class="input-group">
          <label for="confirm_password">Reenter new password</label>
          <div class="input-with-icon">
            <input
                :type="showPassword ? 'text' : 'password'"
                id="confirm_password"
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

        <button type="submit" class="action-button">Submit</button>

        <div id="link-container">
          <a href="/login">Log in</a>
          <a href="/register">Sign up</a>
        </div>

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

.action-button {
  width: 100%;
  padding: 0.75rem;
  background-color: #7d57f5;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 30px;
  cursor: pointer;
  margin-bottom: 1rem;
}

.action-button:hover {
  background-color: #6c48d3;
}

#link-container {
  display: flex;
  gap: 0.5rem;
}

#link-container > a {
  flex: 1;
  display: block;
  background: none;
  border: 1px solid #7d57f5;
  border-radius: 30px;
  cursor: pointer;
  color: #6c48d3;
  text-align: center;
}

#link-container > a:hover {
  border: 1px solid #5037a3;
  color: #5037a3;
  font-weight: bold;
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