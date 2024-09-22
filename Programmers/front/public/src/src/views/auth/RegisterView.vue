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

        <h3>Register</h3>

        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" placeholder="JohnDoe" />
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

        <div class="input-group">
          <label for="confirm_password">Confirm password</label>
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

        <div class="user-agreement">
          <input type="checkbox" id="agreement" />
          <label for="agreement">I accept the <span>User Agreement</span></label>
        </div>

        <button type="submit" class="action-button">Sign up</button>

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
}

.action-button:hover {
  background-color: #6c48d3;
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